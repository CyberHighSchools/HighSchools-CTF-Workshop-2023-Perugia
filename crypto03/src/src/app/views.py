from flask import render_template, request
from app import app, FLAG
from os import urandom

# Esegui lo xor tra una chiave e un messaggio, se la chiave è più corta del messaggio ripetila
def xor(key, data):
    res = bytearray()
    for i in range(len(data)):
        res.append(data[i] ^ key[i % len(key)])
    return res

def encrypt(data):
    key = urandom(8)
    return xor(key, data.encode()).hex()

@app.route("/", methods=["GET", "POST"])
def index():
    if request.method == "GET":
        return render_template("index.html")
    name = request.form.get("inputName")
    if name is None or FLAG is None:
        return render_template("index.html", message="Something went wrong")
    return render_template("index.html", message=encrypt(name + FLAG))

# SKIP
@app.route("/source")
def get_source():
    source = ["\n"]
    with open(__file__) as f:
        try:
            for line in f:
                if line == "# SKIP\n":
                    while line != "# /SKIP\n":
                        line = next(f)
                    continue
                source.append(line)
        except StopIteration:
            pass
    return render_template("source.html", source="".join(source))
# /SKIP
