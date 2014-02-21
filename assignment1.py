#Assignment 1
#Gabriel West - s1365736

import nltk
from pprint import pprint
from nltk.corpus import inaugural
from nltk.corpus import stopwords
from twitter import twc

#The last two weekdays in the twitter corpus
l2_twc_words = twc.words(fileids=twc.fileids()[-3:-1])

stops = [w for w in stopwords.words('english')]


#Question 1, 2, 5, 7 etc. solution
def avg_word_length(corpus, punctuation=True):
    '''Calculate the average word length in a corpus or corpus subset.
    Used to answer question 1 and 2 particularly'''
    try:
        #First try treating the corpus as a word list
        word_lengths = [
        len(word) for word in set(v.lower()
            for v in corpus
            if punctuation or v.isalnum())
        ]
    except TypeError:
        try:
            #We need a third level of recursion if we're actually
            #passed a corpus
            word_lengths = [
                len(word) for word in set(v.lower()
                for file in corpus.fileids()
                for v in corpus.words(file)
                if punctuation or v.isalnum())
                ]
        except TypeError:
            print 'Please use a corpus or a list of words'
            raise

    return sum(word_lengths) * 1.0 / len(word_lengths)

#Question 4, 5, 7 solution
def word_freq(corpus, punctuation=True):
    #If the corpus is a list of words, access it directly. Otherwise try to
    #treat it like an nltk corpus.
    try:
        freq_dist = nltk.FreqDist(word.lower()
                                  for word in corpus
                                  if punctuation or word.isalnum())
    except TypeError:
        freq_dist = nltk.FreqDist(word.lower()
                                  for file in corpus.fileids()
                                  for word in corpus.words(file)
                                  if punctuation or word.isalnum())
    return freq_dist


#Used for question 8
def avg_token_length(corpus, punctuation=True):
    #If the corpus is a list of words, access it directly. Otherwise
    #try to treat it like an nltk corpus.
    try:
        word_lengths = [len(word) for word in corpus
                        if punctuation or word.isalnum()]
    except TypeError:
        #Might be a corpus. Let's give that a shot
        try:
            word_lengths = [
                len(word.lower())
                for file in corpus.fileids()
                for word in corpus.words(file)
                if punctuation or word.isalnum()
                ]
        except TypeError:
            print 'corpus needs to be an nltk corpus or a list of words'
            raise

    return sum(word_lengths) * 1.0 / len(word_lengths)

#Used in question 9
def num_word_types_for_speech(speech_name, punctuation=True):
    word_types = set(v.lower()
                    for v in inaugural.words(speech_name)
                    if (punctuation or v.isalnum())
                    and v not in stops)
    return len(word_types)

#Used in question 10 and 11
def rank(fd, sample):
    '''
    Given a sample and a nltk FreqDist, compute the sample's ranking
    in the FreqDist based on the number of times that sample occurs

    :param fd: nltk.FreqDist used to rank the sample
    :type fd: nltk.FreqDist

    :param sample: The sample whose rank is to be determined
    :type sample: token occuring in fd (string)

    '''
    #Get the number of times our sample appears in the FreqDist
    c = fd[sample]
    #Sum over counts of all samples that occured more than c times
    #(If our sample were the only sample that occured c times, our rank
    #would be p + 1)
    p = sum(fd.Nr(r) for r in range(c+1, fd[fd.max()] + 1))
    #Calculate the average number of samples that occur
    #c times((n + 1) / 2)
    #Then calculate the shared rank by adding that to p
    return p + ((fd.Nr(c) + 1) / 2.0)


def answers():
#     ____                 _   _               __
#    / __ \               | | (_)             /_ |
#   | |  | |_   _  ___ ___| |_ _  ___  _ __    | |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   | |
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  | |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  |_|
#
#
    print 'Question 1:\n'
    answer_1 = avg_word_length(inaugural)
    print answer_1
#     ____                 _   _               ___
#    / __ \               | | (_)             |__ \
#   | |  | |_   _  ___ ___| |_ _  ___  _ __      ) |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \    / /
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  / /_
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_| |____|
#
#
    print '\nQuestion 2:\n'
    answer_2 = avg_word_length(l2_twc_words)
    print answer_2
