<?php

	header('Cache-control: public'); // IE 6 FIX (private)
	header('Content-Type: text/html; charset=UTF-8');
//    header("Cache-Control: must-revalidate");
//
//    $offset = 60 * 60 * 24 * 5;
//    $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
//    header($ExpStr);

    $host = "localhost";
    $user = "btiquets_user";
    $pass = "6hmynoYk";
    $databaseName = "btiquets";
    $server = "https://btiquets.com";    
    $zone = "Europe/Madrid";
    $info_mail = 'btiquets@btiquets.com';
    $admin_mail = 'btiquets@btiquets.com';
    $admin_tel = '686108724';
    $SUPERUSER = 6;
    $iva_1 = 21;
    $iva_2 = 10;
    $iva_3 = 7;
    $rootfolder = "/btiquets/";
    
    $mysqli = new mysqli($host, $user, $pass, $databaseName);	

    
    // Per tenir una referència a la BBDD de BTiquets
    $host_bt = "localhost";
    $user_bt = "btiquets_user";
    $pass_bt = "6hmynoYk";
    $databaseName_bt = "btiquets";       
    
    $mysqli_btiquets = new mysqli($host_bt, $user_bt, $pass_bt, $databaseName_bt);

	if(isset($_COOKIE["lang"]))
	{
		$lang = $_COOKIE["lang"];
	}
	else
	{
		$lang = 'ca';
        setcookie("lang", $lang, time() + (3600 * 24 * 30),"/");
	}

    $lan_dir="";
    switch($lang)
    {
        case 'es':
            $lan_dir = "es/";
            $lan_code = 1;
            break;
        
        case 'en':
            $lan_dir = "en/";
            $lan_code = 2;
            break;
        
        default:
            $lan_dir = "";
            $lan_code = 3;
            break;
    }

    define("cookies_1","Utilitzem cookies en aquest lloc per assegurar la millor experiència possible a l'usuari. Si continua la navegació sense necessitat de canviar la configuració del navegador, considerem que accepta l'ús d'aquestes cookies. Per obtenir més informació, inclosa la forma de canviar la configuració del navegador, si us plau llegiu la nostra");
    define("cookies_2",'Aquest web utilitza tant cookies temporals de sessió com cookies permanents. Les cookies de sessió emmagatzemen dades únicament mentre l\'usuari accedeix al web i les cookies permanents emmagatzemen les dades en el terminal perquè siguin accedits i utilitzats en més d\'una sessió.<br><br>
    Tipus de cookies<br>
    Segons la finalitat per a la qual es tractin les dades obtingudes a través de les cookies, el web pot utilitzar:<br><br>
    Cookies tècniques<br>
    Són aquelles que permeten a l\'usuari la navegació a través de la pàgina web o aplicació i la utilització de les diferents opcions o serveis que en ella existeixen. Per exemple, controlar el trànsit i la comunicació de dades, identificar la sessió, accedir a les parts web d\'accés restringit, realitzar la sol·licitud d\'inscripció o participació en un esdeveniment i utilitzar elements de seguretat durant la navegació.<br><br>
    Cookies de personalització<br>
    Són aquelles que permeten a l\'usuari accedir al servei amb algunes característiques de caràcter general predefinides en el seu terminal o que el propi usuari defineixi . Per exemple, l\'idioma, el tipus de navegador a través del qual accedeix al servei, el disseny de continguts seleccionat, geolocalització del terminal i la configuració regional des d\'on s\'accedeix al servei.<br><br>
    Cookies publicitàries<br>
    Són aquelles que permeten la gestió eficaç dels espais publicitaris que s\'han inclòs a la pàgina web o aplicació des de la qual es presta el servei. Permeten adequar el contingut de la publicitat perquè aquesta sigui rellevant per a l\'usuari i per evitar mostrar anuncis que l\'usuari ja hagi vist.<br><br>
    Cookies d\'anàlisi estadístic<br>
    Són aquelles que permeten fer el seguiment i anàlisi del comportament dels usuaris en els llocs web. La informació recollida mitjançant aquest tipus de cookies s\'utilitza en la mesura de l\'activitat dels llocs web, aplicació o plataforma i per a l\'elaboració de perfils de navegació dels usuaris d\'aquests llocs, per tal d\'introduir millores en el servei en funció de les dades d\'ús que fan els usuaris.<br><br>
    Cookies de tercers<br>
    En algunes pàgines web poden existir cookies de tercers que permeten gestionar i millorar els serveis oferts . Com per exemple, serveis estadístics de Google Analytics<br><br>
    Revocació i eliminació de galetes<br>
    Pots permetre, bloquejar o eliminar les cookies instal·lades en el teu equip mitjançant la configuració de les opcions del navegador instal·lat al teu ordinador. En cas que no permetis la instal·lació de cookies en el teu navegador és possible que no puguis accedir a alguna de les seccions de la nostra web.<br><br>');

    define("do_1","El Pla de Bages és una zona privilegiada, situada enmig de formacions muntanyoses mítiques com Montserrat i la Serra de Castelltallat, el Parc Natural de Sant Llorenç del Munt i l'Obac o el massís de Montcau. Amb importants centres turístico-culturals com el monestir de Sant Benet de Bages, les mines de sal de Cardona, la cova de Sant Ignasi a Manresa o el recorregut de la Sèquia, la comarca presenta una atractiva oferta en constant expansió, tant a nivell lúdic i cultural com gastronòmic.");

    define("do_2","Una de les peculiaritats del Bages són les tines i les barraques de vinya, construccions de pedra seca que es van fer necessàries per als pagesos davant del treball continuat al camp, per guardar l'utillatge agrícola o bé per protegir-se de les inclemències del temps. Coincidint amb");

    define("do_2_","la notable expansió del conreu de vinya, es van aixecar moltes d'aquestes barraques, de les què en resten al voltat de 4000, la majoria molt ben conservades.");

    define("do_3","Dins d'un clima continental mediterrani de mitja muntanya, el Bages disposa de les condicions idònies per al conreu vinícola: un excepcional microclima, una pluviositat escassa i una forta oscil·lació tèrmica, a més d'un sòl franc argilós i calcari.");

    define("do_4","Els seus vins queden impregnats amb notes balsàmiques d'espígol, farigola i romaní. Aquestes plantes aromàtiques que poblen els boscos de pins, roures i alzines envolten les vinyes.");

    define("do_5","Aquestes peculiaritats fan del Bages una zona òptima per a l'obtenció de vins de gran identitat.");

    define("do_6","Tots els cellers del Bages tenen vinyes pròpies, així els vins del Bages, ofereixen diferents variades expressions de la nostra terra i la gent que la treballa.");

    define("do_7","La varietat de raïm autòctona de la comarca és la Picapoll, que dóna un vi blanc afruitat, d'aroma fresc, d'esplèndida textura i personalitat. Aquest raïm ha esdevingut símbol d'identitat del Bages ja que és l'únic lloc d'Espanya on es conrea aquesta preuada varietat. Pel què fa als raïms negres, també s'estan recuperant les varietats autòctones Picapoll negre, Sumoll i Mandó, que ajuden a consolidar el particular perfil de la zona.");

    define("do_8","Les altres varietats que s'hi conreen són: Macabeu, Perellada, Chardonnay, Sauvignon blanc i Gewürztraminer per a blancs, i Garnatxa, Ull de Llebre, Merlot, Cabernet Sauvignon, Cabernet franc i Syrah per a negres.");

    define("do_9","Les característiques del sòl i el clima del Bages, donen com a fruit uns vins amb molta frescor, d'amable concentració i amb bona capacitat per envellir.");

    define("chardonnay","Raïm primerenc, de gra esfèric petit i apinyat. Don vins de bona acidesa però sobretot de gran estructura en boca i molta aptitud per a l'envelliment. Destaquen les aromes de fruita fresca com la poma verda i notes de pinya americana.");

    define("sauvignonblanc","Raïm blanc de pell delicada. Elaborat en condicions de màxima preservació de l'oxígen revela gran potència d'aromes tropicals, maracujà i vegetals elegants com el boix. En les zones més fredes les notes minerals revelen els millors Sauvignon Blanc.");

    define("gewurztraminer","Raïm de pell rosada tot i que se n'obté vi blanc. El mateix raïm ja revela el seu gran potencial de notes florals, rosa. Vins de mitjana estructura però de gran intensitat aromàtica en la que es troben la rosa i la fruita molt madura.");

    define("picapoll","Varietat tardana, de gra ovalat i pell gruixuda, que el protegeix en la seva llarga maduració. Dona vins d'acidesa mitjana que els fa molt amables i potencia la seva sensació de volum. Aromàticament revela notes cítriques, com l'aranja, herba aromàtica espígol i en els anys més frescos les notes florals,(flor blanca com el gessamí.)");

    define("macabeu","Varietat de cicle mitjà. Aporta elegància als cupatges de la zona. Es caracteritza per les notes de fruita blanca i un aportació mitjana de grau i acidesa.");

    define("ulldellebre","Varietat negre de gra gros, tendència a ser productiu de jove i va equilibrant a mida que envelleix, reduint la producció i millorant la seva maduració. A la zona, aporta lleugeresa aromes florals, regalèssia i fruita vermella, que donen frescor a vins de mitja criança.");

    define("merlot","Fora de Bordeus, les zones fredes, com el Bages és on aquesta varietat de cicle curt va a madurar ja amb els primers freds. Això li aporta molta elegància en comparació amb zones més calentes. Sense caure en la verdor dels tanins ni en la sobremaduració aromàtica. En el terme mig hi ha les grans zones de merlots frescos, amb notes de grosella i fons de cacau.");

    define("cabernetfranc","De maduració lleugerament més avançada que el Cabernet Sauvignon, tot i així varietat tardana. Tendència natural a equilibrar la producció pel deficient quallat del raïm, que redueix la càrrega de forma natural. Dóna vins de gran estructura i color, destacant les notes de tofee sobre fruites del bosc.");

    define("cabernetsauvignon","Possiblement el raïm millor adaptat a tot el món, degut al seu cicle llarg. Les llargues maduracions a la tardor en zona freda (veremes a finals d'octubre a la nostra zona) respecten l'acidesa i el perfil varietal (cirera picota, fruita negra) permetent eliminar les seves aromes vegetals (pebrot verd) i donant cremositat als tanins que li aporten una gran estructura.");

    define("syrah","Raïm de gra gros però de gran pigmentació. Tot i tenir la pell molt delicada, les llargues maduracions fins a l'octubre respecten les característiques de Violeta i Olivada. Aquestes aromes junt amb la gran estructura i alhora suavitat en boca la fan una varietat molt agraïda pels cupatge.");

    define("garnatxanegra","Varietat de cicle mitjà, de gra gros i generalment de maduració amb poc color. Només les vinyes molt velles arriben concentrar en terrenys ben drenats i assolellats. De gran valor per aportar sensacions de dolçor i molta frescor aromàtica (gerds i fins i tot maduixa). Maduració plena amb alt grau alcoholic i bona relació d'acidesa.");

    define("sumoll","La varietat autòctona negra més conservada a la zona. De cicle mitjà, raïm gros i producció mitjana elevada. Dona negres de poc color però molta frescor i estructura tànica, amb un estil de vins continentals (és a dir, més semblants a Pinots Noirs i Nebiolos que a varietats bordeleses). De tanins de difícil maduració, per això de sempre s'havia considerat una bona varietat per a la obtenció de rosats.");
    
    define("egastronomic","Mira, olora i tasta els productes de la nostra comarca");

    define("ecultural","Descobreix la cultura que s'amaga en els pobles i indrets del Bages");

    define("eaventura","Viu l'enoturisme de la forma més divertida");

    define("ehistoria","Per entendre l'origen del nostre paisatge i dels nostres vins");

    define("ecellers","Coneix els protagonistes d'aquesta història");

    define("erutes","Explora el Bages a través dels seus camins");

    define("epatrimoni","El llegat de segles de treball a la terra");

    define("eperregalar","Comparteix un trosset del Bages");

    define("eestada","Queda't i gaudeix dels millors moments");

    define("patrimoni_1_0","Les tines són construccions utilitzades per produir el vi, i que al llarg de la història han anat utilitzant-se en diferents formes i materials. Les tines de pedra són l’evolució de la tina de fusta i el follador, on el follador servia per aixafar el raïm i la tina era on es fermentava el most.");

    define("patrimoni_1_1","És a finals del segle XVI i sobretot del segle XVII quan la construcció de la tina de pedra queda estesa arreu de la comarca. Un sol recipient feia les dues funcions, a la part superior de la tina s’hi col·locaven unes fustes anomenades posts on s’hi abocava el raïm i es trepitjava, i ben aixafat s’apartava una de les fustes i es feia caure tot cap a l’interior de la tina. Un cop fermentat, s’extreia per una sortida a la part inferior anomenada la boixa.");

    define("patrimoni_1_2","Les tines normalment es construïen als masos, i durant la verema servien per elaborar el vi de tota la terra pertanyent al mas. Al Bages, degut a la concessió de porcions de terres als “rabassaires”, nom que ve donat pel tipus de contracte “a rabassa morta”, i a l’explotació de vinyes cada vegada més allunyades dels masos, van aparèixer les tines a peu de vinya. Tenien la peculiaritat que eren fetes a peu del tros, aprofitant normalment un desnivell del terreny on fos fàcil abocar el raïm per la part superior i buidar-la per la part inferior, cosa que permetia reduir els costos del transport de raïm. D’aquesta manera només s’havia de transportar el vi o vendre’l a peu de tina als traginers.");

    define("patrimoni_1_3","Podem trobar dues tipologies de construcció, la tina solitària i el conjunt de tines. La primera fa referència clarament a la tina d’un rabassaire que menava una vinya en aquell indret. La segona era una tipologia de construccions col·lectives, on cada tina era propietat d’un rabassaire, però que es construïren conjuntament. ");

    define("patrimoni_1_4","Desconeixem si es feien juntes per donar més consistència a l’edificació o per abaratir costos en la seva construcció, ja que no s’ha trobat cap documentació que ho especifiqui, però la realitat és que aquests conjunts han esdevingut un patrimoni de valor incalculable tant per la història que expliquen com per la seva imponent bellesa.");

    define("patrimoni_1_q","La boixa gairebé sempre estava protegida per una barraca que es tancava amb pany i clau, però això no assegurava que la feina de tot un any no es veiés afectada per algun robatori");

    define("patrimoni_2_0","Podríem afirmar que són el primer indici conegut de vinificació a peu de vinya, comparable a les “tines enmig de les vinyes” de pedra seca.");

    define("patrimoni_2_1","L’ús dels cups s’inicia al segle XIV i s’estendrà fins al segle XVII. Es tracta d’uns grans forats excavats a la roca que servien de recipients per vinificar, sempre construïts en una roca de manera que una de les cares quedés lliure. Normalment se’n construïen dos de junts, un de dimensions més reduïdes anomenat follador, on es xafava el raïm, i just al costat un altre de més gran on el most, juntament amb la brisa i la rapa, fermentava. Per extreure el vi, a la part baixa del cup de la paret lliure s’hi ubicava la boixa, un forat més o menys circular que comunicava l’interior amb l’exterior. Aquest dos elements formarien un conjunt per poder vinificar. La capacitat d’aquests cups anava en funció del bloc de pedra en què es construïa, trobant cups de fins a 10.000 litres de capacitat.");

    define("patrimoni_2_2","En algun d’aquest conjunts també hi podem trobar un gran forat, normalment en forma de creu, on anava encaixada la premsa de fusta d’eix vertical que permetia acabar tot el procés en un sol lloc.");

    define("patrimoni_2_q","Al Bages, aquestes construccions es localitzen principalment al nord de la comarca i són típics de tot l’arc mediterrani");

    define("patrimoni_3_0","Barraques de vinya és el nom que reben popularment al Bages les construccions fetes amb la tècnica de la pedra seca i que servien per aixopluc, per guardar-hi eines o fins hi tot per passar-hi alguna nit. La tècnica constructiva requeria de certs coneixements, existint fins i tot la figura del barracaire, que era la persona que sabia de la tècnica i que es llogava per construir-ne.");

    define("patrimoni_3_1","Primer de tot calia buscar el lloc més adient i seguidament calia decidir, en funció de la pedra disponible, com seria la seva forma (circular, rectangular, simple o doble). Mentre s’anava configurant l’estructura s’havia de preveure l’obertura principal, espitlleres, amagatalls pels aliments o xemeneia en cas que hi hagués lloc per fer-hi foc.");

    define("patrimoni_3_2","La teulada, construïda normalment amb la tècnica de la volta cònica, consistia en una superposició de filades concèntriques col·locades de manera que anaven tancant l’espai fins acabar amb un llosa que tapava l’última obertura. Finalment es cobria tot de pedruscall i terra d’argila.");

    define("patrimoni_3_3","Se sap que algunes d’aquestes construccions són força antigues, com una barraca al terme de Rajadell amb la inscripció 1716 a la seva llinda, però no és fins al segle XVIII i sobretot al segle XIX, coincidint amb l’expansió de la vinya a la comarca, que se’n construïren la majoria. Ningú sap del cert quantes n’hi ha, ja que l’abandonament de les antigues vinyes i el creixement del bosc les han deixat moltes vegades amagades i oblidades, però el cert és que estan plenament integrades en el nostre paisatge.");

    define("patrimoni_3_q","Al Bages, sobre la terra que cobria la teulada era habitual plantar-hi lliris, evitant així l’erosió de l’aigua.");

    define("patrimoni_4_0","Gràcies als marges i a les parets de pedra seca es van poder conrear terres que d’una altra manera hagués estat impossible, ja que permetien l’anivellament del terreny, la conducció d’aigües pluvials mitjançant rases o la delimitació de les propietats.");

    define("patrimoni_4_1","La tipologia d’aquests marges depenia de la disponibilitat de la pedra i de com era el terreny, d’aquí que podem veure marges de poc més de 50 cm, fins a murs de varis metres d’alçada.");

    define("patrimoni_4_2","A vegades, la inclinació del terreny era tant important que la confecció de feixes amb paret de pedra seca feia que entre una i l’altre només hi capigués una passada de ceps. “Hi havia llocs que era tant dret que cavaven els ceps drets” són explicacions dels pagesos de la zona que recorden com era la fenia de la vinya en temps passats. ");

    define("patrimoni_4_3","En definitiva, però, les parets i els marges avui han adquirit un valor històric i paisatgístic notable. Més enllà del relat que ens expliquen sobre boscos que no ho eren, sobre vinyes en feixes remotes i inaccessibles, o sobre conreus oblidats, formen part del nostre entorn, moltes vegades, amb una gran bellesa.");

    define("patrimoni_4_q","Són elements tant integrats en els nostres camps, boscos i muntanyes, que sovint no hi parem l’atenció que es mereixen");

    define("patrimoni_5_0","Els pous de glaç, o “poues”, com es coneixen al moianès, són excavacions obrades generalment amb pedra seca, que s’utilitzaven per poder proveïr de gel o neu la població durant tot l’any.");
    
    define("patrimoni_5_1","A l’hivern, es canalitzava l’aigua del riu en basses per tal de que aquesta es gelés, i quan la capa de gel tenia el gruix suficient, es col·locaven els blocs a dins del pou.  Entre filada i filada de blocs de gel s’hi col·locava palla, boll (pellofa de blat) o branques per evitar que amb el petit desglaç que hi pogués haver s’enganxessin l’un amb l’altre. I així fins que el pou era ple.");

    define("patrimoni_5_2","Durant l’estiu, aquest glaç emmagatzemat es venia a les ciutats i poblacions properes, convertint aquesta professió en un negoci important a les poblacions rurals.");

    define("patrimoni_5_3","El Bages, amb més 25 pous documentats, disposa d’uns quants pous intactes i en molt bon estat de conservació. ");

    define("patrimoni_5_q","Les condicions meteorològiques actuals farien impossible la seva reutilització");

    define("rutes_1_0","Emplaçades en la seva gran majoria entre els pobles de Rocafort i el Pont de Vilomara, a les tines de la vall del Flequer hi descobrireu aquest valuós patrimoni rural.");

    define("rutes_1_1","Les tines, situades al llarg de la riba del torrent de l'Escudelleta, estan disposades en grups on els pagesos de la zona hi abocaven el raïm per xafar-lo i un cop xafat dipositar-lo posteriorment en tines situades a un nivell inferior per a la seva fermentació. Aquestes estructures són úniques a Catalunya i us sorprendran per la seva arquitectura i estat de conservació. ");

    define("rutes_2","");

    define("rutes_3_0","L'Anella Verda és el conjunt d'espais lliures al voltant de la ciutat que pels seus valors socials, ambientals, paisastgístics i productius agraris s'han de protegir, connectar i potenciar.");
    
    define("rutes_3_1","Es concep com un espai lliure continu que envolta Manresa, idoni per acollir activitats de lleure, educatives, esportives i culturals d'acord amb les diferents característiques que li són pròpies; capaç de continuar essent un espai lliure i productiu, apte per generar riquesa; capaç de mantenir les funcions de connector biològic i natural amb els espais naturals externs; i capaç de conservar el patrimoni natural que conté.");

    define("rutes_3_2","El projecte d'Anella Verda de Manresa neix amb la finalitat de preservar, potenciar i difondre, des d'una vessant participativa i activa, els valors patrimonials, paisatgístics, ambientals i socials del rodal de Manresa, entès com un espai més de la ciutat, que permeti posar en valor els espais lliures que envolten la nostra població i que ens permeti créixer i desenvolupar-nos de forma sostenible i equilibrada.");

    define("rutes_4_0","La Sèquia és un canal medieval que va ser construït el segle XIV per portar l’aigua del riu Llobregat des de Balsareny fins a Manresa.");

    define("rutes_4_1","Té un recorregut de 26 quilòmetres i va ser projectat per l’enginyer Guillem Catà. Considerat com una de les principals obres d’enginyeria hidràulica de l’època medieval, el canal tan sols té un desnivell de 10 metres al llarg del seu recorregut, un fet insòlit si es té en compte els mitjans rudimentaris de l’època en què va ser construït.");

    define("rutes_4_2","Per a fer-ho possible es van haver de construir mines i una trentena d’aqüeductes que salven els desnivells del terreny per on passa el canal. Alguns d’aquests aqüeductes, com el de Conangle, el Vilar o el de Santa Maria, són considerats avui veritables monuments i, més, si es té en compte, l’òptim estat de conservació que mantenen a l’actualitat.");

    define("rutes_4_3","Però el més rellevant de la Sèquia és que, sis segles després de la seva construcció, continua en ple funcionament i subministra l’aigua necessària per abastar la ciutat de Manresa i diversos pobles de la comarca del Bages.");

    define("rutes_5","");

    define("rutes_6","");

    define("rutes_7_0","Malgrat que per diferents circumstàncies Catalunya no gaudeixi d'un únic itinerari com pot ser el Camí Francès, les numeroses esglésies i poblacions deidicades demostren el culte a Sant Jaume històric dels catalans.");

    define("rutes_7_1","Al Bages, la ruta consolidada forma part de l'itinerari que va de Figueres a Montserrat, i està formada pels trams que connecten l'Estany, Artés, Manresa i Montserrat.");

    define("rutes_8_0","Els 3 monts és l’itinerari senderista que uneix els parcs naturals del Montseny, Sant Llorenç del Munt i Montserrat a través d’una ruta senyalitzada, dividida en 6 etapes.");

    define("rutes_8_1","Al llarg de 106 Km. descobrirem en tranquil·la progressió les formes canviants de la natura: es mostrarà silenciosa i eterna al Montseny, abrupta i salvatge a Sant Llorenç i l’Obac, màgica i capriciosa vora els relleus montserratins.");

    define("rutes_8_2","Els 3 monts posa al teu abast el camí per enllaçar un seguit d’experiències que faran de la teva caminada una aventura inoblidable.");

    define("rutes_9","");

    define("rutes_10_0","Recrea la ruta que Ignasi de Loiola, sent cavaller, va recórrer l’any 1522 des de Loiola fins a Manresa.");

    define("rutes_10_1","Aquest itinerari ofereix l’oportunitat de viure una experiència de peregrinació, seguint el procés espiritual que va fer Ignasi.");

    define("rutes_10_2","El camí comença a la casa on va néixer a Azpeitia (Guipúscoa) i acaba a la Cova de Sant Ignasi a Manresa.");

    define("rutes_11_0","Els Camins del Bisbe i  Abat Oliba és una ruta d’art romànic que uneix la comarca del Bages, d’Osona i del Ripollès utilitzant com a fil conductor el Bisbe i Abat Oliba.");

    define("rutes_11_1","De totes les tendències arquitectòniques i artístiques que han existit fins al dia d’avui, la més estesa és sense cap mena de dubte el romànic. Les comarques del Bages, d’Osona, i el Ripollès en són la mostra més fidedigne d’aquest bast patrimoni. Qualsevol dels pobles i ciutats que formen part de les nostres comarques té o ha tingut alguna església o edifici construït amb aquest estil. L’art romànic ens uneix i dóna sentit a aquest projecte.");

    define("rutes_11_2","L’art romànic es presenta, doncs, com un element integrador de la Catalunya Central, i constitueix l’argument idoni per fomentar el reequilibri territorial i per donar a conèixer el paisatge, la gastronomia, la tradició i tota l’oferta turística complementària de la Catalunya interior.");

    define("visites_1_0","Al bell mig de Montserrat, aquest monestir té els origens històrics a l'ermita de Santa Maria, que l'any 888 el comte Guifré el Pelós dóna al monestir de Ripoll.");

    define("visites_1_1","L'any 1025, Oliba, abat de Ripoll i bisbe de Vic, funda un nou monestir al costat de l'ermita de Santa Maria, i comença a rebre pelegrins i visitants. El 1409, el monestir de Montserrat es converteix en abadia independent, i durant quasi 400 anys de profundes reformes, creiexement i resplendor, Montserrat forma part de la Congregació de Valladolid.");

    define("visites_1_2","Durant els segles XVII-XVIII, el monestir de Montserrat es converteix en un centre cultural de primer ordre. Els segles XIX i XX, amb la Guerra del Francès i la Guerra Civil espanyola, el monestir passa etapes de destrucció i abandonament, refent-se sempre amb esdeveniments com la proclamació de la Mare de Déu com a Patrona de Catalunya (1881).");

    define("visites_2_0","Fa mil anys, uns monjos es van instal·lar en aquest indret, on el Llobregat dibuixa un ample meandre. Van bastir-hi un monestir romànic, amb una gran església i un suggerent claustre. I al llarg dels anys van treballar per fer-lo créixer amb nous edificis, fins a completar el recinte actual.
");

    define("visites_2_1","L’any 1907, la mare del pintor Ramon Casas, després d’haver construït la fàbrica tèxtil al costat del riu, va adquirir el monestir i el va convertir en la seva mansió. Antigues cel·les es van transformar en sumptuosos salons, emplenats amb la col·lecció artística del pintor.");

    define("visites_2_2","Ara, la història impregna tots els racons de Món Sant Benet. Un marc per a reunions i celebracions inèdit a Catalunya. Un marc on gaudir d’una experiència única de la història i l'art.");

    define("visites_3_0","A Cardona, la situació geogràfica del castell respon a la necessitat de defensar l’accés al salí i a la visió privilegiada de les valls del riu Cardener. Entre el s.XI i fins al s.XV, va ser el nucli residencial dels senyors de Cardona: els “rics senyors de la sal”, emparentats amb les principals cases reials europees, i tan influents que el duc de Cardona era conegut com “el rei sense Corona”.");

    define("visites_3_1","El conjunt monumental del castell és Monument Nacional de l’Estat des del 1949, i la Col.legiata de Sant Vicenç, exemple de l’art llombard català, ho és des del 1931. En destaquen la Torre de la Minyona, el Pati Ducal, els seus baluards de defensa o les seves vistes sobre la Vall Salina.");
    
    define("visites_4_0","El castell de Balsareny és sens dubte el monument més representatiu i carismàtic de la població i un dels més coneguts de la comarca. És ben visible no solament a causa de la seva situació, sinó també a causa de la seva mida i del seu bon estat de conservació.");

    define("visites_4_1","Present des dels orígens en els esdeveniments de la història del poble, l'actual fesomia de l'edificació correspon al més pur estil gòtic civil català i data del segle XIV.");

    define("visites_4_2","Es tracta d'un castell palau gòtic organitzat a partir d'un pati central. A causa d'haver estat ben planificat i edificat, d'acord amb el pla previ i en una sola campanya constructiva, és un dels pocs castells regulars i homogenis de la Catalunya central.");

    define("visites_5_0","La Vall Salina de Cardona, portadora de la preuada riquesa de la sal que s’explota des del neolític, i de la potassa descoberta per l’enginyer Emili Viader a la primeria del 1900, és la raó de ser de Cardona. Al seu voltant es va inaugurar, el 2003, el Parc Cultural de la Muntanya de Sal per divulgar el seu valor i projectar la Muntanya de Sal “una gran muntanya de sal pura que creix a mesura que se’n va extraient” (Aulus Gel·li, citant Cató, s.II d.c.).");

    define("visites_5_1","La Vall Salina de Cardona és una depressió del terreny amb forma d’el·lipsi allargassada amb una extensió de terreny de 1.800 m de llargària per 600 d’amplada i una superfície de 100 ha, amb unes característiques naturals que l’han fet mereixedora de ser inclosa dins el Pla d’Espais d’Interès Natural de Catalunya. Els afloraments de sal es localitzen dins aquesta depressió, i per això fou coneguda antigament com el Salí, i actualment ho és com a Vall Salina.");

    define("visites_6_0","El carrer del Balç, que formava part del nucli de la ciutat medieval sorgit a l’entorn del mercat, a la plaça Major, és un magnífic exemple de l’urbanisme medieval. De traçat estret i sinuós, el carrer s’adapta al perfil d’una balcera, amb diferents nivells esglaonats, i discorre sota els porxos que s’aixequen entre casa i casa per tal d’aprofitar l’espai escàs que hi havia a l’interior de la ciutat murallada.");

    define("visites_6_1","Aquest carrer conserva encara l’essència d’un ambient medieval.");

    define("visites_6_2","Emplaçat a les dependències d’un antic casal, el centre d’interpretació ofereix un muntatge amb recursos multimèdia que posa en valor un conjunt patrimonial únic i, al mateix temps, permet descobrir com era la Manresa del segle XIV: el món dels gremis, les oligarquies i les famílies nobles de la ciutat, com era la vida quotidiana en un carrer medieval i els factors que van fer possible la construcció de la Sèquia. Una història narrada i personalitzada en la figura del rei Pere III el Cerimoniós, el gran monarca forjador de les principals institucions de l’estat català.");

    define("visites_7_0","La Col·legiata Basílica de Santa Maria de Manresa (la Seu) és un dels exemples més representatius del gòtic català i símbol i icona de la capital del Bages. Situada al cim del Puigcardener, contempla la ciutat a la seva falda des de la riba esquerra del riu Cardener, al fons del balç. La Seu és, sens dubte, el principal referent històric, identitari i espiritual per a tots els manresans. Els privilegis concedits pel Papa Lleó XIII el 1886 van convertir el temple en basílica.");

    define("visites_7_1","Malgrat ser anomenada “Seu”, el nostre monument no ha estat mai una seu catedralícia. Hi ha documentació del segle IX on es cita que el bisbe Gotmar és bisbe osonenc i de Manresa. La tradició, des de la seva construcció, ha fet que aquest fos el seu nom popular atesa la seva dimensió de catedral, l’existència d’un capítol de canonges (d’aquí el nom de col·legiata) i la solemnitat i importància que el poble sempre li ha donat.");

    define("visites_8_0","El pas de Sant Ignasi per Manresa, l’experiència que hi visqué i el relleu que va tenir en la biografia del Sant i la història de la Companyia de Jesús han fet de Manresa i de la Cova de Sant Ignasi un lloc d’interès per a molts visitants. La Cova de Sant Ignasi disposa de diversos serveis per acollir tots aquests visitants, tant si realitzen un pelegrinatge de tipus espiritual, com si desitgen conèixer el patrimoni històric, cultural i artístic de la Cova.");

    define("visites_8_1","");

    define("visites_9_0","Les Coves del Toll són un espai de gran interès, tant per la seva formació geològica com per les restes arqueològiques i paleontològiques que s’hi ha trobat i que constitueixen un dels referents més importants de la Prehistòria, no només del Moianès, sinó de tota Catalunya.");

    define("visites_9_1","El complex l’integren un conjunt de cavernes, entre les quals destaca la Cova del Toll, amb un recorregut visitable de 184 metres i un curs fluvial al bell mig que, amb els anys, ha anat perfilant els seus murs calcaris, fins aconseguir unes formes de gran bellesa.");

    define("visites_9_2","Des del seu descobriment l’any 1948, i encara ara, s’hi porten a terme campanyes d’excavació arqueològica que han posat de manifest un important llegat antropològic i paleontològic. S’hi han trobat nombroses restes de fauna quaternària i indicis de presència humana des del paleolític mitjà.");

    define("visites_10_0","Emplaçat al monumental edifici dels Dipòsits Vells, que recollien i emmagatzemaven l’aigua de la Sèquia. Construïts entre 1861 i 1865 pel mestre d'obres Marià Potó van servir per proveir la primera xarxa de distribució d'aigua de la ciutat.");

    define("visites_10_1","El contingut de les exposicions permanents del museu explica dos fets fonamentals de la història econòmica de Manresa:");

    define("visites_10_2","La Sèquia com a proveïment d'aigua capaç de fer créixer la producció agrícola i la ciutat des de l'edat mitjana, amb un muntatge expositiu que dóna a conèixer la gran obra de la Sèquia des d'una perspectiva històrica, com a gran obra de l'enginyeria medieval, i on es posa de manifest els grans avantatges que va comportar aquesta magna obra per Manresa i el Pla de Bages.");

    define("visites_10_3","I per altra, el fenomen de la industrialització exemplificat en un sector molt propi de la ciutat, el món de la Cinteria, especialment dels obradors vetaires, que dóna una personalitat a la indústria manresana i la situa, encara avui dia, com a centre especialitzat dins del mercat espanyol i internacional.");

    define("visites_11_0","Dues majestuoses torres s’enlairen en els camps del pla de Bages al poble de Fals, terme municipal de Fonollosa. Les torres, l’antic castell i l’església de Sant Vicenç fan d’aquest conjunt un dels més espectaculars del Bages.");

    define("visites_11_1","Situades a l’antic camí ral on traginers i comerciants passaven per anar a Barcelona, tenien la funció de ser la porta d’accés al comptat de Cardona, on després de mil anys d’història encara ara controlen aquest pas. Durant les festes de Nadal s'hi celebra un gran pessebre vivent, el Pessebre Vivent del Bages, on tot el poble hi participa.");

    define("visites_12_0","També coneguda com a torre dels Moros, és una torre de defensa de planta circular de 12 metres d’altura, que constitueix l’únic vestigi d’una construcció defensiva del segle XI.");

    define("visites_12_1","Situada al terme municipal de Castellnou de Bages, des de la seva situació manté contacte visual amb el Castell de Balsareny, i té unes vistes panoràmiques que van des dels Pirineus fins a Montserrat.
Una antiga tradició diu que conserva enterrada una pell de cabrit plena de monedes d’or i que hi ha comunicació física amb el Castell de Balsareny. També és coneguda com un dels indrets freqüentats pel Maquis a la Catalunya central.");

    define("visites_13_0","El Museu Comarcal de Manresa és una institució al servei de la societat que s'ocupa de conservar estudiar i difondre el patrimoni històric i artístic de Manresa i el Bages.");

    define("visites_13_1","Amb el seu treball a l'entorn del patrimoni cultural i la creació artística aporta eines per a millorar-ne la gestió i el seu coneixement bo i afavorint l'apropiació crítica de la història i el foment de l'art.");

    define("visites_14_0","El Parc Natural de Sant Llorenç del Munt i l'Obac es troba a la Serralada prelitoral catalana, a cavall de les comarques del Bages i del Vallès Occidental, entre el riu Llobregat, a l'Oest, i el riu Ripoll, a l'Est.");

    define("visites_14_1","El parc natural està conformat per les dues serralades que li donen nom i que s'uneixen al coll d'Estenalles. Els cims més alts són la Mola (1.104 m), en la qual s'aixeca el monestir romànic de Sant Llorenç, que dóna nom al massís, i el Montcau (1.057 m).");

    define("tos_1",'IDENTITAT DEL TITULAR DEL WEB La Brocada Serveis S.L. és una entitat mercantil amb domicili a Manresa, i C.I.F. Nº B-66405887 i telèfon 686108724.
    
    La utilització d\'aquesta pàgina web així com les dels subdominis i/o directoris (d\'ara endavant conjuntament denominats el "Lloc") queda sotmesa tant a les presents Condicions Generals d\'Ús, com a les condicions particulars pròpies (d\'ara endavant, les "Condicions particulars") que, segons els casos, puguin regir la utilització de determinats serveis oferts en la mateixa. Per tant, amb anterioritat a la utilització d\'aquests serveis, l\'Usuari també ha de llegir atentament tant aquest Avís Legal com, si és el cas, les corresponents Condicions Particulars. Així mateix, la utilització del Lloc es troba sotmesa igualment a tots els avisos, reglaments d\'ús i instruccions, que posats en coneixement de l\'Usuari per La Brocada Serveis S.L. substitueixin, completin i/o modifiqui les presents Condicions Generals d\'Ús. Pel sol ús del Lloc o de qualsevol dels llocs inclosos en la pàgina web l\'usuari manifesta que accepta sense reserves de les presents Condicions Generals d\'Ús.<br><br>

Per això, si les consideracions detallades en aquest Avís Legal no són de la seva conformitat, preguem no faci ús del lloc, ja que qualsevol ús que faci del mateix o dels serveis i continguts en ell implicarà l\'acceptació dels termes legals recollits en aquest text.<br><br>

La Brocada Serveis S.L. es reserva el dret a realitzar canvis en el Lloc sense previ avís, amb l\'objecte d\'actualitzar, corregir, modificar, afegir o eliminar els continguts del lloc o del seu disseny. Els continguts i serveis del Lloc s\'actualitzen periòdicament. A causa de que l\'actualització de la informació no és immediata, li suggerim que comprovi sempre la vigència i exactitud de la informació, serveis i continguts recollits en el Lloc. Així mateix, les condicions i termes que es recullen en el present Avís Legal poden variar, de manera que us convidem a revisar aquests termes quan visiti de nou el Lloc.<br><br>

CONDICIÓ D\'USUARI La utilització del Lloc atribueix la condició d\'usuari del lloc (d\'ara endavant, "l\'Usuari") i implica l\'acceptació plena i sense reserves de totes i cadascuna de les disposicions incloses tant en el present Avís Legal com en la Política de Privacitat.<br><br>

RESPONSABILITATS DE L\'USUARI L\'Usuari es compromet a utilitzar els Serveis del Lloc d\'acord amb els termes expressats en el present Avís Legal, sent responsable del seu ús correcte. Sense perjudici del que s\'exposa a continuació, l\'usuari s\'obliga a no utilitzar el Lloc per a la prestació de serveis, la realització d\'activitats publicitàries o d\'explotació comercial.<br><br>

VERACITAT DE LES DADES PROPORCIONATS PER L\'USUARI Alguns dels serveis oferts requereixen el previ registre de l\'usuari, per a la utilització s\'haurà de donar d\'alta com a usuari de la web de La Brocada Serveis S.L., i per a això llegir i acceptar expressament, en el moment anterior a efectuar la seva alta en el servei, les condicions de registre i la Política de Privacitat.
Tota la informació que faciliti l\'Usuari haurà de ser veraç. A aquests efectes, l\'Usuari garanteix l\'autenticitat de totes aquelles dades que comuniqui com a conseqüència de l\'emplenament dels formularis necessaris per al registre i accés a determinats serveis. Serà així mateix responsabilitat seva mantenir tota la informació facilitada a la Brocada Serveis S.L. permanentment actualitzada de manera que respongui, en cada moment, a la situació real de l\'Usuari. En tot cas l\'Usuari serà l\'únic responsable de les manifestacions falses o inexactes que realitzi i dels perjudicis que causi a la Brocada Serveis S.L. oa tercers per la informació que faciliti.<br><br>

Tot aquell que enviï comunicacions a aquest lloc web o als seus propietaris serà responsable del contingut d\'aquestes, també pel que fa a la seva veracitat i precisió, no fent-se, per tant, responsable L\'Brocada Serveis S.L. de la informació i continguts introduïts per tercers. <b> No obstant això i en compliment del que disposa l\'art. 11 i 16 </b> de la Llei 34/2002, de Serveis de la Societat de la Informació i del Comerç Electrònic, La Brocada Serveis S.L. es posa a disposició de tots els usuaris, autoritats i forces de seguretat per col·laborar de forma activa en la retirada o si escau bloqueig de tots aquells continguts que puguin afectar o contravenir la legislació nacional, o internacional, drets de tercers o la moral i l\'ordre públic. En cas que l\'usuari consideri que existeix en el lloc web algun contingut que pogués ser susceptible d\'aquesta classificació, es prega ho faci saber de forma immediata al propietari del lloc web.<br><br>

ÚS DELS CONTINGUTS DEL LLOC L\'usuari s\'obliga a no utilitzar el Lloc ni els serveis oferts en oa través del mateix per a la realització d\'activitats contràries a les lleis, a la moral, a l\'ordre públic, lesives dels drets i interessos de tercers o que de qualsevol altra manera puguin danyar, inutilitzar, sobrecarregar, deteriorar o impedir la normal utilització del Lloc.<br><br>

L\'Usuari que actuï contra la imatge, bon nom o reputació de la Brocada Serveis S.L., així com qui utilitzi il·lícita o fraudulentament els dissenys, logotips o continguts del Lloc i/o violi en qualsevol forma dels drets de propietat intel·lectual i industrial del Lloc o dels continguts i serveis de la mateixa, serà responsable davant de La Brocada serveis S.L. de la seva actuació. Als efectes previstos aquí s\'entén per continguts, sense que aquesta enumeració tingui caràcter limitatiu, els textos, fotografies, gràfics, imatges, icones, tecnologia, programari, links i altres continguts audiovisuals o sonors, així com el seu disseny gràfic i codis font En particular, l\'Usuari es compromet a no:<br>
a) Reproduir, copiar, distribuir, posar a disposició o de qualsevol altra forma comunicar públicament, transformar o modificar els Continguts, llevat que es compti amb l\'autorització del titular dels corresponents drets o això resulti legalment permès;<br>
b) Suprimir, manipular o de qualsevol forma alterar el copyright i altres dades identificatives de la reserva de drets de Brocada Serveis S.L. o dels seus titulars.<br><br>

DRETS DE PROPIETAT INTEL·LECTUAL I DE PROPIETAT INDUSTRIAL Tant el disseny del lloc i els seus codis font, com els logotips, marques, i altres signes distintius que hi apareixen, pertanyen a la Brocada Serveis S.L. o entitats col·laboradores i estan protegits pels corresponents drets de propietat intel·lectual i industrial. Igualment estan protegits pels corresponents drets de propietat intel·lectual i industrial les imatges, logos i melodies, etc. continguts al servidor de la Brocada Serveis S.L. En cap moment podrà entendre que l\'ús o accés al Lloc i/o als serveis oferts en el mateix atribueixen a l\'Usuari dret algun sobre les citades marques, noms comercials i/o signes distintius.<br><br>

El seu ús, reproducció, distribució, comunicació pública, transformació o qualsevol altra activitat similar o anàloga, queda totalment prohibida llevat que hi hagi expressa autorització de la Brocada Serveis S.L. La llicència d\'ús de qualsevol contingut d\'aquest Lloc atorgada a l\'usuari es limita a la descàrrega per part de l\'usuari d\'aquest contingut i l\'ús professional del mateix, sempre que els esmentats continguts romanguin íntegres.<br><br>

La Brocada Serveis S.L. declara el seu respecte als drets de propietat intel·lectual i industrial de tercers; per això, si considera que aquest lloc pogués estar violant els seus drets, preguem es posi en contacte amb La Brocada Serveis S.L. en la següent adreça de correu electrònic <b> bagesterradevins@bagesterradevins.cat </b><br><br>

FRAMES La Brocada Serveis S.L. prohibeix expressament la realització de framings o la utilització per part de tercers de qualssevol altres mecanismes que alterin el disseny, configuració original o continguts de la seva pàgina.<br><br>

PRIVACITAT La Brocada Serveis S.L. compleix amb la Llei Orgànica 15/1999, de protecció de dades de caràcter personal i amb qualsevol altra normativa vigent en la matèria, i manté una Política de Privacitat sobre les dades personals, en la qual es descriu, principalment, l\'ús que La Brocada Serveis S.L. fa de les dades de caràcter personal, s\'informa a l\'Usuari detalladament de les circumstàncies essencials d\'aquest ús i de les mesures de seguretat que s\'apliquen a les seves dades de caràcter personal per evitar que tercers no autoritzats puguin accedir-hi.<br><br>

La Brocada Serveis S.L. podrà utilitzar cookies. Les cookies són fitxers de text que els ordinadors envien al seu disc dur per facilitar al seu ordinador un accés més ràpid a la pàgina web seleccionada. La finalitat de les cookies de la Brocada Serveis S.L. és personalitzar els serveis que li oferim, facilitant-li informació que pugui ser del seu interès. Les galetes no extreuen informació del seu ordinador, ni determinen on es troba vostè. Si tot i això, vostè. No desitja que s\'instal·li en el seu disc dur una cookie, sol·licitem que configuri el navegador del seu ordinador per no rebre-. No obstant això, li fem notar que, en tot cas, la qualitat de funcionament de la pàgina web pot disminuir.<br><br>

<b> RESPONSABILITATS La Brocada Serveis S.L. </b><br><br>

La Brocada Serveis S.L. ha creat el Lloc <b> bagesterradevins.cat </b> per a la difusió de la seva activitat i per facilitar l\'accés als seus serveis, però no pot controlar la utilització del mateix de forma diferent a la prevista en el present Avís Legal; per tant l\'accés al Lloc i l\'ús correcte de la informació continguda en el mateix són responsabilitat de qui realitza aquestes accions, no sent responsable La Brocada Serveis S.L. per l\'ús incorrecte, il·lícit o negligent que del mateix pogués fer l\'usuari, ni del coneixement que puguin tenir tercers no autoritzats de la classe, condicions, característiques i circumstàncies de l\'ús que els Usuaris fan del Lloc i dels serveis. Així mateix, La Brocada Serveis S.L. tampoc serà responsable dels perjudicis de tota naturalesa que puguin deure a la suplantació de la personalitat d\'un tercer efectuada per un usuari en qualsevol classe de comunicació realitzada a través del web.<br><br>

UTILITZACIÓ DE CONTINGUTS La Brocada Serveis S.L. facilita tots els continguts de la seva pàgina de bona fe i farà tots els esforços perquè els mateixos estiguin permanentment actualitzats i vigents; no obstant això, la Brocada Serveis S.L. no pot assumir cap responsabilitat respecte a l\'ús o accés que realitzin els Usuaris fora de l\'àmbit al qual es dirigeix el Lloc, la responsabilitat final recaurà sobre l\'Usuari.<br><br>

VIRUS La Brocada Serveis S.L. es compromet a aplicar totes les mesures necessàries per intentar garantir a l\'Usuari l\'absència de virus, cucs, cavalls de Troia i elements similars en el seu Lloc. No obstant això, aquestes mesures no són infal·libles i, per això, no pot assegurar totalment l\'absència d\'aquests elements nocius. En conseqüència, la Brocada Serveis S.L. no serà responsable dels danys que els mateixos poguessin produir a l\'Usuari.<br><br>

ERRORS TECNOLÒGICS La Brocada Serveis S.L. ha conclòs tots els contractes necessaris per a la continuïtat de la seva pàgina i farà tots els esforços perquè aquest no pateixi interrupcions, però no pot garantir l\'absència d\'errors tecnològics, ni la permanent disponibilitat del lloc i dels serveis continguts en ell i, en conseqüència, no assumeix cap responsabilitat pels danys i perjudicis que puguin generar per la falta de disponibilitat i pels errors en l\'accés ocasionats per desconnexions, avaries, sobrecàrregues o caigudes de la xarxa no imputables a la Brocada Serveis S.L.<br><br>

LLEI APLICABLE I JURISDICCIÓ La llei aplicable en cas de disputa o conflicte d\'interpretació dels termes que conformen aquest Avís Legal, així com qualsevol qüestió relacionada amb els serveis d\'aquest lloc, serà la llei espanyola. Per a la resolució de qualsevol conflicte que pugui sorgir amb ocasió de la visita al Lloc o de l\'ús dels serveis que s\'hi puguin oferir, La Brocada Serveis S.L. i l\'usuari acorden sotmetre als jutges i tribunals de domicili de l\'Usuari, sempre que aquest estigui situat en territori espanyol.<br><br>

LINKS O HIPERENLLAÇOS La Brocada Serveis S.L. li facilita l\'accés a altres pàgines web que considerem poden ser del seu interès. L\'objectiu d\'aquests enllaços és únicament facilitar-li la recerca dels recursos que li puguin interessar a través d\'Internet. No obstant això, algunes d\'aquestes pàgines no pertanyen a la Brocada Serveis S.L. ni es fa una revisió dels seus continguts, de manera que en cap moment es podrà considerar a la Brocada Serveis S.L. com a responsable de les mateixes, del funcionament de la pàgina enllaçada o dels possibles danys que puguin derivar de l\'accés o ús de la mateixa.<br><br>

DURADA I ACABAMENT La prestació del servei del lloc i els altres serveis oferts en el mateix té, en principi, una durada indefinida. La Brocada Serveis S.L. podrà, no obstant això, donar per acabada o suspendre la prestació del servei del Lloc i/o de qualsevol dels serveis en qualsevol moment, sense perjudici del que s\'hagués disposat al respecte en les corresponents Condicions Particulars. A aquest efecte, la Brocada Serveis S.L. comunicar aquesta circumstància a la pantalla d\'accés al servei amb un preavís de quinze dies.
La Brocada Serveis S.L. es reserva, així mateix, el dret de modificar unilateralment, en qualsevol moment i sense previ avís, la presentació i condicions del lloc, així com els serveis del mateix i les condicions requerides per a la seva utilització.<br><br>

<b>POLÍTICA DE VENDES I DEVOLUCIONS</b><br><br>

COM ES COMPRA Bagesterradevins ofereix un catàleg d\'experiències enoturístiques classificades, cadascuna de les quals es du a terme per un o diferents col·laboradors de Bagesterradevins. Cada col·laborador ha signat un conveni de col·laboració amb Bagesterradevins per oferir el màxim de garanties de qualitat en el servei de les activitats, a més d\'exigir totes les condicions legals i de seguretat exigibles. L\'usuari podrà comprar l\'activitat amb totes les garanties a través d\'una passarel·la de pagament en línia. Tot seguit l\'usuari rebrà un document amb l\'acreditació corresponent, o bé podrà recuperar-la sempre que ho desitgi a través de la pàgina web.<br><br>

VIGÈNCIA I PROCEDIMENT La compra de l\'experiència dóna dret al comprador a fer-ne ús en el termini de vigència indicat a les condicions de l\'activitat, o durant 6 mesos si no s\'hi especifica. Igualment, és necessària la confirmació de la reserva per part de l\'organitzador de l\'experiència mitjançant el procediment indicat a la mateixa.<br><br>

DEVOLUCIONS No s\'acceptaran devolucions en les reserves si no hi ha la conformitat de l\'organitzador de l\'activitat. Si per motius climatològics o de força major no es pot realitzar una activitat, es buscarà una nova data per a realitzar-la.');

    define("privacitat_1",'En compliment del que disposa la llei 15/1999, de 13 de desembre, de Protecció de Dades Personals (LOPD), i el Reglament General de Protecció de Dades – Reglament (UE) 2016/679 del Parlament Europeu i del Consell de 27 d’abril de 2016, La Brocada Serveis S.L., com a responsable del/s fitxer/s, informa que les dades personals que l\'usuari facilitarà, inclosa la seva adreça de correu electrònic i totes aquelles dades personals a les quals puguem accedir durant la relació establerta, seran tractades en un/s fitxer/s degudament inscrit/s en l\'Agència Espanyola de Protecció de Dades i de conformitat amb el que estableix la legislació vigent.<br><br>

La informació que ens pugui ser remesa s\'incoporarà als sistemes d\'informació de la Brocada Serveis S.L. Aquesta comunicació s\'utilitzarà exclusivament per atendre a consultes i per mantenir-los informats de temes relacionats amb l\'activitat. Mitjançant la indicació, facilitació o introducció de les seves dades, i de conformitat amb el que estableix l\'article 6 de la LOPD, vostè atorga consentiment inequívoc a la Brocada Serveis S.L. perquè procedeixi, en compliment de les finalitats esmentades en l\'apartat anterior, al tractament de les dades personals facilitades. Així mateix, aquest consentiment s\'estén a la cessió de les dades d\'acord amb la legislació aplicable.<br><br>

L\'accés a les seves dades personals serà efectuat per personal autoritzat i subjecte així mateix a una obligació de secret, els mateixos i es tractaran de conformitat amb la LOPD 15/1999 així com del Reial Decret 1702/2007 en el seu desenvolupament, no podent-se utilitzar en cap cas per a finalitats diferents de les aquí autoritzades ni amb fins comercials o publicitaris, així com no podent-se cedir a terceres parts. En qualsevol moment vostè podrà exercitar els drets d\'accés, rectificació, oposició i, si és el cas, cancel·lació, mitjançant les eines de la pròpia web o comunicant-ho per correu electrònic a bagesterradevins@bagesterradevins.cat.');

    define("condicions",'He llegit i accepto les <a href="/condicions" target="_blank">Condicions d\'ús</a> i la <a href="/privacitat" target="_blank">Política de privacitat</a>.');

    define("condicions_reserva_a","La compra de l'experiència dóna dret al comprador a fer-ne ús en el termini de vigència indicat a les condicions de l'activitat (o durant 6 mesos si no s'hi especifica). Igualment, és necessària la confirmació de la reserva per part de l'organitzador de l'experiència mitjançant el procediment indicat a la mateixa. No s'acceptaran devolucions en les reserves si no hi ha la conformitat de l'organitzador de l'activitat. Si per motius climatològics o de força major no es pot realitzar una activitat, es buscarà una nova data per a realitzar-la.");

    define("condicions_reserva_b","La compra de l'experiència dóna dret al comprador a fer-ne ús única i exclusivament a la data de la sessió adquirida. No s'acceptaran devolucions en les reserves si no hi ha la conformitat de l'organitzador de l'activitat. Si per motius climatològics o de força major no es pot realitzar una activitat, es buscarà una nova data per a realitzar-la.");

    define("us",'Per validar la reserva només cal enviar un correu electrònic amb el codi de referència de la vostra reserva i el dia que voleu realitzar-la a: <b>reserves@bagesterradevins.cat</b>');
?>