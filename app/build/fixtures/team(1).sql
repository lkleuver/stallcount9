-- phpMyAdmin SQL Dump
-- version 3.3.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 13, 2011 at 10:35 PM
-- Server version: 5.5.11
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stallcount9`
--

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shortname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile3` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile4` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile5` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `tournament_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `byestatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tournament_id_idx` (`tournament_id`),
  KEY `division_id_idx` (`division_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=85 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `shortname`, `email1`, `email2`, `contactname`, `city`, `country`, `mobile1`, `mobile2`, `mobile3`, `mobile4`, `mobile5`, `comment`, `tournament_id`, `division_id`, `byestatus`) VALUES
(1, 'Gentle', 'Gentle', 'johanbommie@yahoo.com', '', 'korneel', 'Gent', 'Belgium', '32486652562', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(2, 'France National Master Team', 'FranceMaster', 'pierril9@yahoo.com', 'jygoliard@yahoo.com', 'jano', 'ALL AROUND', 'FRANCE', '33685554475', '33650741660', NULL, NULL, NULL, '', NULL, 1, NULL),
(3, 'Rainbow Warriors', 'Rainbow Warriors', 'thomas.kuypers@laposte.net', 'thomas.kuypers@laposte.net', 'Thomas Kuypers', 'Lille/BesanÌ¤on/Clermont', 'France', '33626820763', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(4, 'Carapedos', 'Carapedos', 'db@davidbender.de', 'hauck@ghost-o-one.de', 'Torsten', 'Wuppertal/ Dortmund', 'Germany', '491752015296', '491732716004', '491725766639', NULL, NULL, '', NULL, 1, NULL),
(5, 'KoBOld', 'KoBOld', 'tim.oehr@gmail.com', 'timoehr@uni-bremen.de', 'Tim Oehr', 'Bremen, Oldenburg, Osnabrueck', 'Germany', '491777157468', '4915111667320', '4917663048053', '491732112759', '4917621714819', '', NULL, 1, NULL),
(6, 'Hardfisch', 'Hardfisch', 'tieiben@gmail.com', 'tieiben@gmail.com', 'Tarek Iko Eiben', 'Hamburg', 'Germany', '491729047847', '4915788484214', '491776052828', '491774454771', '4916095730116', '', NULL, 1, NULL),
(7, 'Tsunami Vintage', 'Tsunami', 'cyrille.perez@wanadoo.Fr', 'cyrille.perez@wanadoo.fr', 'cyrille', 'Nemours', 'FRANCE', '33650634651', '33625651587', '33661239577', '33670427292', '33632517820', '', NULL, 1, NULL),
(8, 'Xlr8rs', 'Xlr8rs', 'lucchome@yahoo.com', 'tsasfra@gmail.com', 'FRANZ TSAS', 'Brussels', 'Belgium', '32486036417', '32497056317', '32485454818', NULL, NULL, '', NULL, 1, NULL),
(9, 'Mooncatchers', 'Mooncatchers', 'cbihin@gmail.com', 'calimemo@hotmail.com', 'Nicolas De Mesmaeker', 'Brussels', 'Belgium', '32487178892', '32495866466', '32474816536', '32495785634', NULL, '', NULL, 1, NULL),
(10, 'MAM Friends', 'MAM', 'sbeltramo@wanadoo.fr', 'seb.beltramo@gmail.com', 'Bab', 'Manies', 'France', '33601171070', '33620698325', NULL, NULL, NULL, '', NULL, 1, NULL),
(11, 'Rebel Ultimate', 'Rebel', 'rebelultimate@gmail.com', 'flashdan9@gmail.com', 'Brian O''Callaghan', 'Cork', 'Ireland', '353877811008', '353860859092', '31652100534', '353863448084', '353868801012', '', NULL, 1, NULL),
(12, 'Silence', 'Silence', 'ondrej.bouska@gmail.com', 'frankie@praguedevils.org', 'Ondrej Bouska', 'Prague', 'Czech Republic', '420775686147', '420603751806', '420732944669', '420604344735', '420724773365', '', NULL, 1, NULL),
(13, 'Funatics', 'Funatics', 'vorstand@funaten.de', 'mario-tonini@wanadoo.fr', 'Mario', 'Hannover', 'Germany', '491799781163', '491789388635', '4917664856234', '491782090301', '491753593883', '', NULL, 1, NULL),
(14, 'Pissotte', 'Pissotte', 'richard.francheteau@gmail.com', 'spiroo@laposte.net', 'Spiroo', 'Open national team', 'France', '33672716922', '33664220255', '33618086583', '33616708685', '33670901003', '', NULL, 1, NULL),
(15, 'theBigEz - Vienna', 'theBigEz', '', 'christian_holzinger@inode.at', 'Christian Holzinger', 'Vienna', 'Austria', '436505411902', '436502443256', '436642165781', '436764742685', NULL, '', NULL, 1, NULL),
(16, 'Solebang', 'Solebang', 'mario_baumann@hotmail.com', 'benji@gnadelos.ch', 'Benji Fischer', 'Cham', 'Schweiz', '41763377106', '41788867050', '41788032851', '41763606791', '41786814639', '', NULL, 1, NULL),
(17, 'CUS Bologna', 'Bologna', 'info@bodisc.it', 'info#@bodisc.it', 'Davide Morri', 'Bologna', 'Italy', '393334064008', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(18, 'M.U.C.', 'M.U.C.', 'michy@zamperl.com', 'jens91@mnet-online.de', 'Jens Achenbach', 'Munich', 'Germany', '491739438483', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(19, 'Flying Angels Bern (FAB)', 'Flying Angels', 'info@flyingangels.ch', 'christian.brethaut@gmail.com', 'Chris', 'Bern', 'Switzerland', '41792066331', '41787962969', NULL, NULL, NULL, '', NULL, 1, NULL),
(20, 'Spain National Team', 'Spain', 'tim.kohlstadt@gmail.com', 'ajpalmer@gmail.com', 'Tim + Justin', 'Spain', 'Spain', '34649172116', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(21, 'Iznogood', 'Iznogood', 'ckriss9-izno@yahoo.fr', 'Francoiszoubir@yahoo.fr', 'Francois', 'Paris ', 'France', '330698001248', '330698001248', NULL, NULL, NULL, '', NULL, 1, NULL),
(22, 'UL Ninjas', 'UL Ninjas', 'ulultimatefrisbee@gmail.com', 'jamesmoore@o2.ie', 'James Moore', 'Limerick', 'Ireland', '353852702485', '353879216409', '353857048535', '353863989799', '353877811008', '', NULL, 1, NULL),
(23, 'German Junior Open', 'German Junior', 'Matthias@brucklacher.com', 'matthias@brucklacher.com', 'Matthias', 'allover germany', 'germany', '491727058899', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(24, 'Gummibaerchen', 'Gummibaerchen', 'trainer@ultimate-karlsruhe.de', 'turniere@ultimate-karlsruhe.de', 'Felix Mach', 'Karlsruhe', 'Germany', '4917682121421', '4915159247750', NULL, NULL, NULL, '', NULL, 1, NULL),
(25, 'Disc Club Panthers', 'Panthers', 'info@dcp.ch', 'l.schaer@gmx.net', 'Lukas Schaer', 'Bern', 'Switzerland', '41794596728', '41792430667', NULL, NULL, NULL, '', NULL, 1, NULL),
(26, 'Russia National Team', 'Russia', 'av@rusultimate.org', 'avasilyev18@gmail.com', 'Anatoly Vasilyev', '', 'Russia', '79670919059', '79161537629', '79162117731', '79161586615', '79263879408', '', NULL, 1, NULL),
(27, 'Buggoli', 'Buggoli', 'earley.mark@gmail.com', 'coach@broccoliultimate.com', 'David Rickard', 'Dublin', 'Ireland', '353877431088', '447816540534', '447525475977', '353871226693', '353873530108', 'Great idea lads!  To clarify the team name: Broccoli and BUG are combining their squads, so you can call us Buggoli if you like!', NULL, 1, NULL),
(28, 'Soimii Patriei', 'Soimii', 'pasalega_adrian@yahoo.com', 'c_relu@yahoo.com', 'Adrian Pasalega', 'Cluj-Napoca', 'ROMANIA', '40766772772', '40745383562', NULL, NULL, NULL, '', NULL, 1, NULL),
(29, 'Denmark National Team', 'Denmark', 'administrator@dfsu.dk', 'elite@dfsu.dk', 'Taiyo JÌ¦nsson', 'Copenhagen', 'Denmark', '4528185684', '4551506588', '4561338010', '4527388129', '4551923885', '', NULL, 1, NULL),
(30, 'Sun', 'Sun', 'sunFrisbee@gmail.com', 'pabs_agro@yahoo.fr', 'Pablo Lopez', 'CrÌ©teil', 'France', '33677090606', '33607560464', NULL, NULL, NULL, '', NULL, 1, NULL),
(31, 'Friselis Club Ultimate Versailles', 'Friselis', 'friselisclubversailles@gmail.com', 'augustinscala@gmail.com', 'Gus', 'Versailles', 'France', '33688435794', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(32, '7 Schwaben', '7Schwaben', 'schlecht@selk-stuttgart.de', 'wolfi.a@gmx.de', 'Philipp Haas, Wolfgang Alder', 'Stuttgart', 'Germany', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(33, 'Barbastreji', 'Barbastreji', 'info@ultimatepadova.it', 'diego_melisi@yahoo.it', 'Diego', 'Padova', 'Italy', '393483609600', '393409799795', '393463243176', '393288456619', '393497319366', 'formerly PUF - Padova Ultimate Frisbee', NULL, 1, NULL),
(34, 'Ultimate deLux', 'deLux', 'contact@ultimate-delux.org', 'richardson_jt@yahoo.com', 'JT Richardson', 'Luxembourg', 'Luxembourg', '4916095063547', '352621699507', '491781897744', NULL, NULL, '', NULL, 1, NULL),
(35, 'Freespeed', 'Freespeed', 'info@freespeed.ch', 'flow@freespeed.ch', 'Florian Kaeser', 'Basel', 'Switzerland', '41764173505', '41788795948', NULL, NULL, NULL, '', NULL, 1, NULL),
(36, 'Flying Bisc', 'Flying Bisc', 'tuscanultimate@gmail.com', '', 'Massimo Duradoni', 'Florence', 'Italy', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(37, 'Red Lights', 'Red Lights', 'tedbeute@upcmail.nl', '', 'Ted Beute', 'Amsterdam', 'Nederland', '31614994428', '31619618365', '31644550455', '31651401141', '31647047588', '', NULL, 1, NULL),
(38, 'Les etoiles o', 'Les etoiles o', 'sigibodson@yahoo.com', 'bodsonsigi@hotmail.com', 'Sigi Bodson', 'Hasselt + Huy', 'Belgium', '32476782806', '32497305258', NULL, NULL, NULL, '', NULL, 1, NULL),
(39, 'Cambo Cakes', 'Cambo Cakes', 'wombatcummings@hotmail.com', 'miccwvdl@hotmail.com', 'Michiel van de Leur', 'Amsterdam', 'Netherlands', '31643045677', '31611000974', NULL, NULL, NULL, '', NULL, 1, NULL),
(40, 'Holland National Team', 'Netherlands', 'dutchnationalteam@gmail.com', 'tomwaijers@yahoo.com', 'Tom Waaijers', '', 'Netherlands', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(41, 'German masters', 'German Masters', 'froetsch@gmx.de', '', 'Bernhard Froetschl', '', 'Germany', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(42, 'BYE Team', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(43, 'Disco Stu', 'Disco Stu', 'raffarufus@hotmail.it', 'raffarufus@hotmail.it', 'raffaele de curtis (rufus)', 'modena', 'italy', '393331433038', '393290237770', NULL, NULL, NULL, 'Sorry, someone else made a "disco stu" team before me and in the previous registration form i chose the wrong one.\n\nrufus', NULL, 2, NULL),
(44, 'Superfly', 'Superfly', 'tomsummerbee@yahoo.com', 'tomsummerbee@yahoo.com', 'Tom Summerbee', 'Birmingham', 'England', '33611488080', '', NULL, NULL, NULL, 'Hi,\nI''m sorry but I just sent a message asking when registration opened, so please ignore that message. If you could let me know how to pay the team fee I will get that done as soon as possible.\n\nMany thanks\nTom Summerbee', NULL, 2, NULL),
(45, 'PUF', 'PUF', 'lutzmuerau@hotmail.com', 'ravi.a.vasudevan@gmail.com', 'Lutz, Ravi', 'Delft, Den Haag, Leiden', 'Netherlands', '31634313251', '31681163086', '31646690049', '31634034778', '31650894721', '', NULL, 2, NULL),
(46, 'Quijotes+Dulcineas', 'Quijotes', 'quijotesultimate@gmail.com', 'ajpalmer@gmail.com', 'Justin', 'Madrid', 'Spain', '34687278957', '34656824603', NULL, NULL, NULL, 'Looking forward to Windmill again!We finished 14th last year with half the team and a handful of pickups, but the stories we brought back seem to have convinced the rest of the team to come along this year...', NULL, 2, NULL),
(47, 'France National Team', 'France', 'intendant.mixte@ffdf.fr', 'intendant.mixte@ffdf.fr', 'Guillaume CANAL', '', 'France', '33672615141', '33688472848', NULL, NULL, NULL, '', NULL, 2, NULL),
(48, 'Stockholm Syndromes', 'Stockholm', 'ssufc@stockholmsyndromes.se', 'paul.eriksson@frisbeesport.se', 'Paul Eriksson', 'Stockholm', 'Sweden', '46739960557', '46733783257', NULL, NULL, NULL, 'Hej,\n\nWe are the Stockholm Syndromes, have never been to a Dutch tournament, but have heard only great things. Beside the Swedish guys and girls, we are a pretty international squad from Stockholm and are aiming for a fun mixed experience :-)', NULL, 2, NULL),
(49, 'Spirit on Lemon', 'Spirit on Lemon', '', 'tailor82@gmail.com', 'Tom', 'Sosnowiec', 'Poland', '48502489694', '48507120311', NULL, NULL, NULL, 'Hello\nMy nam is Tom. I''am a capitan of Spirit on Lemon Ultimate Frisbee Team from Poland!\nI would like to register my team Spirit on Lemon from Poland for this year  Windmill Windup!\nIt would be pleasure to join you!\nTom', NULL, 2, NULL),
(50, 'Cheek2Cheek', 'Cheek2Cheek', 'christoph.obenhuber@gmx.at', 'florian.eywo@gmx.at', 'Christoph Obenhuber', 'Vienna', 'Austria', '436508050081', '436504783764', NULL, NULL, NULL, 'Hi guys,\n\nWe are the current Austrian Mixed Champion and would love to come to windmill with our girlz and boyz. We have been at windmill for the last few years with our open team (bigez) and now we are looking forward to join the windmill mixed experience ;-)\n\ncheers,\nchristoph', NULL, 2, NULL),
(51, 'TeamAustria Mixed', 'Austria', 'hnowak@gmx.at', 'upsadaisy@gmx.at', 'harald nowak', 'vienna - rest of austria', 'austria', '436602266725', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(52, 'Rusty Bikes', 'Rusty Bikes', 'mariekebuijs@gmail.com', 'mariekebuijs@gmail.com', 'Marleen Vervoort, Marieke Buijs', 'Amsterdam', 'the netherlands', '31648357529', '31633695574', NULL, NULL, NULL, '', NULL, 2, NULL),
(53, 'Nuts''n Berries', 'Nuts''nBerries', 'hexemexe@web.de', 'hexemexe@web.de', 'Kathleen', 'Halle', 'Germany', '17648391108', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(54, 'German National Team', 'Germany', 'heiko.karpowski@googlemail.com', 'heiko.karpowski@googlemail.com', 'Heiko Karpowski, Janne Lepthin', '', 'Germany', '1917681187476', '491757002822', NULL, NULL, NULL, '', NULL, 2, NULL),
(55, 'Robiram Project', 'Robiram', 'tloustik@gmail.com', 'julik8@gmail.com', 'Petra Moravkova, Julia Navratova', 'Bratislava', 'Slovakia', '421904566535', '421903172634', '421903363033', '421903227746', '447877749695', '', NULL, 2, NULL),
(56, 'Holland National Team', 'Holland', 'frisbeemeisje@gmail.com', 'frisbeemeisje@gmail.com', 'roelien', 'all over', 'nederland', '31648408847', '31649393448', '31614957591', '31644822275', '31614867760', '', NULL, 2, NULL),
(57, 'WAF', 'WAF', 'waf@wur.nl', 'pnmdejongh@gmail.com,  bramtebrake1@gmail.com', 'Niek', 'Wageningen', 'Netherlands', '31634317858', '31646036901', '31634449486', '31619054127', '31644591879', '', NULL, 2, NULL),
(58, 'Akka', 'Akka', 'akka@frisbee.se', 'hanna@frisbee.se', 'Hanna', 'Lund', 'Sweden', '46722768111', '46730292948', '393397456579', '33688947876', '393282926595', '', NULL, 2, NULL),
(59, 'Ireland National Team', 'Ireland', 'irelandmixed2011@gmail.com', 'peter.forde@gmail.com', 'Peter', 'Dublin', 'Ireland', '353857068828', '353857203563', '353861994086', '353879302429', '447833645624', '', NULL, 2, NULL),
(60, 'Turkey National Team', 'Turkey', 'ord-yk@googlegroups.com', 'demir.emra@gmail.com', 'Emrah Demir', 'Ä°stanbul - Ankara', 'Turkey', '905337107856', '905373843878', NULL, NULL, NULL, '', NULL, 2, NULL),
(61, 'Cranberry Snack', 'Cranberry', 'juleclech@gmail.com', 'klaatii@gmail.com', 'Klaus Walther', 'Karlsruhe', 'Germany', '491782331741', '491631622448', NULL, NULL, NULL, 'Hey Windmillers,\n\n\n\nwe did a mistake a registered us for the Open Division, but we''re naturally mixed. We want to be registered for the MIXED DIVISON!\n\n\n\nCould you please help us to switch the division.\n\nI''m so sorry, i tried to register us several times for open. I just dont realize that i need to register especialy for mixed ;)\n\nI hope you could unterstand my doing.\n\n\n\nPlease contact me if something goes wrong or ask Nan. He should know me now ;)\n\n\n\nMy contact is: klaatii@gmail.com  \n\n\n\nThank you so much, i will bring you a present for that!\n\n\n\nSee you all in june!\n\nKlaus - Cranberry Snack\n\n\n\n', NULL, 2, NULL),
(62, 'Frizzly Bears', 'Frizzly Bears', 'hanstiro@gmx.de', '', '', '', '', '', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(63, 'Moscow Chapiteau', 'Moscow', 'moscowsharks@gmail.com', 'chernykh.ira@gmail.com', 'Alexey, Irina', 'Moscow', 'Russia', '79639785897', '79060639113', NULL, NULL, NULL, '', NULL, 2, NULL),
(64, 'Sexy Legs', 'Sexy Legs', '', 'liisa.licht@mail.ee', 'Liisa Licht', 'we''re an international team', 'mainly from Estonia', '37256218415', '37256563967', NULL, NULL, NULL, 'We''re an international team that played last year as "Tallinn Frisbee Club" in mixed division', NULL, 2, NULL),
(65, 'Frisbee Family', 'Frisbee Family', 'verena@frisbee-family.de', 'matthias@brucklacher.com', 'Doerthe, Mattes', 'Duesseldorf', 'Germany', '4917666631600', '491727071718', '491727058899', '4917620494927', NULL, '', NULL, 2, NULL),
(66, 'Switzerland National Team', 'Switzerland', 'international-coordinator@ultimate.ch', 'kian.rieben@gmail.com', 'Nef', 'Switzerland', 'Switzerland', '41763703078', '41765862927', NULL, NULL, NULL, '', NULL, 2, NULL),
(67, 'Drehst''n Deckel', 'Drehst''nDeckel', 'ulle@drehstn-deckel.de', 'kirvel@gmx.ch', 'Christian Kirvel', 'Dresden', 'Germany', '491785381277', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(68, 'Aye-Aye Ultimate (UEA)', 'Aye-Aye', 'b.hutton@uea.ac.uk', 'b.hutton@uea.ac.uk', 'Ben Hutton', 'Norwich', 'England', '7595739460', '7840391708', NULL, NULL, NULL, 'We have already registered for the open division earlier this year. We have since decided that our team would be better suited to play in the mixed division. I will therefore be removing our open division bid after submitting this bid. Sorry for all the confusion, thanks.\n\n\n\nBen Hutton\n\nAye-Aye president', NULL, 2, NULL),
(69, 'Russo Turisto', 'Russia', 'av@rusultimate.org', 'shebouniaev@yandex.ru ', 'Toly', '', 'Russia', '79670919059', '79162117731', NULL, NULL, NULL, '', NULL, 2, NULL),
(70, 'BYE Team', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1),
(71, 'Chakalakas', 'Chakalakas', 'marysmile@gmx.de', 'esther.kunay@gmx.de', 'Esther', 'all over Germany', 'Germany', '491638826584', '4915787628464', NULL, NULL, NULL, '', NULL, 3, NULL),
(72, 'Hot Beaches', 'Hot Beaches', '', 'aja_sem@centrum.cz', 'aja, katy', 'Prague', 'Czech Republic', '420774858308', '420736286157', '420774114711', '420724119726', '420606133565', '', NULL, 3, NULL),
(73, 'France National Team', 'France', 'angodet@yahoo.fr', 'angodet@yahoo.fr', 'AL', 'Paris', 'France', '33679592052', '3383103015', NULL, NULL, NULL, 'The team will count around 23 players + 3 coachs.\n\nThanks !', NULL, 3, NULL),
(74, 'Denmark National Team', 'Denmark', 'administrator@dfsu.dk', 'elite@dfsu.dk', 'Taiyo JÃ¶nsson', 'Copenhagen', 'Denmark', '4522664242', '4526247090', '4523956204', '4530381084', '4551900103', 'The National Team of Denmark would like to apply for a spot in the Windmill Womens Division 2011.', NULL, 3, NULL),
(75, 'Ireland National Team', 'Ireland', 'ladiescaptain@gmail.com', 'ladiescaptain@gmail.com', 'Laura, Linda', 'Dublin', 'Ireland', '353833702663', '32498311237', NULL, NULL, NULL, '', NULL, 3, NULL),
(76, 'Seagulls', 'Seagulls', 'info@fischbees.de', 'Britta_Kipcke@web.de', 'Britta', 'Hamburg', 'Germany', '491708150105', '', NULL, NULL, NULL, '', NULL, 3, NULL),
(77, 'Italy National Team', 'Italy', 'Frixsven@gmail.com', 'Britneyz88@yahoo.it', 'Frida Svensson', '', 'Italy', '393287016841', '393289123854', '393395980966', NULL, NULL, '', NULL, 3, NULL),
(78, 'GB National Team', 'GB', 'jennat49@yahoo.co.uk', 'me01gmt@googlemail.com', 'Jenna Thomson', '', 'United Kingdom', '447590382152', '447976364407', '447855446423', '447950315532', '447843254472', '', NULL, 3, NULL),
(79, 'Thalys', 'Thalys', 'paulinette71@yahoo.fr', 'paulinette71@yahoo.fr', 'Pauline Vicard', 'Lille/Bruxelles', 'France/Belgium', '33683049712', '33609553008', NULL, NULL, NULL, '', NULL, 3, NULL),
(80, 'DNT National Team', 'Germany', 'oburch@web.de', 'oburch@web.de', 'Silke Oldenburg', 'all over Germany', 'Germany', '4917661265079', '4917661197134', NULL, NULL, NULL, '', NULL, 3, NULL),
(81, 'Switzerland National Team', 'Switzerland', 'vogel.simone@gmail.com', 'vogel.simone@gmail.com', 'Simone Vogel', 'Geneva', 'Switzerland', '41786735048', '41793500034', NULL, NULL, NULL, '', NULL, 3, NULL),
(82, 'Holland National Team', 'Holland', 'luzia.helfer@gmail.com', 'iris.terpstra@gmail.com', 'Iris', '', 'The Netherlands', '31625266393', '31626507460', '31648797084', '31641479141', NULL, '', NULL, 3, NULL),
(83, 'Russia National Team', 'Russia', 'astreya2004@yandex.ru', 'astreya2004@yandex.ru', 'Margarita', 'Moscow', 'Russian Federation', '79647962477', '37257309038', NULL, NULL, NULL, '', NULL, 3, NULL),
(84, 'BYE Team', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_division_id_division_id` FOREIGN KEY (`division_id`) REFERENCES `division` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_tournament_id_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`) ON DELETE CASCADE;