#     ____                 _   _               ____
#    / __ \               | | (_)             |___ \
#   | |  | |_   _  ___ ___| |_ _  ___  _ __     __) |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   |__ <
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  ___) |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_| |____/
#
#
    print '\nQuestion 3:\n'
    answer_3 = '''
    There appears to be a large difference of ~3 to the average word length.
    however, it looks like the tokenization used on the
    twitter corpus couldn't
    tokenize the japanese tweets -- or any other non-ascii language
    tweets for that matter -- instead treating them as single words.
    This falsely inflates the average word length by quite a bit.
    '''
    print answer_3
#     ____                 _   _               _  _
#    / __ \               | | (_)             | || |
#   | |  | |_   _  ___ ___| |_ _  ___  _ __   | || |_
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \  |__   _|
#   | |__| | |_| |  __\__ | |_| | (_) | | | |    | |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|    |_|
#
#
    print '\nQuestion 4: \n'
    answer_4 = {'inaugural': word_freq(inaugural).items()[:10],
                'twitter': word_freq(l2_twc_words).items()[:10]}
    print 'Top 10 in inaugural:'
    pprint(answer_4['inaugural'])
    print '\nTop 10 in twitter:'
    pprint(answer_4['twitter'])
#     ____                 _   _               _____
#    / __ \               | | (_)             | ____|
#   | |  | |_   _  ___ ___| |_ _  ___  _ __   | |__
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \  |___ \
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  ___) |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_| |____/
#
#
    print '\nQuestion 5: \n'
    answer_5 = {}
    answer_5['inaugural_avg'] = avg_word_length(inaugural,
                                                punctuation=False)
    answer_5['twitter_avg'] = avg_word_length(l2_twc_words,
                                              punctuation=False)
    answer_5['inaugural_fd_10'] = word_freq(inaugural,
                                            punctuation=False).items()[:10]
    answer_5['twitter_fd_10'] = word_freq(l2_twc_words,
                                          punctuation=False).items()[:10]

    print 'Excluding punctuation:\n'
    print ('Inaugural average word length: %(inaugural_avg).2f\n'
    'Twitter average word length: %(twitter_avg).2f\n' % answer_5)
    print 'Inaugural top ten:'
    pprint(answer_5['inaugural_fd_10'])
    print ''
    print 'Twitter top ten:'
    pprint(answer_5['twitter_fd_10'])

#     ____                 _   _                 __
#    / __ \               | | (_)               / /
#   | |  | |_   _  ___ ___| |_ _  ___  _ __    / /_
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \  | '_ \
#   | |__| | |_| |  __\__ | |_| | (_) | | | | | (_) |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  \___/
#
#
    print '\nQuestion 6: \n'
    my_twc_tok = nltk.RegexpTokenizer('((http:[\/\w\.]+)|(\#*\w+|[^\w\s]+))')
    xtwc = nltk.corpus.PlaintextCorpusReader("/group/ltg/projects/fnlp/",
            r'2.*\.txt',
            word_tokenizer=my_twc_tok,
            sent_tokenizer=nltk.LineTokenizer(),
            para_block_reader=nltk.corpus.reader.read_line_block)

    pprint(xtwc.sents("20100128.txt")[:10])
#     ____                 _   _               ______
#    / __ \               | | (_)             |____  |
#   | |  | |_   _  ___ ___| |_ _  ___  _ __       / /
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \     / /
#   | |__| | |_| |  __\__ | |_| | (_) | | | |   / /
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  /_/
#
#
    print 'Question 7: \n'
    answer_7 = {}
    l2_xtwc_words = xtwc.words(fileids=xtwc.fileids()[-3:-1])
    answer_7['twitter_avg'] = avg_word_length(l2_xtwc_words,
                                              punctuation=False)
    answer_7['twitter_fd_10'] = word_freq(l2_xtwc_words,
                                          punctuation=False).items()[:10]
    print 'Average: %.2f' % answer_7['twitter_avg']
    pprint(answer_7['twitter_fd_10'])
#     ____                 _   _                ___
#    / __ \               | | (_)              / _ \
#   | |  | |_   _  ___ ___| |_ _  ___  _ __   | (_) |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   > _ <
#   | |__| | |_| |  __\__ | |_| | (_) | | | | | (_) |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  \___/
#
#
    print 'Question 8: \n'

    answer_8 = {}
    answer_8['inaugural_avg'] = avg_token_length(inaugural.words(),
                                                 punctuation=False)
    answer_8['twitter_avg'] = avg_token_length(l2_xtwc_words,
                                                 punctuation=False)
    print 'Inaugural  token average:'
    print answer_8['inaugural_avg']
    print 'Twitter token average:'
    print answer_8['twitter_avg']
