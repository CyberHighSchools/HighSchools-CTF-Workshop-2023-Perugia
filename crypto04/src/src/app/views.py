from flask import render_template
from app import app, FLAG, XOR_KEY, BOOK_PAGE

# Esegui lo xor tra una chiave e un messaggio, se la chiave è più corta del messaggio ripetila
def xor(key, data):
    res = bytearray()
    for i in range(len(data)):
        res.append(data[i] ^ key[i % len(key)])
    return res

def encrypt(data):
    if not XOR_KEY:
        return "Something went wrong. Contact an admin."
    return xor(XOR_KEY.encode(), data.encode()).hex()

@app.route("/")
def index():
    if not FLAG:
        ciphertext = "Something went wrong. Contact an admin."
    else:
        ciphertext = encrypt(BOOK_PAGE + FLAG)
    return render_template("index.html", ciphertext=ciphertext)

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
