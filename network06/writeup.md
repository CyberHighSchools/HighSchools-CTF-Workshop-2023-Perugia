# 4th HighSchools CTF Workshop - Perugia 2023

## [network] Corrupted File System

All'interno del pcap sono presenti tracce di una connessione eseguita da un client verso un server FTP.

La risorsa richiesta in oggetto è un'immagine corrotta con nome `Corruped_reiser.jpg`.

### Soluzione

Possiamo estrarla usando la funzione `Estrai oggetti` di Wireshark.
Ispezionando il file tramite Cyberchef o hexdump, si può vedere che i primi 8 bytes sono la stringa `"HANSREISER"`.

```bash
$ hexdump -C Corrupted_Reiser.jpg | head
00000000  48 41 4e 53 52 45 49 53  45 52 00 01 01 01 00 60  |HANSREISER.....`|
00000010  00 60 00 00 ff db 00 43  00 02 01 01 02 01 01 02  |.`.....C........|
00000020  02 02 02 02 02 02 02 03  05 03 03 03 03 03 06 04  |................|
00000030  04 03 05 07 06 07 07 07  06 07 07 08 09 0b 09 08  |................|
00000040  08 0a 08 07 07 0a 0d 0a  0a 0b 0c 0c 0c 0c 07 09  |................|
00000050  0e 0f 0d 0c 0e 0b 0c 0c  0c ff db 00 43 01 02 02  |............C...|
00000060  02 03 03 03 06 03 03 06  0c 08 07 08 0c 0c 0c 0c  |................|
00000070  0c 0c 0c 0c 0c 0c 0c 0c  0c 0c 0c 0c 0c 0c 0c 0c  |................|
```

Possiamo rimpiazzare questi bytes, tramite un hex editor o tramite Cyberchef applicando i magic byte del formato jpg.
Questi si possono trovare su [wikipedia](https://en.wikipedia.org/wiki/List_of_file_signatures) e sono `FF D8 FF E0 00 10 4A 46 49 46 00 01`.

Il file modificato può essere aperto con successo, ed è possibile leggere la flag al suo interno.
