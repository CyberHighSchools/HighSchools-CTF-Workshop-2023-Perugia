#!/bin/python3

import os
import requests
import logging
from string import ascii_lowercase, ascii_uppercase
import random
logging.disable()

# Per le challenge web
URL = os.environ.get("URL", "http://localhost:8000")
if URL.endswith("/"):
   URL = URL[:-1]

def rot_n(string, n):
    rot = ""
    for c in string:
        if c in ascii_lowercase:
            rot += ascii_lowercase[(ascii_lowercase.index(c) + n) % 26]
        elif c in ascii_uppercase:
            rot += ascii_uppercase[(ascii_uppercase.index(c) + n) % 26]
        else:
            rot += c
    return rot

# Check challenge
num = random.randint(1, 25)
resp = requests.get(f"{URL}/play/{num}").json()
flag = rot_n(resp["message"].split(": ")[1], -num)

print(flag)
