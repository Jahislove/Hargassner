-- suite passage firmaware 14.0i
-- requete pour ajouter les colonnes manquantes 
-- si vous avez une BDD qui s'arrete à la colonne c172

ALTER TABLE hargassner.data
ADD COLUMN  `c173` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c174` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c175` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c176` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c177` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c178` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c179` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c180` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c181` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c182` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c183` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c184` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c185` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c186` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c187` decimal(7,2) NOT NULL DEFAULT '0.00',
ADD COLUMN  `c188` decimal(7,2) NOT NULL DEFAULT '0.00'

