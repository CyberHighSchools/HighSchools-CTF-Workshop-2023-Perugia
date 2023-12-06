# 4th HighSchools CTF Workshop - Perugia 2023

## [OSINT] Pronto intervento

La sfida richiede di saper rintracciare il nome di una persona tramite notizie di cronaca in cui viene menzionata. Per poter risolvere questa sfida è necessario aver individuato nella sfida OSINT precedente ( "Sicurezza alla parata") il nome evento e quello della città in cui questo ha avuto luogo.

La sfida è basata sull'incidente avvenuto realmente alla Rose Festival’s Grand Floral Parade a Portland in Oregon, Stati Uniti il 10 giugno 2023, quando un uomo, alla guida di un pickup, ha scavalcato le barriere che chiudevano la strada in occasione della parata.

Il soggetto è stato in seguito inseguito da un agente della polizia in motocicletta.

### Analisi dei notiziari

Per risolvere la sfida bisogna analizzare i notiziari locali. Una sommaria ricerca su internet a riguardo porterà ad un [articolo di Oregon Live dal titolo "Video shows Portland driver plow past blockade onto Grand Floral parade route"](https://www.oregonlive.com/eastportland/2023/06/video-shows-portland-driver-who-plowed-past-blockade-onto-grand-floral-parade-route.html). Questo articolo non è l'unico a parlare dell'incidente e, soprattutto, non è l'unico a contenere le informazioni per ricavare la flag.

### Analisi dell'articolo

L'articolo riporta quanto accaduto dettagliatamente, con commenti dei testimoni diretti, e si parla anche dell'intervento di un ufficiale delle forze dell'ordine locali.

L'agente in questione sarebbe partito all'inseguimento del pickup in sella alla propria motocicletta. Il nome del detto agente riportato nell'articolo, così come in molti altri, è **David Baer**.

Dunque, rispettando il formato della flag richiesto, bisognerà inviare `flag{David_Baer}`.
