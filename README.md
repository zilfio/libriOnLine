# LibriOnLine
Il sito LibriOnLine rappresenta una interfaccia web per la gestione di una biblioteca.

La base di dati del sito contiene informazioni riguardanti i volumi gestiti dalla biblioteca, gli utenti e i prestiti. In particolare, per ogni libro viene gestito il codice ISBN, il titolo, la lingua, l’editore, l’anno di pubblicazione, il nome dell’autore o degli autori e una recensione o breve descrizione (come la recensione che si trova spesso sulla copertina posteriore del libro o sul risvolto interno della sovra copertina) che dia informazioni più dettagliate sul libro. Una serie di tag, cioè parole o frasi brevi (ad. es. “fantasy”, “informatica”, “programmazione”, ”letteratura”, ecc.), sono associati a ciascun volume ed attribuite arbitrariamente dai bibliotecari. Ogni libro ha una durata massima di prestito che viene decisa dai bibliotecari in base alle condizioni del volume e può essere presente in biblioteca anche in più copie. Infine, alcuni libri possono essere contrassegnati come “copie elettroniche”, che vengono aggiunte dai bibliotecari per rendere i libri accessibili direttamente online sotto forma di file di testo o PDF scaricabile. Il sito ha una pagina “Catalogo libri” che mostra a video tutti i libri presenti nel sistema che possono essere selezionati per visualizzarne i dettagli; infatti, ogni libro ha una pagina descrittiva che contiene, opportunamente organizzate, tutte le informazioni di cui sopra.

Il sito prevede tre tipologie di utenza: bibliotecari, utenti registrati e utenti anonimi (utenti non registrati).
Il sistema è suddiviso in front-end e back-end (backoffice), le cui funzionalità sono accessibili a seconda dell’utente loggato.
Solo i bibliotecari possono aggiungere nuovi utenti (compresi altri bibliotecari) nel sistema.
Ogni nuovo utente registrato avrà un profilo contenente i suoi dati anagrafici, l’indirizzo email e un numero di telefono.

# Funzionalità del sistema

Di seguito sono elencati i contenuti e le funzionalità del sito:
- Dentro la sezione “Catalogo libri”, oltre ad una ricerca semplice da effettuare sul titolo di un libro, tutti gli utenti possono usufruire di una funzionalità di ricerca avanzata tramite la quale i libri possono essere ricercati in base a: il titolo o parte di esso, i tag associati, uno o più degli autori, il codice ISBN e la lingua. I risultati della ricerca sono presentati sotto forma di griglia e cliccando su ciascun libro si apre la corrispondente pagina di dettaglio.
- Nella pagina di dettaglio di un libro si può cliccare sul nome di un autore avviando automaticamente una ricerca di tutti i libri da lui scritti presenti nella biblioteca.
- Nella pagina di dettaglio di un libro è possibile cliccare su uno o più tag ad esso attribuiti avviando automaticamente una ricerca di tutti i libri associati.
- A partire dalla pagina di dettaglio di un libro i bibliotecari e gli utenti registrati possono visualizzare il numero di volumi presenti nella biblioteca e il numero di quelli attualmente liberi (non in prestito).
- Nel caso in cui tutte le copie siano in prestito, all'utente registrato viene indicata la data presunta di restituzione della prima copia, calcolata sulla base della sua data di prestito e della durata massima prevista.
- Dalla pagina di dettaglio del libro i bibliotecari possono accedere allo storico dei prestiti del libro stesso. All’interno di tale storico, vengono mostrati i prestiti chiusi e in corso di prestito di tutti gli
utenti e per ogni prestito è possibile visualizzare la data di prestito, la data presunta di restituzione della copia, calcolata come già spiegato sulla base della sua data di prestito e della durata massima prevista, e la data di restituzione del volume nel caso in cui il prestito è stato chiuso correttamente.
- I bibliotecari, dopo aver cercato ed individuato un particolare libro (usando le funzioni appena elencate), possono registrarne il prestito a nome di uno degli utenti noti al sistema.
- I bibliotecari saranno, inoltre, gli unici a poter assegnare e modificare la password agli utenti del sito.
- Gli utenti registrati possono visualizzare all’interno della sezione “Prestiti attivi” la lista dei volumi che hanno preso in prestito e le relative date di riconsegna. Gli utenti possono, inoltre, visionare il proprio storico dei prestiti dei volumi all’interno della sezione “Storico prestiti”.
- Inoltre, i bibliotecari possono visualizzare all’interno della sezione “Prestiti attivi” una lista di tutti i libri in corso di prestito, tra cui saranno evidenziati in rosso quelli la cui data di riconsegna è stata superata.
- All’interno della sezione “Gestione prestiti” i bibliotecari possono visualizzare le varie tipologie di prestito opportunamente evidenziate con un colore diverso in base ad un certo criterio:
I prestiti di colore verde sono stati chiusi correttamente.
I prestiti di colore arancio sono stati restituiti ma in ritardo rispetto alla presunta data di restituzione.
I prestiti di colore rosso sono scaduti e non sono ancora stati restituiti.
I prestiti di color blu sono regolarmente in corso di prestito.
- La homepage del sito mostra alcune informazioni a carattere generale – “Chi siamo”, “Cosa offriamo” e “Come funziona” -, la griglia dei libri maggiormente prestati e degli ultimi aggiunti alla biblioteca.
- Il menù globale del sito presenta varie voci che contengono diversi contenuti, ciascuno dei quali è stato scelto per offrire dei servizi ben precisi all’utente (“Chi siamo”, “Catalogo libri”, “FAQ”, …).
- Come già accennato, il sito prevede un backoffice, accessibile ai soli bibliotecari, tramite il quale è possibile inserire e modificare tutti i dati associati ai libri.
