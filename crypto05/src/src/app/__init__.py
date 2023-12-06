from os import environ
from flask import Flask

app = Flask(__name__)
app.secret_key = environ.get("FLASK_SECRET_KEY")

FLAG = environ.get("FLAG")

# Importing views here is a workaround for a circular import error.
from app import views
