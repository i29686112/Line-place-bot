from unittest import TestCase

from Classes import Address
from Classes import URLs


class TestGet_address_from_url(TestCase):

    def test_get_address_from_url1(self):
        testUrl = 'https://travel.ettoday.net/article/1680721.htm?from=fb_et_travel'
        bodyDom = URLs.URLs.getSoupBodyFromURL(testUrl)
        address = Address.Address.getAddressesFromSoupBody(bodyDom)
        print(address)
        self.assertTrue(expr=len(address) > 0)

    def test_get_address_from_url2(self):
        # can't find any matches.
        testUrl = 'https://keketravel.cc/2988/?from=instant_article'
        bodyDom = URLs.URLs.getSoupBodyFromURL(testUrl)
        address = Address.Address.getAddressesFromSoupBody(bodyDom)
        print(address)
        self.assertTrue(expr=len(address) > 0)

    def test_get_address_from_url6(self):
        # can't find any matches because no keyword inside it.
        testUrl = 'https://travel.ettoday.net/article/1661579.htm?from=fb_et_travel'
        bodyDom = URLs.URLs.getSoupBodyFromURL(testUrl)
        address = Address.Address.getAddressesFromSoupBody(bodyDom)
        print(address)
        self.assertTrue(expr=len(address) > 0)

    def test_get_address_from_url7(self):
        testUrl = 'https://travel.yam.com/Article.aspx?sn=118046'
        bodyDom = URLs.URLs.getSoupBodyFromURL(testUrl)
        address = Address.Address.getAddressesFromSoupBody(bodyDom)
        print(address)
        self.assertTrue(expr=len(address) > 0)

    def test_get_address_from_url3(self):
        testUrl = 'https://www.walkerland.com.tw/article/view/256743'
        bodyDom = URLs.URLs.getSoupBodyFromURL(testUrl)
        address = Address.Address.getAddressesFromSoupBody(bodyDom)
        print(address)
        self.assertTrue(expr=len(address) > 0)

    def test_get_address_from_url4(self):
        testUrl = 'https://travel.yam.com/Article.aspx?sn=118195'
        bodyDom = URLs.URLs.getSoupBodyFromURL(testUrl)
        address = Address.Address.getAddressesFromSoupBody(bodyDom)
        print(address)
        self.assertTrue(expr=len(address) > 0)

    def test_get_address_from_url5(self):
        testUrl = 'https://www.walkerland.com.tw/article/view/257122?page=full'
        bodyDom = URLs.URLs.getSoupBodyFromURL(testUrl)
        address = Address.Address.getAddressesFromSoupBody(bodyDom)
        print(address)
        self.assertTrue(expr=len(address) > 0)