#     ____                 _   _                ___
#    / __ \               | | (_)              / _ \
#   | |  | |_   _  ___ ___| |_ _  ___  _ __   | (_) |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   \__, |
#   | |__| | |_| |  __\__ | |_| | (_) | | | |    / /
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|   /_/
#
#
    print '\nQuestion 9: \n'
    speeches = {}
    for filename in inaugural.fileids():
        year = filename[:4]
        speeches[year] = num_word_types_for_speech(filename)

    pprint(speeches)
    fd = nltk.FreqDist(speeches)
    fd.plotSorted(title="Speech Complexity", key=lambda fd, s: s)
#     ____                 _   _               __  ___
#    / __ \               | | (_)             /_ |/ _ \
#   | |  | |_   _  ___ ___| |_ _  ___  _ __    | | | | |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   | | | | |
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  | | |_| |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  |_|\___/
#
#
    print '\nQuestion 10: \n'
    washington = [s for s in inaugural.fileids() if 'Washington' in s]
    bush = [s for s in inaugural.fileids() if 'Bush' in s]
    obama = [s for s in inaugural.fileids() if 'Obama' in s]
    w_first = nltk.FreqDist(w.lower() for w in inaugural.words(washington[0]))
    b_first = nltk.FreqDist(w.lower() for w in inaugural.words(bush[0]))
    o_first = nltk.FreqDist(w.lower() for w in inaugural.words(obama[0]))
    print '"country" ranks %.2fst in Washington\'s first.' % rank(w_first,
                                                                'country')
    print '"country" ranks %.2fst in Bush\'s first.' % rank(b_first,
                                                          'country')
    print '"country" ranks %.2fst in Obama\'s first.' % rank(o_first,
                                                          'country')
#     ____                 _   _               __ __
#    / __ \               | | (_)             /_ /_ |
#   | |  | |_   _  ___ ___| |_ _  ___  _ __    | || |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   | || |
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  | || |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  |_||_|
#
#
    print '\nQuestion 11: \n'

    print 'Please see function definitions for comments'
#     ____                 _   _               __ ___
#    / __ \               | | (_)             /_ |__ \
#   | |  | |_   _  ___ ___| |_ _  ___  _ __    | |  ) |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   | | / /
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  | |/ /_
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  |_|____|
#
#
    print '\nQuestion 12: \n'
    twc_hash_09 = [w.lower() for w in twc.words(fileids='20091118.txt')
                    if w.startswith('#')]
    twc_hash_10 = [w.lower() for w in twc.words(fileids='20100128.txt')
                    if w.startswith('#')]

    h_fd_09 = nltk.FreqDist(twc_hash_09)
    h_fd_10 = nltk.FreqDist(twc_hash_10)
    h_fd_09.plot(30, title='2009-11-18.txt top 30')
    h_fd_10.plot(30, title='2010-01-28.txt top 30')
#     ____                 _   _               __ ____
#    / __ \               | | (_)             /_ |___ \
#   | |  | |_   _  ___ ___| |_ _  ___  _ __    | | __) |
#   | |  | | | | |/ _ / __| __| |/ _ \| '_ \   | ||__ <
#   | |__| | |_| |  __\__ | |_| | (_) | | | |  | |___) |
#    \___\_\\__,_|\___|___/\__|_|\___/|_| |_|  |_|____/
#
#
    print '\nQuestion 13: \n'

    print '''
    The first thing that I notice about these two distributions is that
    they are at least a little bit zipfian. I don't ever know if that's
    mind blowing or not.

    The second noteworthy thing is that the top hashtag in 2009 isn't
    even present in the top 30 of 2010's tweets. While #jobs, and some
    other less frequent hashtags appear in both. This indicates that there
    are at least two classes of trends on twitter: very popular short-lived
    trends (fads), and slightly less present, but still popular
    trends (fashion). Perhaps there is a third, even less popular,
    even more consistent trend (classics).

    We can also see that frequency is a little more evenly distributed
    in the 2010 samples. I'm going to hypothesize wildly here and say that
    this could have something to due with Twitter 'going mainstream',
    and the diversification of tastes as a result. We could look at the variance
    of hashtag frequencies as a function of #of twitter users to find out more.
    '''

if __name__ == '__main__':
    answers()
