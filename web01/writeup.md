# 4th HighSchools CTF Workshop - Perugia 2023

## [web] Trova le soluzioni

Il sito si presenta come un semplice sito statico con una lista di verifiche.

Le verifiche sono salvate all'interno di un file di testo, il cui nome è la data di pubblicazione della verifica (es `20231204.txt`).

## Vulnerabilità

### Server misconfiguration

Nella maggior parte dei server web le configurazione di default attivano il listing dei file all'interno delle cartelle prive di file di indice (es `index.html`).

## Soluzione

Aprendo il link delle soluzioni della verifica di ottobre 2023 e cancellando dalla url del browser il nome del file sarà possibile accedere direttamente alla cartella.  
Al suo interno sono presenti anche le soluzioni dei prossimi compiti in classe: la flag si trova nel file `20231204.txt`.

Una soluzione alternativa è anche quella di indovinare direttamente il nome del file in quanto tutte le stringhe seguono lo stesso pattern di "anno", "mese", giorno": `YYYYMMDD.txt`.  
Tale procedimento funzionerebbe anche in server web con il listing dei file disabilitati.
