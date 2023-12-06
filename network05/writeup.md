# 4th HighSchools CTF Workshop - Perugia 2023

## [network] Irresponsible

Il file di cattura contiene un gran numero di richieste e di diversa natura. Tuttavia quelle di nostro interesse riguardano la comunicazione client-server eseguita mediante il protocollo di tipo applicativo RESP (REdis Serialization Protocol) che vengono trasmesse in chiaro.

### Soluzione

Isolando le richieste possiamo ricomporre la flag tramite il filtro di visualizzazione:

```txt
resp
```

Analogamente si può seguire il flusso relativo al protocollo RESP e ripulire l'output dello stream numero 9 prelevando le righe che contengono solamente un carattere.

```txt
No. Protocol Info
511 RESP Request: SET char*0 f
512 RESP Response: OK
513 TCP 55402 → 6379 [ACK] Seq=143 Ack=176 Win=64256 Len=0 TSval=3570387389 TSecr=625198070
521 RESP Request: SET char_1 l
522 RESP Response: OK
523 TCP 55402 → 6379 [ACK] Seq=175 Ack=181 Win=64256 Len=0 TSval=3570389351 TSecr=625200073
531 RESP Request: SET char_2 a
532 RESP Response: OK
533 TCP 55402 → 6379 [ACK] Seq=207 Ack=186 Win=64256 Len=0 TSval=3570391354 TSecr=625202077
542 RESP Request: SET char_3 g
543 RESP Response: OK
544 TCP 55402 → 6379 [ACK] Seq=239 Ack=191 Win=64256 Len=0 TSval=3570393358 TSecr=625204080
553 RESP Request: SET char_4 {
554 RESP Response: OK
555 TCP 55402 → 6379 [ACK] Seq=271 Ack=196 Win=64256 Len=0 TSval=3570395361 TSecr=625206084
564 RESP Request: SET char_5 f
565 RESP Response: OK
566 TCP 55402 → 6379 [ACK] Seq=303 Ack=201 Win=64256 Len=0 TSval=3570397362 TSecr=625208085
575 RESP Request: SET char_6 r
576 RESP Response: OK
577 TCP 55402 → 6379 [ACK] Seq=335 Ack=206 Win=64256 Len=0 TSval=3570399365 TSecr=625210087
586 RESP Request: SET char_7 4
587 RESP Response: OK
588 TCP 55402 → 6379 [ACK] Seq=367 Ack=211 Win=64256 Len=0 TSval=3570401368 TSecr=625212091
597 RESP Request: SET char_8 g
598 RESP Response: OK
599 TCP 55402 → 6379 [ACK] Seq=399 Ack=216 Win=64256 Len=0 TSval=3570403372 TSecr=625214094
608 RESP Request: SET char_9 m
609 RESP Response: OK
610 TCP 55402 → 6379 [ACK] Seq=431 Ack=221 Win=64256 Len=0 TSval=3570405375 TSecr=625216097
619 RESP Request: SET char_10 3
620 RESP Response: OK
621 TCP 55402 → 6379 [ACK] Seq=464 Ack=226 Win=64256 Len=0 TSval=3570407378 TSecr=625218100
630 RESP Request: SET char_11 n
631 RESP Response: OK
632 TCP 55402 → 6379 [ACK] Seq=497 Ack=231 Win=64256 Len=0 TSval=3570409381 TSecr=625220104
641 RESP Request: SET char_12 t
642 RESP Response: OK
643 TCP 55402 → 6379 [ACK] Seq=530 Ack=236 Win=64256 Len=0 TSval=3570411384 TSecr=625222107
691 RESP Request: SET char_13 3
692 RESP Response: OK
693 TCP 55402 → 6379 [ACK] Seq=563 Ack=241 Win=64256 Len=0 TSval=3570413387 TSecr=625224109
701 RESP Request: SET char_14 d
702 RESP Response: OK
703 TCP 55402 → 6379 [ACK] Seq=596 Ack=246 Win=64256 Len=0 TSval=3570415390 TSecr=625226113
712 RESP Request: SET char_15 k
713 RESP Response: OK
714 TCP 55402 → 6379 [ACK] Seq=629 Ack=251 Win=64256 Len=0 TSval=3570417393 TSecr=625228115
730 RESP Request: SET char_16 3
731 RESP Response: OK
732 TCP 55402 → 6379 [ACK] Seq=662 Ack=256 Win=64256 Len=0 TSval=3570419397 TSecr=625230119
741 RESP Request: SET char_17 y
742 RESP Response: OK
743 TCP 55402 → 6379 [ACK] Seq=695 Ack=261 Win=64256 Len=0 TSval=3570421398 TSecr=625232121
752 RESP Request: SET char_18 s
753 RESP Response: OK
754 TCP 55402 → 6379 [ACK] Seq=728 Ack=266 Win=64256 Len=0 TSval=3570423401 TSecr=625234124
771 RESP Request: SET char_19 *
772 RESP Response: OK
773 TCP 55402 → 6379 [ACK] Seq=761 Ack=271 Win=64256 Len=0 TSval=3570425405 TSecr=625236127
792 RESP Request: SET char_20 3
793 RESP Response: OK
794 TCP 55402 → 6379 [ACK] Seq=794 Ack=276 Win=64256 Len=0 TSval=3570427408 TSecr=625238130
813 RESP Request: SET char_21 v
814 RESP Response: OK
815 TCP 55402 → 6379 [ACK] Seq=827 Ack=281 Win=64256 Len=0 TSval=3570429411 TSecr=625240133
842 RESP Request: SET char_22 3
843 RESP Response: OK
844 TCP 55402 → 6379 [ACK] Seq=860 Ack=286 Win=64256 Len=0 TSval=3570431414 TSecr=625242137
863 RESP Request: SET char_23 r
864 RESP Response: OK
865 TCP 55402 → 6379 [ACK] Seq=893 Ack=291 Win=64256 Len=0 TSval=3570433417 TSecr=625244140
883 RESP Request: SET char_24 y
884 RESP Response: OK
885 TCP 55402 → 6379 [ACK] Seq=926 Ack=296 Win=64256 Len=0 TSval=3570435421 TSecr=625246143
904 RESP Request: SET char_25 w
905 RESP Response: OK
906 TCP 55402 → 6379 [ACK] Seq=959 Ack=301 Win=64256 Len=0 TSval=3570437423 TSecr=625248146
924 RESP Request: SET char_26 h
925 RESP Response: OK
926 TCP 55402 → 6379 [ACK] Seq=992 Ack=306 Win=64256 Len=0 TSval=3570439426 TSecr=625250149
945 RESP Request: SET char_27 3
946 RESP Response: OK
947 TCP 55402 → 6379 [ACK] Seq=1025 Ack=311 Win=64256 Len=0 TSval=3570441429 TSecr=625252151
967 RESP Request: SET char_28 r
968 RESP Response: OK
969 TCP 55402 → 6379 [ACK] Seq=1058 Ack=316 Win=64256 Len=0 TSval=3570443432 TSecr=625254155
988 RESP Request: SET char_29 3
989 RESP Response: OK
990 TCP 55402 → 6379 [ACK] Seq=1091 Ack=321 Win=64256 Len=0 TSval=3570445435 TSecr=625256157
1009 RESP Request: SET char_30 }
1010 RESP Response: OK
```

Possiamo notare che ogni richiesta contiene il numero del carattere che denota la sua posizione, es. char\*0 = f, char_1 = l .
