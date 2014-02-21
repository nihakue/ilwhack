import requests

def add_speech(name, topic, date, mood):
    payload = {'politician_name': name,
    'topic_name': topic,
    'date': date,
    'mood': mood}

