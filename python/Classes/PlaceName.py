# coding=utf-8


class PlaceName:

    def __init__(self):
        pass

    @staticmethod
    def getPlaceNameKeywordsFromSoup(soup):
        try:
            keywords = soup.find('meta', attrs={'name': 'keywords'})['content']
        except:
            # handle ETToday website
            keywords = soup.find('meta', attrs={'name': 'news_keywords'})['content']

        return keywords
