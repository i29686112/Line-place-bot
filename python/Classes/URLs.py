# coding=utf-8


import requests
from bs4 import BeautifulSoup


class URLs:

    def __init__(self):
        pass

    @staticmethod
    def getSoupFromURL(url):

        r = requests.get(url)

        if r.status_code == requests.codes.ok:
            return BeautifulSoup(r.text, 'html.parser')


        else:
            return []
