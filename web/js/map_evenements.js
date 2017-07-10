﻿var events = [
	{name: "palacio", place: "Rue Maurice Gunsbourg, 94200 Ivry-sur-Seine"},
	{name: "Le River & Sea", place: "6, Quai Jean Compagnon, Ivry Sur Seine 94200"},
	{name: "Libertalia", place: "quai n°6 Jean Campagnon 94200 Ivry Sur Seine"},
	{name: "Get in step", place: "Parc de la Villette, 211 avenue Jean Jaurès, 75019, Paris, France"},
	{name: "10 years diynamic", place: "32-34 rue Marbeuf, 75008, Paris, France"},
	{name: "concrete", place: "69 quai de la rapée, 75012, Paris, France"},
	{name: "dream nations", place: "50 avenue du Président Wilson, 93200, La Plaine Saint-Denis, France"},
	{name: "zone records", place: "5 boulevard Poissonnière, 75002, Paris, France"},
	{name: "Pearson Sound b2b Call Super/ Matrixxman/Ben Vedren /Alice Revel", place: "69 quai de la rapée, 75012, Paris, France"}
	{name: "IPN-CLUB", place: "23 rue Mouffetard, 750005, Paris, France"},
	{name: "Le Wanderlust-bar musique", place: "32 quai d’Austerlitz, 75013, Paris, France"},
	{name: "Rosa Bonheur-Bar", place: "Parc des buttes chaumont, 75019, Paris, France"},
	{name: "Le Rex Club-Club ", place: "5 boulevard poissonnière, 75002, Paris, France"},
	{name: "L’escale-Club", place: "15 rue Monsieur-le-Prince, 75006, Paris, France"},
	{name: "Le DJOON-Club", place: "22-24 boulevard Vincent-Auriol, 75013, Paris, France"},
	{name: "Barramundi-club", place: "3 rue taitbout, 75009, Paris, France"},
	{name: "Palais Maillot-club", place: "palais des congrés, 75017, Paris, France"},
	{name: "Le n’importe quoi-Club", place: "16 rue du roule, 75001, Paris, France"},
	{name: "Le YoYo-Club", place: "20 avenue de New-York, 75016, Paris, France"},
	{name: "VIP Room-Club", place: "188bis, rue de rivoli, 75001, Paris, France"},
	{name: "Le CUD-Club", place: "12 rue des haudriettes, 75003, Paris, France"},
	{name: "Le JAVA-Club", place: "105 rue du Faubourg du temple, 75010, Paris, France"},
	{name: "Le Globo-club", place: "8 boulevard de strasbourg, 75010, Paris, France"},
	{name: "Le Queen-Club", place: "79 avenue des champs elysée, 75008, Paris, France"},
	{name: "Le Showcase-club", place: "Sous le pont alexandre, 75008, Paris, France"},
	{name: "Le Mix club-club", place: "24 rue de l’arrivée, 75015, Paris, France"},
	{name: "L’elysee montmartre-club", place: "72 boulevard de rochechouart, 75018, Paris, France"},
	{name: "L’insolite-club", place: "33 rue des petits-champ, 75001, Paris, France"},
	{name: "LA coupole", place: "102 boulevard du Montparnasse, 75014, Paris, France"},
	{name: "CITY ROCK-Bar", place: "15 rue Chemin-neuf, 78240, Chambourcy, France"},
	{name: "L’ermitage-bar", place: "68 chemin de meaux, 77144, Meaux, France"},
	{name: "Keysatis", place: "17 rue Kervégan, 44000, Nante, France"},
	{name: "LC Club", place: "21 quai des Antilles, 44000, Nante, France"},
	{name: "La réserve", place: "8 rue saint nicolas, 44000, Nante, France"},
	{name: "Color Club", place: "3 rue de l’Emery, 44000, Nante, France"},
	{name: "Le loft", place: "9 rue franklin, 44000, Nante, France"},
	{name: "Cafk", place: "2 rue Bossuet, 44000, Nante, France"},
	{name: "Le Marlowe", place: "1 place saint-vincent, 44000, Nante, France"},
	{name: "Le Floride", place: "4 rue saint Domingue, 44000, Nante, France"},
	{name: "Le royal", place: "7 rue Salorges, 44000, Nante, France"},
	{name: "Elephant Club", place: "10 place de la Bourse, 44000, Nante, France"},
	{name: "Jamboree shooter-bar", place: "22 rue du pas georges, 33000, Bordeaux, France"},
	{name: "LE 21", place: "21 rue Mably, 33000, Bordeaux, France"},
	{name: "La calle Ocho", place: "24 rue des piliers de tutelle, 33000, Bordeaux, France"},
	{name: "Le loft", place: "8 place Tourny, 33000, Bordeaux, France"},
	{name: "Théatro", place: "24 rue de la Faiencerie, 33000, Bordeaux, France"},
	{name: "After le Next", place: "6 rue Cabanac, 33000, Bordeaux, France"},
	{name: "Le Deck Club", place: ": Quai armand lalande, 33000, Bordeaux, France"},
	{name: "La plage", place: "40 quai de paludate, 33000, Bordeaux, France"},
	{name: "Le Bistrot Discothèque", place: "50 quai de Paludate, 33000, Bordeaux, France"},
	{name: "Black Diamond", place: "5 cours de l’intendance, 33000, Bordeaux, France"},
	{name: "Club Pernot", place: "23 quai des chartrons, 33000, Bordeaux, France"},
	{name: "L’intermédiaire live", place: "63 place jean jaurès, 13006, Marseille, France"},
	{name: "Vip’s Club", place: "40 rue saint pierre, 13000, Marseille, France"},
	{name: "La palmeraie ice club", place: "90 boulevard Rabatau, 13008, Marseille, France"},
	{name: "La new Palace", place: "10 place jean-jaurès 13001, 13001, Marseille, France"},
	{name: "L’endroit", place: "242 route des trois lucs, 13011, Marseille, France"},
	{name: "Maxi Club", place: "23 rue saint-saens, 13001, Marseille, France"},
	{name: "La fiesta", place: "6a rue crudère, 13006, Marseille, France"},
	{name: "Le bazar", place: "90 boulevard Rabatau, 13008, Marseille, France"},
	{name: "Millènium Club Marseille", place: "141 route léon lachamp, 13009, Marseille, France"},
	{name: "Le Baby", place: "2 rue andré poggioli, 13006, Marseille, France"},
	{name: "Le QG", place: "22 rue joseph serlin, 69001, Lyon, France"},
	{name: "Le lavoir Public", place: "4 impasse flesselles, 69005, Lyon, France"},
	{name: "Black and white", place: "Black and white, 69005, Lyon, France"},
	{name: "Le Sucre", place: "50 Quaie Rambaud, 69002, Lyon, France"},
	{name: "Barrio club", place: "Barrio club, 69006, Lyon, France"},
	{name: "La Grange au bouc", place: "9 quai Romain Rolland, 69005, Lyon, France"},
	{name: "L’ambassade", place: "4 rue stella, 69002, Lyon, France"},
	{name: "La maison mère", place: "21 place gabriel rambaud, 69001, Lyon, France"},
	{name: "Loft Club", place: "7 rue Renan, 69007, Paris, France"},
	{name: "La Dynamo", place: "6 rue Amélie, 31000, Toulouse, France"},
	{name: "Blackout discothèque", place: "1 bis rue puit du vert, 31000, Toulouse, France"},
	{name: "Le purple", place: "2 rue Castellane, 31000, Toulouse, France"},
	{name: "Ubu", place: "16 rue St Rome, 31000, Toulouse, France"},
	{name: "Opium Club", place: "20 Rue Denfert Rochereau, 31000, Toulouse, France"},
	{name: "Le moloko", place: "6 rue Joutx Aigues, 31000, Toulouse, France"},
	{name: "La voile Blanche", place: "26 allées des Foulques, 31000, Toulouse, France"},
	{name: "I Bar", place: "3 rue Gabriel Pèry, 31000, Toulouse, France"},
	{name: "Shanghai Express", place: "12 rue de la pomme, 31000, Toulouse, France"},
	{name: "Puerto Habana", place: "12 port Saint-Etienne, 31000, Toulouse, France"},
	{name: "concrete", place: "69 quai de la rapée, 75012, Toulouse, France"},
	{name: "Le Glam", place: "6 rue engène Emmanuel, 06000, Nice, France"},
	{name: "Le Garden", place: "6 rue engène Emmanuel, 06000, Nice, France"},
	{name: "Apotheka", place: "2 rue de la prefecture, 06300, Nice, France"},
	{name: "Blu-not", place: "24 rue Benoît Bunico, 06300, Nice, France"},	
	{name: "Shadow Bar", place: "12 rue Benoît Bunico, 06300, Nice, France"},
	{name: "Shadow Bar", place: "12 rue de l’Abbaye, 06300, Nice, France"},
	{name: "Le Hight Club", place: "45 promenade des Anglais, 06000, Nice, France"},
	{name: "Feeling", place: "14 rue Pertinax, 06000, Nice, France"},
	{name: "Pure", place: "2 rue Raoul Bosio, 06300, Nice, France"},
	{name: "Les coulisses Club", place: "12 rue Chauvin, 06000, Nice, France"},
	{name: "Ponts-couverts", place: "Rue des ponts couverts, 67000, Strasbourg, France"},
	{name: "Live Club", place: "1 rue Miroir, 67000, Strasbourg, France"},
	{name: "Le Rafiot", place: "Quai des pêcheurs, 67000, Strasbourg, France"},
	{name: "You Club", place: "19 rue du marais vert, 67000, Strasbourg, France"},
	{name: "Lobbiz bar", place: "20 rue du jeu des enfants, 67000, Strasbourg, France"},
	{name: "Le Vog", place: "17 rue des moulins, 67000, Strasbourg, France"},
	{name: "Retro Club", place: "24 place des halles, 67000, Strasbourg, France"},
	{name: "Jimmy’s Bar", place: "30 quai des bateliers, 67000, Strasbourg, France"},
	{name: "L’Elastic bar", place: "27 Rue des Orphelins, 67000, Strasbourg, France"},
	{name: "Le Huit", place: "8 rue l’aiguillerie, 34000, Montpellier, France"},
	{name: "Le Bellano", place: "Route des Plages, 34000, Montpellier, France"},
	{name: "L’Opéra bar", place: "2 rue D’alger, 34000, Montpellier, France"},
	{name: "L’Opéra bar", place: "5 Rue du Grand Saint-Jean, 34000, Montpellier, France"},
	{name: "Le Moon", place: "4 rue collot, 34000, Montpellier, France"},
	{name: "Le Yam’s", place: "4 place de la comédie, 34000, Montpellier, France"},
	{name: "Le Panama Café", place: "5 rue de la république, 34000, Montpellier, France"},
	{name: "Gao Montpellier", place: "31 Avenue Charles flahault, 34090, Montpellier, France"},
	{name: "Le Duplex", place: "167 rue des Palavas, 34070, Montpellier, France"},
	{name: "Le Mojomatic", place: "1 rue Cambacérès, 34000, Montpellier, France"},
	{name: "Stairway", place: "18 rue de la halle, 59800, Paris, France"},
	{name: "Le duplex", place: "1 rue du curé de saint etienne, 59800, Paris, France"},
	{name: "L’entrepôt", place: "150 rue de Solférino, 59800, Paris, France"},
	{name: "Golden Wave", place: "7 bis rue des arts, 59800, Paris, France"},
	{name: "Le Network", place: "15 rue du faisan, 59800, Paris, France"},
	{name: "Smile Club", place: "3 rue Ernest deconynck, 59000, Paris, France"},
	{name: "Les Folie’s", place: "52 avenue du people Belge, 59800, Paris, France"},
	{name: "Latina café", place: "44 rue Masséna, 59800, Paris, France"},
	{name: "La quite", place: "32 place louise de bettignies, 59800, Paris, France"},
	{name: "Le Duke’s", place: "8 rue Gosselet, 59000, Paris, France"},
];
