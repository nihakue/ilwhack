'''Helper script for taggins pos/neg labels in a large collection of speeches. Speeches should have <speech> tags surrounding the speech text. To run, type python tag.py. a speech will be presented, and then the user can input 1 for a positive speech, 0 for a negative speech'''

from bs4 import BeautifulSoup
import os

savefile = 'save.dat'
base_path = os.path.dirname(os.path.abspath(__file__))
save_path = os.path.join(base_path, savefile)
speeches_path = os.path.join(base_path, 'speeches')
pos_path = os.path.join(speeches_path, 'pos')
pos_path = os.path.join(speeches_path, 'neg')


def main():
    starting_num = 0
    valid_inputs = {'0': 'negative attitude', '1': 'positive attitude', 'exit': 'exit'}

    print "Let's make a corpus."
    if os.path.exists(save_path):
        with open(save_path) as f:
            starting_num = int(f.readline())
    rating = ''
    usr_input = ''
    current_num = starting_num
    while usr_input != 'exit':
        filename = 'sp' + str(current_num).zfill(5) + '.txt'
        filepath = os.path.join(speeches_path, filename)
        if not os.path.exists(filepath):
            print 'Speech does not exist. Exiting.'
            break
        speech_soup = BeautifulSoup(open(filepath))
        speech_text = speech_soup.find('speech').get_text()
        print speech_text
        usr_input = raw_input('>').lower()
        while usr_input not in valid_inputs:
            print valid_inputs
            usr_input = raw_input('please enter a valid input')
        rating = ''
        if usr_input == '0':
            rating = 'neg'
        elif usr_input == '1':
            rating = 'pos'
        with open(filepath, 'a') as f:
            f.write('\n<label>' + rating + '</label>')
        current_num += 1

    with open(save_path, 'w') as save:
        save.write(str(current_num))


if __name__ == '__main__':
    main()
