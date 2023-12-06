#!/bin/python3

import os
import requests
import logging
logging.disable()

XOR_KEY = os.environ.get("XOR_KEY", "Qu1dd1tcH")

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
resp = requests.get(URL).text.split("ciphertextHex = '")[1].split("';")[0]       # Hacky to get ciphertext from js
ciphertext = bytes.fromhex(resp)
flag = xor(XOR_KEY.encode(), ciphertext).decode().splitlines()[-1]

print(flag)
