# 4th HighSchools CTF Workshop - Perugia 2023

## [network] A careless admin

Il file di cattura contiene vari pacchetti di diversa natura. Tra questi concernono la connessione ad un server web mediante protocollo HTTP.

Analizzando i pacchetti HTTP possiamo notare alcune richieste verso una risorsa `/login`, dove il server risponde in maniera positiva (200 OK).

Per filtrare le richieste / risposte HTTP utilizziamo l'omonimo filtro in lowercase, cioè `http`.

```text
Frame 2111: 610 bytes on wire (4880 bits), 610 bytes captured (4880 bits) on interface any, id 0
Linux cooked capture v1
Internet Protocol Version 4, Src: 172.17.0.1, Dst: 172.17.0.2
Transmission Control Protocol, Src Port: 54200, Dst Port: 8000, Seq: 1, Ack: 1, Len: 542
Hypertext Transfer Protocol
    POST /login HTTP/1.1\r\n
    Host: 172.17.0.1:4000\r\n
    User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/116.0\r\n
    Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8\r\n
    Accept-Language: en-US,en;q=0.5\r\n
    Accept-Encoding: gzip, deflate\r\n
    Content-Type: application/x-www-form-urlencoded\r\n
    Content-Length: 62\r\n
    Origin: http://172.17.0.1:4000\r\n
    Connection: keep-alive\r\n
    Referer: http://172.17.0.1:4000/\r\n
    Upgrade-Insecure-Requests: 1\r\n
    \r\n
    [Full request URI: http://172.17.0.1:4000/login]
    [HTTP request 1/1]
    [Response in frame: 2115]
    File Data: 62 bytes
HTML Form URL Encoded: application/x-www-form-urlencoded
    Form item: "username" = "admin"
    Form item: "password_input" = "ZmxhZ3t0aDFzX3dzXzFzX2ZyNGcxbDN9"
        Key: password_input
        Value: ZmxhZ3t0aDFzX3dzXzFzX2ZyNGcxbDN9
```

## Soluzione

L'ultima risposta HTTP del server contiene la flag in base64, che coincide con la password utilizzata per autenticarsi al server web.
