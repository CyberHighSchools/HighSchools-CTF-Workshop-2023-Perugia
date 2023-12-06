#!/bin/python3

import os
import requests
from pwn import *
import logging
logging.disable()

# Per le challenge web
URL = os.environ.get("URL", "http://todo.challs.todo.it")
if URL.endswith("/"):
   URL = URL[:-1]

# Se challenge tcp
HOST = os.environ.get("HOST", "todo.challs.todo.it")
PORT = int(os.environ.get("PORT", 34001))

# Check challenge
flag = "flag{todo}"
print(flag)