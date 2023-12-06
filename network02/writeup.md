# 4th HighSchools CTF Workshop - Perugia 2023

## [network] Beautiful Content

Il file di cattura contiene una richiesta HTTP verso la risorsa `/uploads/dear_ted.jpeg`.

Utilizzando come filtro di visualizzazione `http`, notiamo che i flussi d'interesse riguardano solamente due host.

### Soluzione

Risulta possibile esportare la risorsa JPEG cliccando su:

```text
File -> Esporta oggetti -> HTTP
```

e selezioniamo il file `dear_ted.jpeg`.
Aprendolo, la flag è scritta all'interno dell'immagine.
