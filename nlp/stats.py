'''Using mongodb magic, update the stats for each member of parliament'''

from pymongo import MongoClient
import nlp_toolkit as nlp
import pickle
from nltk.corpus import stopwords
import nltk.data
import nltk
import os
import pdb
import itertools

stops = [w for w in stopwords.words('english')]
tagger = pickle.load(open("treebank_brill_aubt.pickle"))


def main():
    client = MongoClient('50.62.81.20')
    msps = client.moodsp.msps
    speeches = client.moodsp.speeches
    total = msps.count()

    for i, msp in enumerate(msps.find()):
        #Calculate the stats for each msp
        name = msp['name']
        print 'name: %s' % name
        print '%.2f' % (1.0 * i / total)

        #We're not messing with updates right now, so skip if populated
        if msp.has_key('awl'):
            pass
        else:
            msp_speeches = speeches.find({'name': name})
            if not msp_speeches.count():
                continue
            #We have to somehow clean the unicode characters. :(
            words = [word.encode('ascii', 'ignore')
                        for entry in msp_speeches
                        for word in entry['speech'].split()]


            awl = nlp.avg_word_length(words, punctuation=False)
            msps.update({'name': name}, {'$set': {'awl': awl}})

            print 'avg_word_length: %.2f' % awl

            tagged_words = tagger.tag(words)
            nouns = [n for (n, pos) in tagged_words if 'NN' in pos]
            verbs = [v for (v, pos) in tagged_words if 'VBD' in pos]
            nf = nlp.word_freq(nouns, punctuation=False)
            vf = nlp.word_freq(verbs, punctuation=False)
            top_ten_nouns = nf.items()[:10]
            top_ten_verbs = vf.items()[:10]
            msps.update({'name': name}, {'$set': {'ttn': top_ten_nouns}})
            msps.update({'name': name}, {'$set': {'ttv': top_ten_verbs}})



            #Now let's compute happiness
            pos = speeches.find({'name': name, 'mood': 'pos'})
            neg = speeches.find({'name': name, 'mood': 'neg'})
            #we want to range between 1 and 10 inclusive
            try:
                overall_happiness = ((1.0 * pos.count() / (pos.count() + neg.count())) * 10)
            except ZeroDivisionError:
                pass
            else:
                print 'overall: %.2f' % overall_happiness
                msps.update({'name': name}, {'$set': {'overall_mood': overall_happiness}})
        #Compute month happiness

        if msp.has_key('month_moods'):
            pass
        else:

            last_five_months = ['October',
            'November', 'December', 'January', 'February']
            for month in last_five_months:
                mon_pos = speeches.find({'name': name,
                                            'mood': 'pos',
                                            'date':{'$regex': month}})
                mon_neg =   speeches.find({'name': name,
                                            'mood': 'neg',
                                            'date':{'$regex': month}})
                try:
                    month_happiness = ((1.0 * mon_pos.count() / (mon_pos.count() + mon_neg.count())) * 10)
                    msps.update({'name': name},
                            {'$push': {'month_moods': month_happiness}})
                except:
                    pass
        #Now let's compute happiness for each topic
        # topics = msp_speeches.distinct('topic')
        # for topic in topics:
        #     pos = speeches.find({'name': name, 'topic': topic, 'mood': 'pos'})
        #     neg = speeches.find({'name': name, 'topic': topic, 'mood': 'neg'})
        #     topic_happiness = (1.0 * pos.count() / (pos.count() + neg.count())) * 10
        #     msps.update({'name': name},
        #                 {'$set': {'topic_mood': {topic: topic_happiness}}})



    client.close()
if __name__ == '__main__':
    main()
