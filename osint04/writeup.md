# 4th HighSchools CTF Workshop - Perugia 2023

## [OSINT] Il rosso e il nero

La sfida richiede di saper sfruttare i giusti strumenti per l'analisi dei domini internet. In questo caso si tratta di collegare due domini tramite l'uso di uno strumento per analizzare il traffico dei visitatori: il Google Tag Manager, o GTM.

La richiesta della sfida è trovare l'unico dominio che condivida lo stesso GTM del A.C. Milan, ovvero https://www.acmilan.com, che non faccia parte dell'associazione, e che appartenga chiaramente ad un paese diverso dall'Italia. Queste informazioni vengono dedotte dal titolo di lavoro "addetto alla presenza pubblicitaria online della squadra all'estero".

La sfida può essere completata servendosi del tool https://builtwith.com che richiede una registrazione gratuita per poter accedere alla sezione "Relationship".

### Individuazione dell'obiettivo

Per cominciare bisogna individuare uno dei siti usati dall'A.C. Milan che potrebbe usare un GTM, e https://www.acmilan.com può essere sufficiente.

### Analisi delle relazioni

Utilizzando la casella di ricerca di [BuiltWith](https://builtwith.com/) si arriverà alla pagina del sito in questione. Tra i vari strumenti di analisi, quello richiesto per completare la sfida è la tab "Relationship" che mostra tutti i tag che condivide un sito web con altri.
Nella pagina "Relationship" sono presenti svariati tag usati nel tempo dall'associazione e quello che servirà alla sfida è `GTM-KGXM4F`, essendo l'unico Google Tag Manager.

### Filtro delle informazioni

Aprendo la pagina dedicata del GTM, verrà mostrato lo storico dell'utilizzo nel tempo. Già dalle prime rige si può vedere un sito che si distingue dai precedenti per il top level domain: **whipcake.ru**. Gli altri siti che hanno come dominio acmilan.com devono essere ignorati poiché la sfida richiede di trovare altri mercati. Come conferma che sia proprio questo il sito richiesto dalla sfida basterà vedere il periodo di utilizzo del GTM da parte di whipcake.ru: 1 giorno, che, come richiesto, è "un breve periodo di tempo".
