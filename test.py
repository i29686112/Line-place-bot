#coding=utf-8

import sys
import requests
from bs4 import BeautifulSoup

url=sys.argv[1]


r = requests.get(url)

if r.status_code == requests.codes.ok:
    soup = BeautifulSoup(r.text, 'html.parser')
    print(soup.title)
else:
    print('error with http code:'+r.status_code)
