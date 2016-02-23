CREATE TABLE `consommation` (
	`dateB` DATE NOT NULL,
	`conso` SMALLINT(5) UNSIGNED NOT NULL,
	`Tmoy` DECIMAL(5,1) NOT NULL,
	PRIMARY KEY (`dateB`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
