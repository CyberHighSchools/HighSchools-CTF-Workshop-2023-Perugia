# 4th HighSchools CTF Workshop - Perugia 2023

## [OSINT] Open top container

La sfida richiede di saper individuare un obiettivo di interesse sfruttando registri pubblici. L'immagine allegata alla sfida rappresenta un container navale rosso in un porto non identificato.

### Analisi del container

Osservando il container si vedrà, in bianco, il suo codice identificativo stampato in verticale. Il codice è composto da quattro lettere seguite da sette cifre, inclusa la cifra riquadrata in basso. In questo caso il codice è `CAIU 560569 7`.

### Ricerca dell'identificativo

Dopo aver individuato il codice identificativo del container, sarà sufficiente cercare un qualsiasi strumento per la ricerca dei container, ad esempio https://www.track-trace.com/container (usufruibile senza registrazione).
Inserendo il codice `CAIU5605697` nella casella di ricerca, il sito rimanderà automaticamente ad una pagina del CAI contenente tutte le informazioni sul container, tra cui il luogo in cui si trova: **Singapore**.

### Problematiche

In un futuro il container potrebbe essere spostato da Singapore e invalidare la flag.
