'''some helpful tools for processing the natural languages'''

import nltk

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
