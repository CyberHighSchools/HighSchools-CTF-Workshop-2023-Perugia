# 4th HighSchools CTF Workshop - Perugia 2023

## [forensics] Least Significant Brushwork

Dalla descrizione della challenge deduciamo che bisogna recuperare un segreto nascosto in una immagine PNG.

Il segreto infatti è nascosto applicando la codifica LSB nell'immagine, causando impercettibili cambiamenti sul canale R di alcuni pixel.

### Soluzione

Per recuperare la flag è sufficiente importare l'immagine su Cyberchef e applicare l'operazione `Extract LSB`, ottenendo questa stringa:

```text
ZmxhZ3toMWRpbmdfMXNfbjB0X2NpcGgzcmluZ30=
```

Notiamo che alla fine è presente un `=`, il che dovrebbe farci venire in mente la codifica della stringa in base64.
Quindi proviamo a decodificarla sempre su Cyberchef usando l'operazione `From Base64`, e otteniamo la flag.
