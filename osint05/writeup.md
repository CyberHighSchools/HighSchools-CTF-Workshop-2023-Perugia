# 4th HighSchools CTF Workshop - Perugia 2023

## [OSINT] Token trapelato

La sfida richiede di saper navigare la cronologia dei commit di una repository per risalire a informazioni, solo in apparenza, perse.

L'obiettivo è trovare il token di autorizzazione del [bot di Telegram Volta il Dado Bot](https://t.me/volta_il_dado_bot). Un bot di Telegram è un'istanza server che si interfaccia agli utenti tramite chat su Telegram.

La sfida è completabile anche senza un account Telegram, ma bisognerebbe essere in possesso del [link del canale degli aggiornamenti](https://t.me/volta_il_dado_bot_updates).

### Individuazione del bot

La descrizione della sfida parla di un bot chiamato "Volta il Dado Bot", e la sua istanza può essere trovata facilmente cercando il nome su Telegram. Toccando il risultato si aprirà una conversazione con un messaggio di introduzione "Giochiamo a dadi! Per aggiornamenti visitate il canale dedicato".
Tra i risultati apparirà anche un [canale contenente gli aggiornamenti sullo sviluppo del bot](https://t.me/volta_il_dado_bot_updates).

### Individuazione della repository

La repository del codice sorgente del bot può essere trovata in più modi.

#### Tramite bot

Uno dei comandi messi a disposizione dal bot, `/repo`, trovabile dal menu laterale della chat, invia un messaggio contenente il [link alla repository GitHub](https://github.com/RoboRich00A16/volta-il-dado-bot).

#### Tramite canale

Il canale [Aggiornamenti su Volta il Dado Bot](https://t.me/volta_il_dado_bot_updates), raggiungibile anche dal bot tramite comando `/news`, contiene una serie di messaggi inviati in broadcast dallo sviluppatore del bot. Il primo contiene anche il [link alla repository GitHub](https://github.com/RoboRich00A16/volta-il-dado-bot). Questo rende la sfida risolvibile anche senza avviare il server che gestisce il bot, poiché il canale è sempre online.

#### Tramite GitHub

È possibile anche cercare il nome del bot direttamente sulla piattaforma GitHub, essendo una scelta popolare di hosting di repository, si potrebbe cercare la soluzione direttamente da lì. Il primo risultato della ricerca sarà proprio la [repository con il codice sorgente](https://github.com/RoboRich00A16/volta-il-dado-bot).

#### Tramite motore di ricerca

È improbabile che il bot, il canale o la repository vengano indicizzate, ma si può comunque giungere alla repositori tramite semplice ricerca sul web.

### Esplorazione dei commit

Una volta raggiunta la pagina principale della repository, è disponibile un pulsante che permette di vedere l'[elenco dei cambiamenti fatti al codice](https://github.com/RoboRich00A16/volta-il-dado-bot/commits/main). Tra i vari commit, uno ha un titolo che salta all'occhio: "Update main.py" con l'icona di un lucchetto e una chiave. Aprendo la [vista delle differenze del commit `8faa4c3`](https://github.com/RoboRich00A16/volta-il-dado-bot/commit/8faa4c34082b1403ce120895f3669e3f8c271d50) si noterà che la riga 87, contenente il token, è stata corretta. Poiché si tratta di un commit di correzione, il token è presente anche nel [commit precedente](https://github.com/RoboRich00A16/volta-il-dado-bot/commit/7b395baa03b638f5cfe28081b5b14ec7e0765189). In entrambi i casi, per completare la sfida, bisognerà inviare `flag{1937213116:AAFRzNy_Rj4BianiJvVN7Gjt5kdKcS6l33s}`.
