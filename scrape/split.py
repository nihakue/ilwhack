from bs4 import BeautifulSoup
import os

def remove_name(speech):
    remove_to_index = speech.find(':')
    return speech[remove_to_index:]

def write_soup(soup, filename):
    f = open(filename, 'w')
    speech = str(soup)
    speech.replace('\xa0', ' ')
    speech.replace('\xc2', '')
    f.write(speech)
    f.close()


def main():
    speech_soup = BeautifulSoup(open('speeches/sp00000.txt'))
    count = 0

    entities = speech_soup.find_all('entity')

    for i, entity in enumerate(entities):
        biggest = str(len(entities))
        filename = 'speeches/sp' + str(count).zfill(len(biggest)) + '.txt'
        print filename + ' of ' + str(len(entities))
        f = open(filename, 'w')
        speech = str(entity)
        speech.replace('\xa0', ' ')
        speech.replace('\xc2', '')
        f.write(speech)
        f.close()
        count += 1

if __name__ == '__main__':
    main()
