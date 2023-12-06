from flask import render_template, jsonify
from app import app, FLAG
import random

@app.route("/")
def index():
    return render_template("index.html")

# Esegui lo xor tra una chiave e un messaggio, se la chiave è più corta del messaggio ripetila
def xor(key, data):
    res = bytearray()
    for i in range(len(data)):
        res.append(data[i] ^ key[i % len(key)])
    return res

def encrypt(seed, data):
    # Inizializza il seed con il numero scelto
    random.seed(seed)
    # Genera una chiave di 4 bytes
    # key = random.getrandbits(32).to_bytes(4, "big").hex() # DEBUG per vedere la chiave in hex
    key = random.getrandbits(32).to_bytes(4, "big")
    return xor(key, data)

@app.route("/play/<int:number>")
def play_lottery(number):
    flag = encrypt(number, str(FLAG).encode()).hex()
    return jsonify({"message": f"Ecco la tua flag: {flag}"}), 200

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
