import sys

from Classes import Address
from Classes import URLs

try:
    url = sys.argv[1]
    bodyDom = URLs.URLs.getSoupBodyFromURL(url)
    print(Address.Address.getAddressesFromSoupBody(bodyDom))
except:
    bodyDom = URLs.URLs.getSoupBodyFromURL('https://www.walkerland.com.tw/article/view/257122?page=full')
    print(Address.Address.getAddressesFromSoupBody(bodyDom))
