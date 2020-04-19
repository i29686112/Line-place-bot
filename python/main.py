import sys

from Classes import Address
from Classes import PlaceName
from Classes import URLs

if len(sys.argv) > 1:
    url = sys.argv[1]
else:
    url = 'https://www.walkerland.com.tw/article/view/257122?page=full'

soup = URLs.URLs.getSoupFromURL(url)
resultDict = {'addresss'}
addresses = Address.Address.getAddressesFromSoupBody(soup.body())
placeNames = PlaceName.PlaceName.getPlaceNameKeywordsFromSoup(soup)

print({'addresses': addresses, 'placeNames': placeNames})
