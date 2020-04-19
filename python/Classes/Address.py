# coding=utf-8
import re


class Address:

    def __init__(self):
        pass

    @staticmethod
    def checkIsAddress(text):
        regex = r"(^\d{5}|^\d{3})?\D+[縣市]\D+?[市區|鎮區|鎮市|鄉鎮市區].+"

        matches = re.finditer(regex, text, re.MULTILINE)

        return enumerate(matches, start=1)

    @staticmethod
    def getAddressesFromSoupBody(bodyDom):

        addressResults = []

        for dom in bodyDom:

            if (dom.text):
                try:
                    index = dom.text.index('地址')
                    addressResults.append(dom.text)
                except ValueError:
                    pass
            addressResults = Address.getMatchedAddress(addressResults)
            addressResults = Address.getBest3MatchAddress(addressResults)

        return addressResults

    @staticmethod
    def getMatchedAddress(addresses):

        addressResults = []

        for address in addresses:
            filteredResult = Address.checkIsAddress(address)

            for matchNum, match in filteredResult:
                matchedText = match.group()
                if len(matchedText) <= 50:
                    matchedText = \
                        matchedText \
                            .replace('地址', '') \
                            .replace("!@#$%^&*()[]{};:,./<>?\|'`~-=_+", "") \
                            .replace("\r", "") \
                            .replace("\n", "") \
                            .replace("：", "") \
                            .replace(" ", "") \
                            .replace("】", "") \
                            .replace("【", "")

                    addressResults.append(matchedText)

        return addressResults

    @staticmethod
    def getBest3MatchAddress(addresses):

        # remove duplicate address
        addresses = list(dict.fromkeys(addresses))
        addresses.sort(key=len)

        if len(addresses) <= 3:
            return addresses
        else:
            return addresses[:3]
