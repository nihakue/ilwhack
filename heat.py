import nltk.classify.util
import os
from nltk.corpus import movie_reviews
from nltk.classify import NaiveBayesClassifier
from bs4 import BeautifulSoup
from split import write_soup

def get_classifier():
    negids = movie_reviews.fileids('neg')
    posids = movie_reviews.fileids('pos')

    negfeats = [(word_feats(movie_reviews.words(fileids=[f])), 'neg')
                for f in negids]
    posfeats = [(word_feats(movie_reviews.words(fileids=[f])), 'pos')
                for f in posids]

    poscutoff = len(posfeats) * 3/4
    negcutoff = len(negfeats) * 3/4

    trainfeats = negfeats[:negcutoff] + posfeats[:poscutoff]
    testfeats = negfeats[negcutoff:] + posfeats[poscutoff:]

    print 'train on %d instances, test on %d instances' % (len(trainfeats),
                                                           len(testfeats))
    classifier = NaiveBayesClassifier.train(trainfeats)
    return classifier

def main():
    classifier = get_classifier()
    entities = os.listdir('speeches')
    for i, filename in enumerate(entities):
        print '%0.2f percent done' % (1.0 * i/len(entities))
        filename = 'speeches/' + filename
        soup = BeautifulSoup(open(filename))
        try:
            speech_tag = soup.find('speech')
            speech = speech_tag.get_text()
        except AttributeError:
            print 'broken speech at %s' % filename
            continue
        words = speech.split()
        speech_feats = word_feats(words)
        label = classifier.classify(speech_feats)

        if soup.find('label'):
            label_tag = soup.find('label')
            label_tag.string = label
        else:
            label_tag = soup.new_tag('label')
            label_tag.string = label
            speech_tag.insert_after(label_tag)

        write_soup(soup, filename)

def word_feats(words):
    return dict([(word, True) for word in words])




if __name__ == '__main__':
    main()
