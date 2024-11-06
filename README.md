# BoolBnB Backend

## Introduzione
BoolBnB è una piattaforma web progettata per facilitare l'affitto di appartamenti. Questo progetto si divide in due parti principali: il backend e il frontend. La componente backend, sviluppata con **Laravel**, gestisce la logica e i dati dell'applicazione, archiviando tutte le informazioni relative agli utenti, agli appartamenti e ai messaggi. Laravel Breeze è stato utilizzato per implementare un sistema di autenticazione semplice e sicuro, che permette ai proprietari di registrarsi e accedere alle proprie aree riservate.

## Caratteristiche del Progetto
Il backend supporta diverse funzionalità principali:
- **Gestione degli utenti e autenticazione**: Permette ai proprietari di appartamenti di registrarsi e accedere al proprio profilo personale.
- **Elenco e gestione degli appartamenti**: I proprietari possono creare e aggiornare gli annunci dei propri appartamenti, specificando dettagli come stanze, servizi, e località.
- **Ricerca degli appartamenti**: Gli utenti interessati possono effettuare ricerche mirate per trovare appartamenti in una determinata area, filtrando i risultati per caratteristiche specifiche.
- **Sistema di messaggistica**: La piattaforma consente ai visitatori di contattare direttamente i proprietari degli appartamenti per ottenere informazioni aggiuntive.
- **Sponsorizzazione degli annunci**: I proprietari hanno la possibilità di promuovere i propri appartamenti tramite sponsorizzazioni, acquistabili in modo sicuro grazie all’integrazione con **Braintree** per i pagamenti.
- **Statistiche**: Ogni proprietario può consultare statistiche di visualizzazione e messaggi ricevuti per i propri appartamenti, utile per monitorare l’interesse degli utenti.

## Tecnologie Utilizzate
- **Laravel**: Framework PHP che supporta la gestione e l’organizzazione dei dati.
- **Laravel Breeze**: Sistema di autenticazione semplice e sicuro.
- **MySQL**: Database relazionale per archiviare tutte le informazioni della piattaforma.
- **Braintree**: Sistema di pagamento online che permette sponsorizzazioni sicure tramite carte di credito.
- **TomTom API**: Servizio di geolocalizzazione utilizzato per mappare gli appartamenti e facilitare la ricerca basata sulla posizione.
