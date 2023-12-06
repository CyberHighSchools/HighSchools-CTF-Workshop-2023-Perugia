from os import environ
from flask import Flask

FLAG = environ.get("FLAG")
app = Flask(__name__)

# Importing views here is a workaround for a circular import error.
from app import views
