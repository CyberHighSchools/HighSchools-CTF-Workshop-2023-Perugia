# 4th HighSchools CTF Workshop - Perugia 2023

## [OSINT] Pedaggio troppo alto

La sfida richiede di individuare persone sui social network, ottenere informazioni sulle loro vicissitudini, e saper fare semplice web scraping.

L'obiettivo della sfida è trovare il nome della città in cui è uscito il personaggio fittizzio seguito, e i passi da seguire sono:

- Individuare il profilo Instagram del soggetto;
- Trovare indizi riguardo un viaggio in autostrada;
- Cercare tratte in autostrada compatibili alla richiesta sul sito dell'ANAS.

### Individuazione del profilo

Non avendo altre informazioni su questo Lamberto Capellini, si potrebbe procedere cercando il nome nei social network, sperando di incappare in qualche post che tradisca i movimenti del seguito. Nel periodo in cui è stata scritta questa sfida, uno dei social più in voga è [Instagram](https://www.instagram.com/), quindi un possibile punto di partenza della ricerca. Infatti l'obiettivo ha un [profilo sulla piattaforma](https://www.instagram.com/lamberto.capellini/), con due indizi per continuare l'indagine: le foto pubblicate.

### Analisi degli indizi

Dal [profilo Instagram di Lamberto Capellini](https://www.instagram.com/lamberto.capellini/) si possono esaminare due fotografie con descrizione:

#### Il SUV

Il primo post pubblicato mostra un imponente fuoristrada, che potrebbe rientrare nella [classe B](https://www.stradeanas.it/sites/default/files/images/Pedaggio_Cassi.png) del calcolo del pedaggio autostradale; la descrizione legge "Il mio gioiellino!", un'indicazione della proprietà del veicolo.

#### Il biglietto dell'autostrada

Il secondo post pubblicato è una fotografia, tagliata, di un biglietto d'autostrada. Osservando attentamente si vedrà che sul biglietto c'è scritto "Classe B" che conferma l'ipotesi che il veicolo su cui è il GPS sia di quella classe. La descrizione legge "Non è possibile che per 200 km o poco più si debba pagare 20.60 € di pedaggio!". Da questa frase possiamo tracciare un area di dove possa essere arrivato con l'auto, ma soprattutto sapremo qual è l'importo del viaggio, un'informazione molto più precisa.

### Filtrare le informazioni

La ricerca è diventata dunque quella di trovare la città che, entrando in autostrada ad Ancona, fa spendere 20,60 € di pedaggio.
Un modo semplice per calcolare il costo del pedaggio, data una città di entrata, una di uscita, e la classe del veicolo, è consultando la [pagina dedicata dell'ANAS](https://www.stradeanas.it/it/le-strade/la-rete-anas/le-autostrade/autostrade-a24-e-a25/calcola-il-tuo-pedaggio), che in fondo ha un form che permette di interrogare [un altro server dell'ANAS](https://www.stradeanas.it/it/anas/app/pedaggi) con questi parametri. La risposta è un JSON del tipo:

```json
{
  "km_p": "253,00 (95%)",
  "km_m": "15,00 (5%)",
  "pedaggio": "20.60 €",
  "st_in": "AREZZO",
  "st_out": "FROSINONE",
  "classe": "B"
}
```

#### Approccio per distanza

Stilando una lista delle città distanti più di 200 km da Ancona, aiutandosi anche con [una ricerca su WolframAlpha](https://www.wolframalpha.com/input?i%253Dlarge%252Bcities%252Bwithin%252B220%252Bkm%252Bof%252BAncona), si può cercare manualmente la città che, da Ancona, faccia spendere 20,60 € di pedaggio autostradale. Seguendo la lista di Wolfram, ordinata per popolazione, escludendo le città oltre il Mar Adriatico, **Frosinone** è la 38ª città che corrisponde ai criteri.

#### Approccio a forza bruta

Per evitare di cercare a mano, si può impiegare uno script che cerchi le città che, partendo da Ancona, facciano spendere 20,60 € di pedaggio. Analizzando il sorgente della pagina si troverà la funzione collegata al bottone per inviare la richiesta, `cal_ped`, nel file [anas.app.pedaggi.js](https://www.stradeanas.it/sites/all/modules/anas/js/anas.app.pedaggi.js). Si vedrà che la richiesta, da inviare a https://www.stradeanas.it/it/anas/app/pedaggi, deve avere come `body` un JSON contenente i parametri dell'interrogazione del tipo:

```json
{
  "action": "pedaggio",
  "classe": "B",
  "staz_in": "26",
  "staz_out": "708"
}
```

Lo script, effettuando richieste per ogni elemento dell'elenco delle città di uscita, dovrà confrontare i prezzi delle risposte del server con il prezzo obiettivo, fino a trovare la città di **Frosinone**, l'unica a costare 20,60 € per un veicolo di classe B.

##### Implementazione

Una possibile implementazione, in JavaScript, da eseguire nella console del browser mentre si visita la [pagina del calcolo del pedaggio](https://www.stradeanas.it/it/le-strade/la-rete-anas/le-autostrade/autostrade-a24-e-a25/calcola-il-tuo-pedaggio), fornita come suggerimento, è la seguente:

```js
var tollbooths = document.getElementById("staz_out").children; // Ottiene la lista delle stazioni d'uscita.

var targetPrice = "20.60 €"; // Prezzo che cerchiamo.

var dataToSend = new Object(); // Oggetto che contiene i dati per richiedere il costo del pedaggio da una città all'altra.
dataToSend["action"] = "pedaggio";
dataToSend["classe"] = "B"; // Classe del SUV
dataToSend["staz_in"] = "26"; // Arezzo

var promises = new Array(); // Variabile di ausilio per determinare quando lo script conclude l'esecuzione.

console.log(`Controllo il pedaggio di ${tollbooths.length} caselli...`);
for (var i = 0; i < tollbooths.length; i++) {
  // Per ciascun elemento della lista delle stazioni d'uscita interroga il server dei prezzi e mostra quello che ha lo stesso prezzo del target.
  dataToSend["staz_out"] = tollbooths[i].value; // Inserisce nell'oggetto da inviare il numero della stazione che sta esaminando.
  if (dataToSend["staz_in"] === dataToSend["staz_out"]) {
  } // Se la stazione di partenza è uguale alla stazione di arrivo allora non fare niente.
  else {
    var promise = fetch(
      // Fa una richiesta al sito dei pedaggi con gli appositi parametri
      "https://www.stradeanas.it/it/anas/app/pedaggi",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(dataToSend),
      }
    )
      .then((response) => response.json()) // Dopo aver ricevuto la risposta la trasforma in oggetto manipolabile dal computer e lo passa all'istruzione successiva.
      .then((parsedResponse) => {
        if (parsedResponse.pedaggio === targetPrice) {
          // Se il pedaggio è uguale al prezzo cercato allora mostra le informazioni del tragitto.
          var route = `${parsedResponse.st_in} -> ${parsedResponse.st_out}: ${parsedResponse.pedaggio}`;
          window.alert(route);
          console.log(route);

          return;
        }
      })
      .catch((error) => {
        console.error(error);
      });

    promises.push(promise); // Funzione di ausilio.
  }
}

Promise.all(promises).then(() => console.log("Ricerca conclusa."));
```
