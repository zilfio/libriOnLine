-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Gen 08, 2015 alle 10:18
-- Versione del server: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `librionline`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `autori`
--

CREATE TABLE IF NOT EXISTS `autori` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `autori`
--

INSERT INTO `autori` (`id`, `nome`, `cognome`) VALUES
(1, 'Robin', 'Nixon'),
(3, 'Bruce', 'Eckel'),
(4, 'Kevin', 'Yank');

-- --------------------------------------------------------

--
-- Struttura della tabella `condizioni`
--

CREATE TABLE IF NOT EXISTS `condizioni` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descrizione` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `condizioni`
--

INSERT INTO `condizioni` (`id`, `nome`, `descrizione`) VALUES
(1, 'Integro', 'Volume in ottimo stato'),
(2, 'Leggermente danneggiato', ''),
(3, 'Danneggiato', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `copie_elettroniche`
--

CREATE TABLE IF NOT EXISTS `copie_elettroniche` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mimetype` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `libro` varchar(13) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `libro` (`libro`),
  KEY `libro_2` (`libro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `editori`
--

CREATE TABLE IF NOT EXISTS `editori` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `editori`
--

INSERT INTO `editori` (`id`, `nome`) VALUES
(2, 'Oreilly & Associates Inc'),
(3, 'Prova'),
(4, 'Prentice Hall Ptr'),
(5, 'Apogeo');

-- --------------------------------------------------------

--
-- Struttura della tabella `gruppi`
--

CREATE TABLE IF NOT EXISTS `gruppi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descrizione` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `gruppi`
--

INSERT INTO `gruppi` (`id`, `nome`, `descrizione`) VALUES
(1, 'Bibliotecario', 'Gruppo Amministrazione del sito'),
(2, 'Utente registrato', 'Gruppo d''utenza registrato al sito');

-- --------------------------------------------------------

--
-- Struttura della tabella `gruppi_servizi`
--

CREATE TABLE IF NOT EXISTS `gruppi_servizi` (
  `id_gruppo` bigint(20) NOT NULL,
  `id_servizio` bigint(20) NOT NULL,
  KEY `gruppo` (`id_gruppo`,`id_servizio`),
  KEY `id_servizio` (`id_servizio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `gruppi_servizi`
--

INSERT INTO `gruppi_servizi` (`id_gruppo`, `id_servizio`) VALUES
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 23),
(2, 9),
(2, 22),
(2, 23);

-- --------------------------------------------------------

--
-- Struttura della tabella `libri`
--

