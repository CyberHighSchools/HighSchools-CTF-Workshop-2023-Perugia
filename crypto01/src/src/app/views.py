from flask import render_template, jsonify
from app import app, FLAG
from string import ascii_lowercase, ascii_uppercase

@app.route("/")
def index():
    return render_template("index.html")

# implement a function that does ROT n where n is the number provided
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

@app.route("/play/<int:number>")
def play_lottery(number):
    if (number > 0 and number < 26):
        return jsonify({"message": f"Ecco la tua flag: {rot_n(FLAG, number)}"}), 200
    else:
        return jsonify({"error": "Numero non valido"}), 400
