#!/bin/python3

import os
import requests
from Crypto.Util.number import bytes_to_long, long_to_bytes
import logging
logging.disable()

p = 13407807929942597099574024998205846127479365820592393377723561443721764030073546976801874298166903427690031858186486050853753882811946569946433649006084171
g = 2
a = 31337

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
A = pow(g, a, p)
res = requests.get(f"{URL}/dh/{g}/{p}/{A}").json()
B = bytes_to_long(bytes.fromhex(res["hexB"]))
flag = bytes.fromhex(res["hexFlag"])
K = long_to_bytes(pow(B, a, p))
flag = xor(K, flag).decode()

print(flag)