CREATE TABLE IF NOT EXISTS `libri` (
  `isbn` varchar(13) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `editore` bigint(20) NOT NULL,
  `annopubblicazione` varchar(4) NOT NULL,
  `recensione` text NOT NULL,
  `lingua` bigint(20) NOT NULL,
  `datainserimento` datetime NOT NULL,
  `copertina` varchar(255) NOT NULL,
  PRIMARY KEY (`isbn`),
  KEY `lingua` (`lingua`),
  KEY `editore` (`editore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `libri`
--

INSERT INTO `libri` (`isbn`, `titolo`, `editore`, `annopubblicazione`, `recensione`, `lingua`, `datainserimento`, `copertina`) VALUES
('8850331827', 'Sviluppare applicazioni con PHP e MySQL', 5, '2012', '<p>Questa pratica guida - <strong>aggiornata con tutte le moderne tecnologie per lo sviluppo web</strong> - contiene gli strumenti, i principi e le tecniche necessari per costruire un sito completamente funzionale basato su MySQL e PHP. Chiunque abbia una conoscenza di base di HTML e un minimo di esperienza nella gestione di un sito web potr&agrave; muovere i primi passi nella programmazione lato server, per imparare a gestire dinamicamente grandi quantit&agrave; di dati, fornire agli utenti contenuti personalizzati e interattivi, costruire CMS e piattaforme di e-commerce efficienti. Gli sviluppatori alle prime armi apprezzeranno il linguaggio semplice, le spiegazioni passo passo e il codice degli esempi da testare, mentre quelli pi&ugrave; esperti troveranno utile la trattazione di tecniche avanzate, come la memorizzazione di dati binari in MySQL, i cookie e le sessioni PHP.</p>\r\n', 1, '2015-01-03 16:00:34', 'resources/libri/8850331827/copertina.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `libri_autori`
--

CREATE TABLE IF NOT EXISTS `libri_autori` (
  `libro` varchar(13) NOT NULL,
  `autore` bigint(20) NOT NULL,
  KEY `libro` (`libro`),
  KEY `autore` (`autore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `libri_autori`
--

INSERT INTO `libri_autori` (`libro`, `autore`) VALUES
('8850331827', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `libri_tags`
--

CREATE TABLE IF NOT EXISTS `libri_tags` (
  `libro` varchar(13) NOT NULL,
  `tag` bigint(20) NOT NULL,
  KEY `libro` (`libro`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `libri_tags`
--

INSERT INTO `libri_tags` (`libro`, `tag`) VALUES
('8850331827', 3),
('8850331827', 7),
('8850331827', 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `lingue`
--

CREATE TABLE IF NOT EXISTS `lingue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `lingue`
--

INSERT INTO `lingue` (`id`, `nome`) VALUES
(1, 'Italiano'),
(2, 'Inglese'),
(3, 'Francese');

-- --------------------------------------------------------

--
-- Struttura della tabella `prestiti`
--

CREATE TABLE IF NOT EXISTS `prestiti` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `volume` bigint(20) NOT NULL,
  `duratamax` varchar(255) NOT NULL,
  `dataprestito` date NOT NULL,
  `datarestituzione` date DEFAULT NULL,
  `utente` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `volume` (`volume`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `servizi`
--

CREATE TABLE IF NOT EXISTS `servizi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `descrizione` text,
  `script` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dump dei dati per la tabella `servizi`
--

INSERT INTO `servizi` (`id`, `nome`, `descrizione`, `script`) VALUES
(9, 'Dashboard', 'Pannello di amministrazione', 'backoffice.php'),
(10, 'Gestione Servizi', 'Script per la gestione dei servizi', 'manager-services.php'),
(11, 'Gestione Gruppi', 'Script per la gestione dei gruppi d''utenza', 'manager-groups.php'),
(12, 'Gestione Utenti', 'Script per la gestione utenza', 'manager-users.php'),
(13, 'Gestione Libri', 'Script per la gestione dei libri', 'manager-books.php'),
(14, 'Gestione Autori', 'Script per la gestione degli autori', 'manager-authors.php'),
(15, 'Gestione Editori', 'Script per la gestione degli editori', 'manager-editors.php'),
(16, 'Gestione Lingue', 'Script per la gestione delle lingue', 'manager-languages.php'),
(17, 'Gestione Tag', 'Script per la gestione dei tags', 'manager-tags.php'),
(18, 'Gestione Copie Elettroniche', 'Script per la gestione delle copie elettroniche', 'manager-electronic-copies.php'),
(19, 'Gestione Volumi', 'Script per la gestione dei volumi', 'manager-volumes.php'),
(20, 'Gestione Condizioni', 'Script per la gestione delle condizioni', 'manager-conditions.php'),
(21, 'Gestione Prestiti', 'Script per la gestione dei prestiti', 'manager-loans.php'),
(22, 'Gestione Storico', 'Script per la gestione dello storico dell''utente', 'manager-loans-users.php'),
(23, 'Gestione Profilo Utente', 'Script per la gestione del profilo utenza', 'manager-user-profile.php');

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`id`, `nome`) VALUES
(3, 'Informatica'),
(6, 'Java'),
(7, 'Programmazione'),
(9, 'Php');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` int(25) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `codicefiscale` varchar(16) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `provincia` varchar(2) NOT NULL,
  `cap` int(5) NOT NULL,
  `dataregistrazione` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `password`, `email`, `telefono`, `nome`, `cognome`, `codicefiscale`, `indirizzo`, `citta`, `provincia`, `cap`, `dataregistrazione`) VALUES
(2, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 'admin@admin.it', 1, 'Bibliotecario', 'Bibliotecario', 'DRZSLV88L24A515D', 'Via Admin, 1', 'Admin', 'AD', 11111, '2014-09-22'),
(21, 'zilfio', '4323e927ca0ff19f21823bc34bb0a48c', 'zilfio88@gmail.com', 2147483647, 'Silvio', 'D''Orazio', 'DRZSLV88L24A515D', 'Via Admin, 1', 'prova', 'po', 67050, '2014-09-25');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_gruppi`
--

CREATE TABLE IF NOT EXISTS `utenti_gruppi` (
  `id_utente` bigint(20) NOT NULL,
  `id_gruppo` bigint(20) NOT NULL,
  KEY `id_utente` (`id_utente`,`id_gruppo`),
  KEY `id_gruppo` (`id_gruppo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utenti_gruppi`
--

INSERT INTO `utenti_gruppi` (`id_utente`, `id_gruppo`) VALUES
(2, 1),
(21, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `volumi`
--

CREATE TABLE IF NOT EXISTS `volumi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `condizione` bigint(20) NOT NULL,
  `libro` varchar(13) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stato` (`condizione`),
  KEY `libro` (`libro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `volumi`
--

INSERT INTO `volumi` (`id`, `condizione`, `libro`) VALUES
(1, 1, '8850331827'),
(2, 1, '8850331827'),
(3, 1, '8850331827'),
(4, 1, '8850331827'),
(5, 1, '8850331827');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `copie_elettroniche`
--
ALTER TABLE `copie_elettroniche`
  ADD CONSTRAINT `copie_elettroniche_ibfk_1` FOREIGN KEY (`libro`) REFERENCES `libri` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `gruppi_servizi`
--
ALTER TABLE `gruppi_servizi`
  ADD CONSTRAINT `gruppi_servizi_ibfk_1` FOREIGN KEY (`id_gruppo`) REFERENCES `gruppi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gruppi_servizi_ibfk_2` FOREIGN KEY (`id_servizio`) REFERENCES `servizi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `libri`
--
ALTER TABLE `libri`
  ADD CONSTRAINT `libri_ibfk_1` FOREIGN KEY (`editore`) REFERENCES `editori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `libri_ibfk_2` FOREIGN KEY (`lingua`) REFERENCES `lingue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `libri_autori`
--
ALTER TABLE `libri_autori`
  ADD CONSTRAINT `libri_autori_ibfk_1` FOREIGN KEY (`autore`) REFERENCES `autori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `libri_autori_ibfk_2` FOREIGN KEY (`libro`) REFERENCES `libri` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `libri_tags`
--
ALTER TABLE `libri_tags`
  ADD CONSTRAINT `libri_tags_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `libri_tags_ibfk_3` FOREIGN KEY (`libro`) REFERENCES `libri` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prestiti`
--
ALTER TABLE `prestiti`
  ADD CONSTRAINT `prestiti_ibfk_1` FOREIGN KEY (`volume`) REFERENCES `volumi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prestiti_ibfk_2` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `utenti_gruppi`
--
ALTER TABLE `utenti_gruppi`
  ADD CONSTRAINT `utenti_gruppi_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utenti_gruppi_ibfk_2` FOREIGN KEY (`id_gruppo`) REFERENCES `gruppi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `volumi`
--
ALTER TABLE `volumi`
  ADD CONSTRAINT `volumi_ibfk_3` FOREIGN KEY (`condizione`) REFERENCES `condizioni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volumi_ibfk_4` FOREIGN KEY (`libro`) REFERENCES `libri` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
