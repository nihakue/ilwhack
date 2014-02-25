import os
import sys
from bs4 import BeautifulSoup
from pymongo import MongoClient
from datetime import datetime

def generate_payload(soup):
    try:
        name = soup.find('name').get_text().strip()
        topic = soup.find('topic').get_text().strip()
        datestring = soup.find('date').get_text().strip()
        date = datestring
        # date = datetime.strptime(datestring, "%d %B %Y")
        speech = soup.find('speech').get_text().strip()
        mood = soup.find('label').get_text().strip()
    except AttributeError:
        print 'broken entry'
        return None

    return {
    'name': name,
    'topic': topic,
    'date': date,
    'speech': speech,
    'mood': mood
    }

def main():
    speeches_folder = sys.argv[1]
    if not os.path.exists(speeches_folder):
        print 'Could not find %s' % speeches_folder
        sys.exit(0)

    client = MongoClient('50.62.81.20')
    db = client.moodsp
    speeches = db.speeches

    filenames = os.listdir(speeches_folder)
    for i, filename in enumerate(filenames):
        print (100.0 * i/len(filenames))
        soup = BeautifulSoup(open(speeches_folder + '/' + filename))
        payload = generate_payload(soup)
        if payload:
            speeches.insert(payload)

    client.close()


if __name__ == '__main__':
    main()
