from bs4 import BeautifulSoup
import urllib2

uf = open('urls2.txt', 'r')
url_list = uf.readlines()
url_list = [u.replace('\n', '') for u in url_list]
startnum = 1249


for i, url in enumerate(url_list):
    if i < startnum:
        continue
    print str(i) + ' of ' + str(len(url_list) - 1)
    try:
        html_source = urllib2.urlopen(url).read()
    except:
        continue
    with open(('urls2/url' + str(i).zfill(3) + '.txt'), 'w') as out_file:
        out_file.write(html_source)

