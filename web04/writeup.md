# 4th HighSchools CTF Workshop - Perugia 2023

## [web] Calcolatrice

Il sito è scritto in PHP e permette di eseguire operazioni matematiche.

## Vulnerabilità

### Remote Code Execution (RCE - PHP Code Injection)

La vulnerabilità è presente quando vengono utilizzate funzioni che permettono di eseguire codice a partire da una stringa e allo stesso tempo la stringa è inserita dall'utente, ma non viene effettuato alcun controllo su di essa.  
La funzione `eval()` permette di eseguire codice PHP a partire da una stringa, pertanto se viene utilizzata per eseguire una stringa inserita dall'utente si otterrà una vulnerabilità di tipo `RCE`.

## Soluzione

La calcolatrice esegue le operazioni inserite dall'utente tramite la funzione `eval()`, che in realtà non è una funzione dedicata al calcolo ma un metodo che permette di eseguire direttamente codice PHP.  
Pertanto è possibile eseguire codice arbitrario inserendo una qualsiasi istruzione PHP al posto di un'operazione matematica.  
Per esempio inserendo `phpinfo()` verrà visualizzata la pagina di informazioni di PHP, oppure inserendo `system('ls')` verrà eseguito il comando `ls` e verranno visualizzati i file presenti nella directory corrente.

La Flag è contenuta nelle variabile d'ambiente `FLAG`, pertanto per visualizzarla è sufficiente listare le variabili d'ambiente con uno dei seguenti input (non sono gli unici possibili, questi sono un esempio):

```php
var_dump(getenv())
system('printenv')
phpinfo()
```
