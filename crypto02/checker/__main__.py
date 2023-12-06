#!/bin/python3

import os
import requests
from pwn import *
import random
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

def encrypt(seed, data):
    random.seed(seed)
    key = random.getrandbits(32).to_bytes(4, "big")
    return xor(key, data)

# Check challenge
num = random.randint(1, 1000000)
resp = requests.get(f"{URL}/play/{num}").json()
flag = bytes.fromhex(resp["message"].split(": ")[1])
flag = encrypt(num, flag).decode()

print(flag)
