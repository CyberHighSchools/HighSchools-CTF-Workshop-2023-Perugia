# 4th HighSchools CTF Workshop - Perugia 2023

## [web] Trading

Il sito è scritto in PHP e permette di comprare e vendere PGCoin e flag.

Ogni utente ha un saldo iniziale di 100€ con il quale può eseguire le operazioni di compravendita.

Il prezzo di un PGCoin è di 10€ e il prezzo della flag è di 110€.

Lo scopo della challenge è quello di riuscire a ottenere 110€ per comprare la flag.

## Vulnerabilità

### Race Condition

La race condition è una vulnerabilità che si verifica quando due o più processi accedono contemporaneamente ad una risorsa condivisa e la modifica.  
In questo caso specifico i processi accedono in lettura al saldo dell'utente e lo modificano in base all'operazione di compravendita che si vuole eseguire.

## Soluzione

Il sito contiene una race condition che permette di comprare PGCoin mandando il saldo in negativo, e, viceversa, venderli mandando il numero di PGCoin in negativo.

Eseguendo più operazioni in parallelo senza lock è possibile arrivare in una situazione in cui il codice delle due chiamate viene eseguito quasi in contemporanea, in questo caso specifico si può arrivare ad avere due o più processi che controllano il saldo contemporaneamente, e quindi, una volta verificato che il saldo in entrambi è sufficiente, eseguono l'acquisto o la vendita, le quali essendo operazioni di scrittura risulteranno essere più lente ma verranno comunque eseguite una dopo l'altra grazie alle priorietà `ACID` del database (in particolare la `I` di `Isolation`).

Sarà quindi possibile comprare o vendere PGCoin anche se non si ha realmente il saldo sufficiente.

Il nostro scopo è quello di vendere tantissimi PGCoin in parallelo in modo da arrivare ad avere un saldo superiore a quello iniziale. Raggiunti i 200€ sarà possibile comprare la Flag.

**Nota**: i bottoni vengono disabilitati una volta cliccati, quindi è necessario utilizzare uno script oppure eseguire la chiamata più volte manualmente (es ricaricando la pagina o aprendola in più schede).
