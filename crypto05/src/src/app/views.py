from flask import render_template, request, jsonify, session
from Crypto.Cipher import AES
from app import app, FLAG
from os import urandom
from base64 import b64encode, b64decode

# Global variables
AES_KEY = urandom(16)
IV = b"\x00" * 16

def generate_equation():
    a = 0
    while a == 0:
        a = urandom(1)[0] % 100
    b = urandom(1)[0] % 100
    c = urandom(1)[0] % 100
    return f"{a}x + {b} = {c}", (c - b) / a

"""
Il ciphertext è nel seguente formato a blocchi da 16 bytes:
|nome_random|;pts={punti}|
"""
def encrypt(points):
    # Serializza i dati in una stringa custom con nome casuale lungo 16 bytes
    data = urandom(8).hex()
    # Dopo il nome inserisci i punti con 11 cifre intere (e.g. 0000000001) e padding per arrivare a 16 bytes
    data += f";pts={points:011d}"
    cipher = AES.new(AES_KEY, AES.MODE_CBC, IV)
    ct = cipher.encrypt(data.encode())
    return ct

def decrypt(token):
    cipher = AES.new(AES_KEY, AES.MODE_CBC, IV)
    data = cipher.decrypt(token)
    # Rimuovi il nome random e ";pts="
    data = data[16:].split(b";pts=")[1]
    # Ritorna i punti
    return int(data)

@app.route("/", methods=["GET", "POST"])
def index():
    if request.method == "POST":
        token = request.form.get("sessionToken")
        if token:
            token = b64decode(token)
            session["points"] = decrypt(token)
    points = session.get("points", 0)
    # Stampa la flag se hai 1MLD di punti :P
    if points >= 1_000_000_000:
        return render_template("flag.html", flag=FLAG)
    equation, solution = generate_equation()
    session["solution"] = round(solution, 2)
    return render_template("index.html", points=points, equation=equation)

@app.route("/solve", methods=["POST"])
def solve():
    json_data = request.get_json()
    solution = float(json_data["solution"])
    if solution == session.get("solution"):
        session["points"] = session.get("points", 0) + 1
    return jsonify({"correct": solution == session.get("solution")})

@app.route("/save_session")
def save_session():
    points = session.get("points", 0)
    token = b64encode(encrypt(points))
    return jsonify({"token": token.decode()})

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
