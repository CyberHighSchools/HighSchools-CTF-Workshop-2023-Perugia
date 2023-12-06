# 4th HighSchools CTF Workshop - Perugia 2023

## [OSINT] Sicurezza alla parata

Questa sfida richiede di saper ritrovare un punto di interesse sfruttando informazioni deducibili da un video.

La sfida è basata sull'incidente avvenuto realmente alla Rose Festival’s Grand Floral Parade a Portland in Oregon, Stati Uniti il 10 giugno 2023, quando un uomo, alla guida di un pickup, ha scavalcato le barriere che chiudevano la strada in occasione della parata.

### Immagine fornita

L'immagine allegata alla sfida è il thumbnail del video [Extended dashcam video: Portland man plows through Grand Floral Parade barricades](https://www.youtube.com/watch?v%253D-8gMd9XZJyg). Effettuando una ricerca per immagini della foto, si risale al video suddetto che mostra le riprese della dashcam del guidatore. Tramite il titolo del video si deduce il luogo e l'occasione dell'incidente, ovvero la Rose Festival's Grand Floral Parade a Portland in Oregon, Stati Uniti.

### Analisi del video

Il video comincia con l'inquadratura dell'abitacolo, mentre l'obiettivo della sfida è all'esterno, su un cartello dell'autostrada. Al minuto 1:14 del video la telecamera esterna inquadra dei cartelli verdi di un'uscita dell'autostrada su cui è scritto, dall'alto verso il basso, "Exit 302A; Broadway - Welder Street; Moda Center; Exit Only".

Queste informazioni sono sufficienti a risolvere la sfida, in quanto la flag è `flag_{302A}`. Se questa prima inquadratura dovesse sfuggire all'attenzione, al minuto 1:27 e 1:32 vengono inquadrati altri due cartelli contenenti la medesima informazione.
