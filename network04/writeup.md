# 4th HighSchools CTF Workshop - Perugia 2023

## [network] DMARC Naming System

Il file di cattura contiene molte richieste DNS, ma possiamo notare che una in particolare è stata fatta interrogando il campo TXT.

### Soluzione

In Wireshark filtriamo le richieste che contengono il campo txt applicando il seguente filtro di visualizzazione:

```txt
dns.txt
```

La richiesta DNS filtrata sarà unica, dove all'interno del campo TXT troviamo una stringa in base64

```txt
Domain Name System (response)
    Transaction ID: 0xa777
    Flags: 0x8580 Standard query response, No error
    Questions: 1
    Answer RRs: 1
    Authority RRs: 0
    Additional RRs: 1
    Queries
    Answers
        localhost: type TXT, class IN
            Name: localhost
            Type: TXT (Text strings) (16)
            Class: IN (0x0001)
            Time to live: 604800 (7 days)
            Data length: 83
            TXT Length: 82
            TXT: https://datatracker.ietf.org/doc/html/rfc7489 ZmxhZ3t0eHRfcmVjMHJkX3VzM2Nhc2VzfQ==
    Additional records
        <Root>: type OPT
            Name: <Root>
            Type: OPT (41)
            UDP payload size: 1232
            Higher bits in extended RCODE: 0x00
            EDNS0 version: 0
            Z: 0x0000
            Data length: 28
            Option: COOKIE
    [Request In: 633]
    [Time: 0.001801524 seconds]

```

Il campo contiene due stringhe: un riferimento a RFC7489 - Domain-based Message Authentication, Reporting, and Conformance,
e la flag in Base64 da decodificare.
