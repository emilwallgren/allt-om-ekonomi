Allt Om Ekonomi
===============
Välkommen till allt om ekonomi. Allt om ekonomi är byggd med hjälp av MVC-ramverket Anax-MVC utvecklad av Mikael Roos på BTH.
Ett exempel på Allt Om Ekonomi finner du [här](http://www.student.bth.se/~emwc15/phpmvc/alltomekonomi/Anax-MVC/webroot/)

So nu har du alltså bestämt dig för att använda Allt Om Ekonomi.
Jag skall visa dig hur du får igång den på ditt egna system.

Installationen består av 4 punkter:
1. Installera Databas
2. Installera paket
3. Konfigurera mail
4. Konfigurera databasuppkoppling

1. Installera Databas
------------------
Allt om Ekonomi är hyfsat värdelös utan sin databas, så vi börjar med att skapa den.
Gå in i din sql-hanterare och skriv in följande i terminalen:

```sql
DROP TABLE IF EXISTS `anvandare`;

CREATE TABLE `anvandare` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(260) NOT NULL DEFAULT '',
  `profileimage` varchar(300) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) NOT NULL DEFAULT '',
  `identifier` varchar(260) NOT NULL DEFAULT '',
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `poang` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `fragor`;

CREATE TABLE `fragor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `anvandare_id` int(11) NOT NULL,
  `fraga` text NOT NULL,
  `titel` varchar(100) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fragor_votes` int(11) NOT NULL DEFAULT '0',
  `antal_svar` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `fragor_votes`;

CREATE TABLE `fragor_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fragor_id_vote` int(11) DEFAULT NULL,
  `fragor_user_id` int(11) DEFAULT NULL,
  `fragor_vote` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `kommentarer`;

CREATE TABLE `kommentarer` (
  `kommentar_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fragor_id` int(11) DEFAULT NULL,
  `anvandare_id` int(11) NOT NULL,
  `svar_id` int(11) DEFAULT NULL,
  `kommentar` text,
  `comment_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`kommentar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `svar`;

CREATE TABLE `svar` (
  `id_svar` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `anvandare_id` int(11) DEFAULT NULL,
  `fragor_id` int(11) DEFAULT NULL,
  `svar` text,
  `answer_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `svar_votes` int(11) NOT NULL DEFAULT '0',
  `accepted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_svar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `svar_votes`;

CREATE TABLE `svar_votes` (
  `svar_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `svar_id_vote` int(11) DEFAULT NULL,
  `svar_vote` int(11) DEFAULT NULL,
  `svar_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`svar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `taggar`;

CREATE TABLE `taggar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fragor_id` int(11) DEFAULT NULL,
  `anvandare_id` int(11) DEFAULT NULL,
  `tagg` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `votes`;

CREATE TABLE `votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id_vote` int(11) NOT NULL,
  `vote` int(11) NOT NULL DEFAULT '0',
  `user_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

```
Nu är databasen på plats. Grattis :-)
Därefter laddar du ner allt-om-ekonomi ifrån detta github-repository.

2. Installera paket
----------------

När du laddat ner allt om ekonomi så installerar du composer och därefter installerar paketen som står anvisade i composer.json.
När paketen installerats är vi redo att ta nästa steg.

3. Konfigurera mailinställningar
-----------------------------
När paketen installerats går du in i src/anvandare/anvandareController.php. Ifrån raden 117 till 122 måste du själv skriva in inställningarna på mailfunktionen. Dessa innefattar host, username, password, SMTPSecure samt port. Om du vill ha ett annat meddelande i mailet som skickas så ändrar du texten i Subject, Body och Altbody.

4. Konfigurera databasuppkoppling
------------------------------
Nu är det bara en sak kvar!
Det är att gå in i app/config/config_mysql.php och lägga till dina databasuppgifter.
Därefter är Allt Om Ekonomi helt installerad och totalt funktionsduglig.

Slutord
-------
Tack för att du testar på Allt om Ekonomi. Skulle det vara några frågor kan jag (Emil Wallgren) nås på emil.wallgren@hotmail.se

Koda Vidare!

/Emil Wallgren
