<?php 
// selection du firmware
// on stock le parametre telnet N°x dans la colonne correspondante de la BDD
// c181 et c182 sont alpha numerique, le reste est numerique
switch ($firmware) {
    case '10.2h':
		$dict = [ 
			 0 =>'c3'  ,  1=>'c5'  ,  2=>'c1'  ,  3=>'c8'  ,  4=>'c9'  ,  5=>'c10' ,  6=>'c6'  ,  7=>'c21' ,  8=>'c22' ,  9=>'c25',
			10 =>'c26' , 11=>'c27' , 12=>'c23' , 13=>'c24' , 14=>'c46' , 15=>'c47' , 16=>'c73' , 17=>'c74' , 18=>'c75' , 19=>'c76',
			20 =>'c52' , 21=>'c14' , 22=>'c0'  , 23=>'c2'  , 24=>'c62' , 25=>'c77' , 26=>'c134', 27=>'c4'  , 28=>'c29' , 29=>'c30',
			30 =>'c33' , 31=>'c34' , 32=>'c35' , 33=>'c31' , 34=>'c32' , 35=>'c48' , 36=>'c49' , 37=>'c37' , 38=>'c38' , 39=>'c41',
			40 =>'c42' , 41=>'c43' , 42=>'c39' , 43=>'c40' , 44=>'c50' , 45=>'c51' , 46=>'c53' , 47=>'c15' , 48=>'c12' , 49=>'c180',
			50 =>'c168', 51=>'c146', 52=>'c147', 53=>'c63' , 54=>'c64' , 55=>'c65' , 56=>'c66' , 57=>'c11' , 58=>'c13' , 59=>'c7',
			60 =>'c67' , 61=>'c68' , 62=>'c69' , 63=>'c154', 64=>'c130', 65=>'c131', 66=>'c132', 67=>'c19' , 68=>'c17' , 69=>'c45',
			70 =>'c18' , 71=>'c16' , 72=>'c100', 73=>'c101', 74=>'c102', 75=>'c103', 76=>'c104', 77=>'c105', 78=>'c106', 79=>'c137',
			80 =>'c138', 81=>'c139', 82=>'c140', 83=>'c141', 84=>'c142', 85=>'c143', 86=>'c78' , 87=>'c79' , 88=>'c80' , 89=>'c107',
			90 =>'c148', 91=>'c108', 92=>'c109', 93=>'c116', 94=>'c117', 95=>'c118', 96=>'c119', 97=>'c120', 98=>'c121', 99=>'c54',
			100=>'c55' ,101=>'c56' ,102=>'c57' ,103=>'c58' ,104=>'c59' ,105=>'c60' ,106=>'c169',107=>'c122',108=>'c149',109=>'c150',
			110=>'c151',111=>'c152',112=>'c70' ,113=>'c71' ,114=>'c72' ,115=>'c81' ,116=>'c82' ,117=>'c83' ,118=>'c98' ,119=>'c99',
			120=>'c111',121=>'c112',122=>'c113',123=>'c114',124=>'c115',125=>'c123',126=>'c124',127=>'c125',128=>'c153',129=>'c126',
			130=>'c127',131=>'c155',132=>'c156',133=>'c128',134=>'c129',135=>'c157',136=>'c176',137=>'c177',138=>'c178',139=>'c179',
			140=>'c159',141=>'c84' ,142=>'c85' ,143=>'c86' ,144=>'c87' ,145=>'c88' ,146=>'c89' ,147=>'c90' ,148=>'c91' ,149=>'c92',
			150=>'c93' ,151=>'c94' ,152=>'c184',153=>'c186',154=>'c187',155=>'c188',156=>'c170',157=>'c171',158=>'c172',159=>'c173',
			160=>'c174',161=>'c175'
		]; 
        break;
    case '4.3d':
		$dict = [ //80=>c182
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c5'  ,  6=>'c6'  ,  7=>'c7'  ,  8=>'c8'  ,  9=>'c9',
			10 =>'c10' , 11=>'c11' , 12=>'c12' , 13=>'c13' , 14=>'c14' , 15=>'c15' , 16=>'c16' , 17=>'c17' , 18=>'c18' , 19=>'c19',
			20 =>'c20' , 21=>'c21' , 22=>'c22' , 23=>'c23' , 24=>'c24' , 25=>'c25' , 26=>'c26' , 27=>'c27' , 28=>'c28' , 29=>'c29',
			30 =>'c30' , 31=>'c31' , 32=>'c32' , 33=>'c33' , 34=>'c34' , 35=>'c35' , 36=>'c36' , 37=>'c37' , 38=>'c38' , 39=>'c39',
			40 =>'c40' , 41=>'c41' , 42=>'c42' , 43=>'c43' , 44=>'c44' , 45=>'c45' , 46=>'c46' , 47=>'c47' , 48=>'c48' , 49=>'c49',
			50 =>'c50' , 51=>'c51' , 52=>'c52' , 53=>'c53' , 54=>'c54' , 55=>'c55' , 56=>'c56' , 57=>'c57' , 58=>'c58' , 59=>'c59',
			60 =>'c60' , 61=>'c61' , 62=>'c62' , 63=>'c63' , 64=>'c64' , 65=>'c65' , 66=>'c66' , 67=>'c67' , 68=>'c68' , 69=>'c69',
			70 =>'c70' , 71=>'c71' , 72=>'c72' , 73=>'c73' , 74=>'c74' , 75=>'c75' , 76=>'c76' , 77=>'c77' , 78=>'c78' , 79=>'c79',
			80 =>'c182', 81=>'c81' , 82=>'c82' , 83=>'c83' 
		]; 
        break;
    case '14f':
		$dict = [ // inversion  c12 et c15 , suppression 167 et 168
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c5'  ,  6=>'c6'  ,  7=>'c7'  ,  8=>'c8'  ,  9=>'c9',
			10 =>'c10' , 11=>'c11' , 12=>'c12' , 13=>'c13' , 14=>'c14' , 15=>'c15' , 16=>'c16' , 17=>'c17' , 18=>'c18' , 19=>'c19',
			20 =>'c20' , 21=>'c21' , 22=>'c22' , 23=>'c23' , 24=>'c24' , 25=>'c25' , 26=>'c26' , 27=>'c27' , 28=>'c28' , 29=>'c29',
			30 =>'c30' , 31=>'c31' , 32=>'c32' , 33=>'c33' , 34=>'c34' , 35=>'c35' , 36=>'c36' , 37=>'c37' , 38=>'c38' , 39=>'c39',
			40 =>'c40' , 41=>'c41' , 42=>'c42' , 43=>'c43' , 44=>'c44' , 45=>'c45' , 46=>'c46' , 47=>'c47' , 48=>'c48' , 49=>'c49',
			50 =>'c50' , 51=>'c51' , 52=>'c52' , 53=>'c53' , 54=>'c54' , 55=>'c55' , 56=>'c56' , 57=>'c57' , 58=>'c58' , 59=>'c59',
			60 =>'c60' , 61=>'c61' , 62=>'c62' , 63=>'c63' , 64=>'c64' , 65=>'c65' , 66=>'c66' , 67=>'c67' , 68=>'c68' , 69=>'c69',
			70 =>'c70' , 71=>'c71' , 72=>'c72' , 73=>'c73' , 74=>'c74' , 75=>'c75' , 76=>'c76' , 77=>'c77' , 78=>'c78' , 79=>'c79',
			80 =>'c80' , 81=>'c81' , 82=>'c82' , 83=>'c83' , 84=>'c84' , 85=>'c85' , 86=>'c86' , 87=>'c87' , 88=>'c88' , 89=>'c89',
			90 =>'c90' , 91=>'c91' , 92=>'c92' , 93=>'c93' , 94=>'c94' , 95=>'c95' , 96=>'c96' , 97=>'c97' , 98=>'c98' , 99=>'c99',
			100=>'c100',101=>'c101',102=>'c102',103=>'c103',104=>'c104',105=>'c105',106=>'c106',107=>'c107',108=>'c108',109=>'c109',
			110=>'c110',111=>'c111',112=>'c112',113=>'c113',114=>'c114',115=>'c115',116=>'c116',117=>'c117',118=>'c118',119=>'c119',
			120=>'c120',121=>'c121',122=>'c122',123=>'c123',124=>'c124',125=>'c125',126=>'c126',127=>'c127',128=>'c128',129=>'c129',
			130=>'c130',131=>'c131',132=>'c132',133=>'c133',134=>'c134',135=>'c135',136=>'c136',137=>'c137',138=>'c138',139=>'c139',
			140=>'c140',141=>'c141',142=>'c142',143=>'c143',144=>'c144',145=>'c145',146=>'c146',147=>'c147',148=>'c148',149=>'c149',
			150=>'c150',151=>'c151',152=>'c152',153=>'c153',154=>'c154',155=>'c155',156=>'c156',157=>'c157',158=>'c158',159=>'c159',
			160=>'c160',161=>'c161',162=>'c162',163=>'c163',164=>'c164',165=>'c165',166=>'c166',                        169=>'c169',
			170=>'c170',171=>'c171',172=>'c172'
		]; 
        break;
	case '14g':
		$dict = [ // inversion  c12 et c15 , suppression 167 et 168 , 181 et 182 et 183
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c5'  ,  6=>'c6'  ,  7=>'c7'  ,  8=>'c8'  ,  9=>'c9',
			10 =>'c10' , 11=>'c11' , 12=>'c15' , 13=>'c13' , 14=>'c14' , 15=>'c12' , 16=>'c16' , 17=>'c17' , 18=>'c18' , 19=>'c19',
			20 =>'c20' , 21=>'c21' , 22=>'c22' , 23=>'c23' , 24=>'c24' , 25=>'c25' , 26=>'c26' , 27=>'c27' , 28=>'c28' , 29=>'c29',
			30 =>'c30' , 31=>'c31' , 32=>'c32' , 33=>'c33' , 34=>'c34' , 35=>'c35' , 36=>'c36' , 37=>'c37' , 38=>'c38' , 39=>'c39',
			40 =>'c40' , 41=>'c41' , 42=>'c42' , 43=>'c43' , 44=>'c44' , 45=>'c45' , 46=>'c46' , 47=>'c47' , 48=>'c48' , 49=>'c49',
			50 =>'c50' , 51=>'c51' , 52=>'c52' , 53=>'c53' , 54=>'c54' , 55=>'c55' , 56=>'c56' , 57=>'c57' , 58=>'c58' , 59=>'c59',
			60 =>'c60' , 61=>'c61' , 62=>'c62' , 63=>'c63' , 64=>'c64' , 65=>'c65' , 66=>'c66' , 67=>'c67' , 68=>'c68' , 69=>'c69',
			70 =>'c70' , 71=>'c71' , 72=>'c72' , 73=>'c73' , 74=>'c74' , 75=>'c75' , 76=>'c76' , 77=>'c77' , 78=>'c78' , 79=>'c79',
			80 =>'c80' , 81=>'c81' , 82=>'c82' , 83=>'c83' , 84=>'c84' , 85=>'c85' , 86=>'c86' , 87=>'c87' , 88=>'c88' , 89=>'c89',
			90 =>'c90' , 91=>'c91' , 92=>'c92' , 93=>'c93' , 94=>'c94' , 95=>'c95' , 96=>'c96' , 97=>'c97' , 98=>'c98' , 99=>'c99',
			100=>'c100',101=>'c101',102=>'c102',103=>'c103',104=>'c104',105=>'c105',106=>'c106',107=>'c107',108=>'c108',109=>'c109',
			110=>'c110',111=>'c111',112=>'c112',113=>'c113',114=>'c114',115=>'c115',116=>'c116',117=>'c117',118=>'c118',119=>'c119',
			120=>'c120',121=>'c121',122=>'c122',123=>'c123',124=>'c124',125=>'c125',126=>'c126',127=>'c127',128=>'c128',129=>'c129',
			130=>'c130',131=>'c131',132=>'c132',133=>'c133',134=>'c134',135=>'c135',136=>'c136',137=>'c137',138=>'c138',139=>'c139',
			140=>'c140',141=>'c141',142=>'c142',143=>'c143',144=>'c144',145=>'c145',146=>'c146',147=>'c147',148=>'c148',149=>'c149',
			150=>'c150',151=>'c151',152=>'c152',153=>'c153',154=>'c154',155=>'c155',156=>'c156',157=>'c157',158=>'c158',159=>'c159',
			160=>'c160',161=>'c161',162=>'c162',163=>'c163',164=>'c164',165=>'c165',166=>'c166',                        169=>'c169',
			170=>'c170',171=>'c171',172=>'c172',173=>'c173',174=>'c174',175=>'c175',176=>'c176',177=>'c177',178=>'c178',179=>'c179',
			180=>'c180',                                    184=>'c184',185=>'c185',186=>'c186',187=>'c187',188=>'c188'
		]; 
        break;
    case '14i':
	case '14j':
	case '14k':
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c5'  ,  6=>'c53' ,  7=>'c52' ,  8=>'c134',  9=>'c56',
			10 =>'c57' , 11=>'c58' , 12=>'c59' , 13=>'c60' , 14=>'c61' , 15=>'c6'  , 16=>'c7'  , 17=>'c8'  , 18=>'c178', 19=>'c9',
			20 =>'c179', 21=>'c10' , 22=>'c11' , 23=>'c12' , 24=>'c13' , 25=>'c15' , 26=>'c129', 27=>'c160', 28=>'c54' , 29=>'c55',
			30 =>'c116', 31=>'c117', 32=>'c112', 33=>'c111', 34=>'c113', 35=>'c114', 36=>'c154', 37=>'c130', 38=>'c136', 39=>'c62',
			40 =>'c95' , 41=>'c96' , 42=>'c180', 43=>'c177', 44=>'c176', 45=>'c128', 46=>'c115', 47=>'c99' , 48=>'c81' , 49=>'c97',
			50 =>'c16' , 51=>'c17' , 52=>'c137', 53=>'c45' , 54=>'c84' , 55=>'c100', 56=>'c21' , 57=>'c23' , 58=>'c138', 59=>'c46',
			60 =>'c85' , 61=>'c101', 62=>'c22' , 63=>'c24' , 64=>'c139', 65=>'c47' , 66=>'c86' , 67=>'c102', 68=>'c29' , 69=>'c31',
			70 =>'c140', 71=>'c48' , 72=>'c87' , 73=>'c103', 74=>'c30' , 75=>'c32' , 76=>'c141', 77=>'c49' , 78=>'c88' , 79=>'c104',
			80 =>'c37' , 81=>'c39' , 82=>'c142', 83=>'c50' , 84=>'c89' , 85=>'c105', 86=>'c38' , 87=>'c40' , 88=>'c143', 89=>'c51',
			90 =>'c90' , 91=>'c106', 92=>'c19' , 93=>'c20' , 94=>'c91' , 95=>'c27' , 96=>'c28' , 97=>'c92' , 98=>'c35' , 99=>'c36',
			100=>'c93' ,101=>'c43' ,102=>'c44' ,103=>'c94' ,104=>'c107',105=>'c108',106=>'c109',107=>'c110',108=>'c168',109=>'c146',
			110=>'c147',111=>'c148',112=>'c149',113=>'c150',114=>'c151',115=>'c152',116=>'c153',117=>'c169',118=>'c170',119=>'c171',
			120=>'c172',121=>'c173',122=>'c174',123=>'c175',124=>'c73' ,125=>'c74' ,126=>'c75' ,127=>'c76' ,128=>'c77' ,129=>'c78',
			130=>'c79' ,131=>'c80' ,132=>'c118',133=>'c119',134=>'c120',			182=>'c182',183=>'c181',187=>'c187'
		]; 
        break;
	case '14l':
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c5'  ,  6=>'c53' ,  7=>'c52' ,  8=>'c134',  9=>'c56',
			10 =>'c57' , 11=>'c58' , 12=>'c59' , 13=>'c60' , 14=>'c61' , 15=>'c6'  , 16=>'c7'  , 17=>'c8'  , 18=>'c178', 19=>'c9',
			20 =>'c179', 21=>'c10' , 22=>'c11' , 23=>'c12' , 24=>'c13' , 25=>'c15' , 26=>'c129', 27=>'c160', 28=>'c54' , 29=>'c55',
			30 =>'c116', 31=>'c117', 32=>'c112', 33=>'c111', 34=>'c113', 35=>'c114', 36=>'c154', 37=>'c130', 38=>'c136', 39=>'c62',
			40 =>'c95' , 41=>'c96' , 42=>'c180', 43=>'c177', 44=>'c176', 45=>'c128', 46=>'c115', 47=>'c99' , 48=>'c81' , 49=>'c97',
			50 =>'c16' , 51=>'c17' , 52=>'c137', 53=>'c45' , 54=>'c84' , 55=>'c100', 56=>'c21' , 57=>'c23' , 58=>'c138', 59=>'c46',
			60 =>'c85' , 61=>'c101', 62=>'c22' , 63=>'c24' , 64=>'c139', 65=>'c47' , 66=>'c86' , 67=>'c102', 68=>'c29' , 69=>'c31',
			70 =>'c140', 71=>'c48' , 72=>'c87' , 73=>'c103', 74=>'c30' , 75=>'c32' , 76=>'c141', 77=>'c49' , 78=>'c88' , 79=>'c104',
			80 =>'c37' , 81=>'c39' , 82=>'c142', 83=>'c50' , 84=>'c89' , 85=>'c105', 86=>'c38' , 87=>'c40' , 88=>'c143', 89=>'c51',
			90 =>'c90' , 91=>'c106', 92=>'c19' , 93=>'c20' , 94=>'c91' , 95=>'c27' , 96=>'c28' , 97=>'c92' , 98=>'c35' , 99=>'c36',
			100=>'c93' ,101=>'c43' ,102=>'c44' ,103=>'c94' ,104=>'c107',105=>'c108',106=>'c109',107=>'c110',108=>'c168',109=>'c146',
			110=>'c147',111=>'c148',112=>'c149',113=>'c150',114=>'c151',115=>'c152',116=>'c153',117=>'c169',118=>'c170',119=>'c171',
			120=>'c172',121=>'c173',122=>'c174',123=>'c175',124=>'c73' ,125=>'c74' ,126=>'c75' ,127=>'c76' ,128=>'c77' ,129=>'c78',
			130=>'c79' ,131=>'c80' ,132=>'c118',133=>'c119',134=>'c120',135=>'c162',136=>'c166',137=>'c167',138=>'c186',139=>'c187',
			140=>'c188'
		]; 
        break;
	case '14m':
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c5'  ,  6=>'c53' ,  7=>'c52' ,  8=>'c134',  9=>'c56',
			10 =>'c57' , 11=>'c58' , 12=>'c59' , 13=>'c60' , 14=>'c61' , 15=>'c6'  , 16=>'c7'  , 17=>'c8'  , 18=>'c178', 19=>'c9',
			20 =>'c179', 21=>'c10' , 22=>'c11' , 23=>'c12' , 24=>'c13' , 25=>'c15' , 26=>'c129', 27=>'c160', 28=>'c54' , 29=>'c55',
			30 =>'c116', 31=>'c117', 32=>'c112', 33=>'c111', 34=>'c113', 35=>'c114', 36=>'c154', 37=>'c130', 38=>'c136', 39=>'c62',
			40 =>'c95' , 41=>'c96' , 42=>'c180', 43=>'c177', 44=>'c176', 45=>'c128', 46=>'c115', 47=>'c99' , 48=>'c81' , 49=>'c97',
			50 =>'c16' , 51=>'c17' , 52=>'c137', 53=>'c45' , 54=>'c84' , 55=>'c100', 56=>'c21' , 57=>'c23' , 58=>'c138', 59=>'c46',
			60 =>'c85' , 61=>'c101', 62=>'c22' , 63=>'c24' , 64=>'c139', 65=>'c47' , 66=>'c86' , 67=>'c102', 68=>'c29' , 69=>'c31',
			70 =>'c140', 71=>'c48' , 72=>'c87' , 73=>'c103', 74=>'c30' , 75=>'c32' , 76=>'c141', 77=>'c49' , 78=>'c88' , 79=>'c104',
			80 =>'c37' , 81=>'c39' , 82=>'c142', 83=>'c50' , 84=>'c89' , 85=>'c105', 86=>'c38' , 87=>'c40' , 88=>'c143', 89=>'c51',
			90 =>'c90' , 91=>'c106', 92=>'c19' , 93=>'c20' , 94=>'c91' , 95=>'c27' , 96=>'c28' , 97=>'c92' , 98=>'c35' , 99=>'c36',
			100=>'c93' ,101=>'c43' ,102=>'c44' ,103=>'c94' ,104=>'c107',105=>'c108',106=>'c109',107=>'c110',108=>'c168',109=>'c146',
			110=>'c147',111=>'c148',112=>'c149',113=>'c150',114=>'c151',115=>'c152',116=>'c153',117=>'c169',118=>'c170',119=>'c171',
			120=>'c172',121=>'c173',122=>'c174',123=>'c175',124=>'c73' ,125=>'c74' ,126=>'c75' ,127=>'c76' ,128=>'c77' ,129=>'c78',
			130=>'c79' ,131=>'c80' ,132=>'c118',133=>'c119',134=>'c120',135=>'c162',136=>'c166',137=>'c167',138=>'c186',139=>'c187',
			140=>'c188',141=>'c121' ,142=>'c122',143=>'c193'
		]; 
        break;
	case '14n':
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c12' ,  6=>'c13' ,  7=>'c176',  8=>'c5'  ,  9=>'c53',
			10 =>'c52' , 11=>'c8'  , 12=>'c9'  , 13=>'c10' , 14=>'c180', 15=>'c96' , 16=>'c106', 17=>'c95' , 18=>'c110', 19=>'c11',
			20 =>'c134', 21=>'c56' , 22=>'c48' , 23=>'c49' , 24=>'c50' , 25=>'c51' , 26=>'c55' , 27=>'c160', 28=>'c54' , 29=>'c121',
			30 =>'c97' , 31=>'c57' , 32=>'c58' , 33=>'c59' , 34=>'c60' , 35=>'c61' , 36=>'c112', 37=>'c111', 38=>'c113', 39=>'c114',
			40 =>'c115', 41=>'c99' , 42=>'c154', 43=>'c130', 44=>'c136', 45=>'c62' , 46=>'c79' , 47=>'c73' , 48=>'c129', 49=>'c15',
			50 =>'c76' , 51=>'c119', 52=>'c128', 53=>'c6'  , 54=>'c7'  , 55=>'c107', 56=>'c16' , 57=>'c17' , 58=>'c137', 59=>'c45',
			60 =>'c84' , 61=>'c100', 62=>'c21' , 63=>'c23' , 64=>'c138', 65=>'c46' , 66=>'c85' , 67=>'c101', 68=>'c22' , 69=>'c24',
			70 =>'c139', 71=>'c47' , 72=>'c86' , 73=>'c102', 74=>'c120', 75=>'c41' , 76=>'c187', 77=>'c42' , 78=>'c186', 79=>'c188',
			80 =>'c19' , 81=>'c20' , 82=>'c27' , 83=>'c28' , 84=>'c92' , 85=>'c80' , 86=>'c118', 87=>'c145', 88=>'c168', 89=>'c146',
			90 =>'c147', 91=>'c148', 92=>'c149', 93=>'c150', 94=>'c151', 95=>'c152', 96=>'c153', 97=>'c169', 98=>'c170', 99=>'c171',
			100=>'c172',101=>'c173',102=>'c174',103=>'c182',104=>'c181' ,105=>'c165',106=>'c166',107=>'c167' 
		]; 
        break;
	case 'V14.0HAR.n6':
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c12' ,  6=>'c13' ,  7=>'c176',  8=>'c5'  ,  9=>'c53',
			10 =>'c52' , 11=>'c8'  , 12=>'c9'  , 13=>'c10' , 14=>'c180', 15=>'c96' , 16=>'c106', 17=>'c95' , 18=>'c110', 19=>'c11',
			20 =>'c134', 21=>'c56' , 22=>'c131', 23=>'c132', 24=>'c50' , 25=>'c51' , 26=>'c55' , 27=>'c160', 28=>'c54' , 29=>'c121',
			30 =>'c97' , 31=>'c175', 32=>'c57' , 33=>'c58' , 34=>'c59' , 35=>'c60' , 36=>'c61' , 37=>'c113', 38=>'c112', 39=>'c111',
			40 =>'c154', 41=>'c114', 42=>'c115', 43=>'c99',  44=>'c130', 45=>'c136', 46=>'c62' , 47=>'c79' , 48=>'c73' , 49=>'c129',
			50 =>'c15' , 51=>'c76' , 52=>'c119', 53=>'c128', 54=>'c133', 55=>'c6'  , 56=>'c7'  , 57=>'c107', 58=>'c108', 59=>'c16' ,
			60 =>'c17' , 61=>'c137', 62=>'c45' , 63=>'c84' , 64=>'c21' , 65=>'c23' , 66=>'c138', 67=>'c123', 68=>'c46' , 69=>'c101',
			70 =>'c85' , 71=>'c22' , 72=>'c24' , 73=>'c139', 74=>'c47' , 75=>'c86' , 76=>'c102', 77=>'c29' , 78=>'c31' , 79=>'c33',
			80 =>'c48' , 81=>'c87' , 82=>'c103', 83=>'c30' , 84=>'c32' , 85=>'c34' , 86=>'c49' , 87=>'c88' , 88=>'c104', 89=>'c120',
			90 =>'c41' , 91=>'c187', 92=>'c42' , 93=>'c186', 94=>'c188', 95=>'c19' , 96=>'c20' , 97=>'c27' , 98=>'c28' , 99=>'c35',
			100=>'c36' ,101=>'c92' ,102=>'c80' ,103=>'c118',104=>'c145',105=>'c182', 106=>'c181',107=>'c147',108=>'c148',109=>'c149',
			110=>'c150',111=>'c151',112=>'c152'
		]; 
        break;
	case 'V14.0HAR.o':
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c12' ,  6=>'c13' ,  7=>'c176',  8=>'c5'  ,  9=>'c53',
			10 =>'c52' , 11=>'c8'  , 12=>'c9'  , 13=>'c10' , 14=>'c180', 15=>'c96' , 16=>'c106', 17=>'c95' , 18=>'c110', 19=>'c11',
			20 =>'c134', 21=>'c56' , 22=>'c48' , 23=>'c49' , 24=>'c50' , 25=>'c51' , 26=>'c55' , 27=>'c160', 28=>'c54' , 29=>'c121',
			30 =>'c97' , 31=>'c175', 32=>'c57' , 33=>'c58' , 34=>'c59' , 35=>'c60' , 36=>'c61' , 37=>'c112', 38=>'c111', 39=>'c113',
			40 =>'c114', 41=>'c115', 42=>'c99' , 43=>'c154', 44=>'c130', 45=>'c136', 46=>'c62' , 47=>'c79' , 48=>'c73' , 49=>'c129',
			50 =>'c15' , 51=>'c76' , 52=>'c119', 53=>'c128', 54=>'c6'  , 55=>'c7'  , 56=>'c107', 57=>'c16' , 58=>'c17' , 59=>'c137',
			60 =>'c45' , 61=>'c84' , 62=>'c100', 63=>'c21' , 64=>'c23' , 65=>'c138', 66=>'c46' , 67=>'c85' , 68=>'c101', 69=>'c22' ,
			70 =>'c24' , 71 =>'c139',72=>'c47' , 73=>'c86' , 74=>'c102', 75=>'c120', 76=>'c41' , 77=>'c187', 78=>'c42' , 79=>'c186',
			80 =>'c188', 81 =>'c19', 82=>'c20' , 83=>'c27' , 84=>'c28' , 85=>'c92' , 86=>'c80' , 87=>'c118', 88=>'c145', 89=>'c168',
			90 =>'c146', 91 =>'c147',92=>'c148', 93=>'c149', 94=>'c150', 95=>'c151', 96=>'c152', 97=>'c153', 98=>'c169', 99=>'c170',
			100=>'c171',101=>'c172',102=>'c173',103=>'c174',104=>'c182',105=>'c181' ,106=>'c165',107=>'c166',108=>'c167' 
		]; 
        break;
	case 'V14.0HAR.o2':
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c12' ,  6=>'c13' ,  7=>'c176',  8=>'c5'  ,  9=>'c53',
			10 =>'c52' , 11=>'c8'  , 12=>'c9'  , 13=>'c10' , 14=>'c180', 15=>'c96' , 16=>'c106', 17=>'c95' , 18=>'c110', 19=>'c11',
			20 =>'c134', 21=>'c56' , 22=>'c131', 23=>'c132', 24=>'c50' , 25=>'c51' , 26=>'c55' , 27=>'c160', 28=>'c54' , 29=>'c121',
			30 =>'c97' , 31=>'c175', 32=>'c57' , 33=>'c58' , 34=>'c59' , 35=>'c60' , 36=>'c61' , 37=>'c112', 38=>'c111', 39=>'c113',
			40 =>'c114', 41=>'c115', 42=>'c99' , 43=>'c154', 44=>'c130', 45=>'c136', 46=>'c62' , 47=>'c79' , 48=>'c73' , 49=>'c129',
			50 =>'c15' , 51=>'c76' , 52=>'c119', 53=>'c128', 54=>'c6'  , 55=>'c7'  , 56=>'c133', 57=>'c107', 58=>'c108', 59=>'c16' ,
			60 =>'c17' , 61=>'c137', 62=>'c45' , 63=>'c84' , 64=>'c100', 65=>'c21' , 66=>'c23' , 67=>'c138', 68=>'c46' , 69=>'c85' ,
			70 =>'c101', 71=>'c22' , 72=>'c24' , 73=>'c139', 74=>'c47' , 75=>'c86' , 76=>'c102', 77=>'c29' , 78=>'c31' , 79=>'c33',
			80 =>'c48' , 81=>'c87' , 82=>'c103', 83=>'c30' , 84=>'c32' , 85=>'c34' , 86=>'c49' , 87=>'c88' , 88=>'c104', 89=>'c120',
			90 =>'c41' , 91=>'c187', 92=>'c42' , 93=>'c186', 94=>'c188', 95=>'c19' , 96=>'c20' , 97=>'c27' , 98=>'c28' , 99=>'c35',
			100=>'c36' ,101=>'c92' ,102=>'c80' ,103=>'c118',104=>'c145',105=>'c168', 106=>'c146',107=>'c147',108=>'c148',109=>'c149',
			110=>'c150',111=>'c151',112=>'c152',113=>'c153',114=>'c169',115=>'c170', 116=>'c171',117=>'c172',118=>'c173',119=>'c174',
			120=>'c182',121=>'c165',122=>'c166',123=>'c167'
		]; 
        break;
	case 'V14.0HAR.p':
	default:
		$dict = [
			 0 =>'c0'  ,  1=>'c1'  ,  2=>'c2'  ,  3=>'c3'  ,  4=>'c4'  ,  5=>'c12' ,  6=>'c13' ,  7=>'c176',  8=>'c5'  ,  9=>'c53',
			10 =>'c52' , 11=>'c8'  , 12=>'c9'  , 13=>'c10' , 14=>'c180', 15=>'c96' , 16=>'c106', 17=>'c95' , 18=>'c110', 19=>'c11',
			20 =>'c134', 21=>'c56' , 22=>'c131', 23=>'c132', 24=>'c50' , 25=>'c51' , 26=>'c55' , 27=>'c160', 28=>'c54' , 29=>'c121',
			30 =>'c97' , 31=>'c175', 32=>'c57' , 33=>'c58' , 34=>'c59' , 35=>'c60' , 36=>'c61' , 37=>'c112', 38=>'c111', 39=>'c113',
			40 =>'c114', 41=>'c115', 42=>'c99' , 43=>'c154', 44=>'c130', 45=>'c136', 46=>'c62' , 47=>'c79' , 48=>'c73' , 49=>'c129',
			50 =>'c15' , 51=>'c76' , 52=>'c119', 53=>'c128', 54=>'c6'  , 55=>'c7'  , 56=>'c107', 57=>'c16' , 58=>'c17' , 59=>'c137' ,
			60 =>'c45' , 61=>'c84' , 62=>'c100', 63=>'c21' , 64=>'c23' , 65=>'c138', 66=>'c46' , 67=>'c85' , 68=>'c101', 69=>'c22' ,
			70 =>'c24' , 71=>'c139', 72=>'c47' , 73=>'c86' , 74=>'c102', 75=>'c120', 76=>'c41' , 77=>'c187', 78=>'c42' , 79=>'c186',
			80 =>'c188', 81=>'c19' , 82=>'c20' , 83=>'c27' , 84=>'c28' , 85=>'c92' , 86=>'c80' , 87=>'c118', 88=>'c145', 89=>'c168',
			90 =>'c146', 91=>'c147', 92=>'c148', 93=>'c149', 94=>'c150', 95=>'c151', 96=>'c152', 97=>'c153', 98=>'c169', 99=>'c170',
			100=>'c171',101=>'c172',102=>'c173',103=>'c174',104=>'c182',105=>'c165'
		]; 
        break;
}

// ajout de firmware :
// penser a modifier json_telnet  en cas d'ajout de firmware	

?>
