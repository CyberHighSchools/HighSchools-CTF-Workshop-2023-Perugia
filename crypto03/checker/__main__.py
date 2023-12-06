#!/bin/python3

import os
import requests
import logging
from bs4 import BeautifulSoup
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
name = "A" * 8
soup = BeautifulSoup(requests.post(f"{URL}/", data={"inputName": name}).text, 'html.parser')
try:
    flag = soup.find("div", {"id": "flag"}).get_text(strip=True)
except AttributeError:
    print("Error: flag not found")
    exit(1)
key = xor(name.encode(), bytes.fromhex(flag)[:8])
flag = xor(key, bytes.fromhex(flag)[8:]).decode()

print(flag)
