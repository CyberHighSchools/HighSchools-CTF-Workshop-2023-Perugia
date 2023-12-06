#!/bin/python3
import os
import logging
import re

from requests import Session


logging.disable()


URL = os.environ.get('URL', 'http://trova-le-soluzioni.challs.cyberhighschools.it')
if URL.endswith('/'):
   URL = URL[:-1]
s = Session()


res = s.get(f'{URL}/soluzioni-2023-2024/soluzioni/20231204.txt')


flag = re.search(r'flag{.*}', res.text).group(0)
print(flag)
