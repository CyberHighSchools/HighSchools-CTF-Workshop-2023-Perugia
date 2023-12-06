Provate a usare questo script mentre visitate il [sito per calcolare il pedaggio](https://www.stradeanas.it/it/le-strade/la-rete-anas/le-autostrade/autostrade-a24-e-a25/calcola-il-tuo-pedaggio):

```js
var tollbooths = document.getElementById("staz_out").children; // Ottiene la lista delle stazioni d'uscita.

var targetPrice = "20.60 €"; // Prezzo che cerchiamo.

var dataToSe_nd = new Object(); // Oggetto che contiene i dati per richiedere il costo del pedaggio da una città all'altra.
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
