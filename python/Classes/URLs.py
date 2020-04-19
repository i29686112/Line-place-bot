# coding=utf-8


import requests
from bs4 import BeautifulSoup


class URLs:

    def __init__(self):
        pass

    @staticmethod
    def getSoupBodyFromURL(url):

        r = requests.get(url)

        if r.status_code == requests.codes.ok:
            soup = BeautifulSoup(r.text, 'html.parser')
            return soup.body()


        else:
            return []
