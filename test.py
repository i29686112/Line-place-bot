import requests
from bs4 import BeautifulSoup

r = requests.get('https://tw.yahoo.com/')

if r.status_code == requests.codes.ok:
  soup = BeautifulSoup(r.text, 'html.parser')

  stories = soup.find_all('a', class_='story-title')
  for s in stories:
    print(u"標題：" + s.text)
    #print("網址：" + s.get('href'))

