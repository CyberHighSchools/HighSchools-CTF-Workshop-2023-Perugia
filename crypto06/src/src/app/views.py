from flask import render_template, jsonify
from Crypto.Util.number import isPrime, long_to_bytes
from app import app, FLAG
import random

@app.route("/")
def index():
    return render_template("index.html")

def xor(a, b):
    return bytes([x ^ y for x, y in zip(a, b)])

@app.route("/dh/<int:g>/<int:p>/<int:A>")
def send_pubkey(g, p, A):
    # Validate g, p, A
    if not 1 < g < p:
        return jsonify({"error": "Invalid g"})
    if not 2**512 < p < 2**1024 or not isPrime(p):
        return jsonify({"error": "Invalid p"})
    if not 1 < A < p:
        return jsonify({"error": "Invalid A"})
    # Validate flag
    if not FLAG:
        return jsonify({"error": "Something went wrong, contact the admin"})
    # Generate b
    b = random.randint(1, p-1)
    shared_key = pow(A, b, p)
    B = pow(g, b, p)
    encrypted_flag = xor(FLAG.encode(), long_to_bytes(shared_key))
    return jsonify({ "hexB": long_to_bytes(B).hex(), "hexFlag": encrypted_flag.hex()})


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
