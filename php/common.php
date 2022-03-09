<?php

	header('Cache-control: public'); // IE 6 FIX (private)
	header('Content-Type: text/html; charset=UTF-8');
//    header("Cache-Control: must-revalidate");
//
//    $offset = 60 * 60 * 24 * 5;
//    $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
//    header($ExpStr);

    $host = "localhost";
    $user = "root";
    $pass = "notaid";
    $databaseName = "btiquets";    
    $server = "http://127.0.0.1:8080/";    
    $zone = "Europe/Madrid";
    $info_mail = 'btiquets@btiquets.com';
    $admin_mail = 'btiquets@btiquets.com';
    $admin_tel = '686108724';
    $SUPERUSER = 6;
    $iva_1 = 21;
    $iva_2 = 10;
    $iva_3 = 7;
    $rootfolder = "/";

    $ereserva_1 = array(-2 => "Pagament en curs", -1 => "Pagament denegat", 0 => "Pendent de pagament", 1 => "Reserva correcta", 2 => "Activitat realitzada", 3 => "Pre-reserva");
    $ereserva_2 = array(-2 => "Reserva en curs", -1 => "Reserva denegada", 0 => "Reserva enviada", 1 => "Reserva acceptada", 2 => "Reserva realitzada", 3 => "Pre-reserva");    
    $ereserva_3 = array(-2 => "Pagament en curs", -1 => "Pagament denegat", 0 => "Pendent de pagament", 1 => "Compra correcta", 2 => "Compra correcta", 3 => "Pre-reserva");

    const _TIPUSIVA = array(21,10,4,0);
    
    $mysqli = new mysqli($host, $user, $pass, $databaseName);

	if(isset($_COOKIE["lang"]))
	{
		$lang = $_COOKIE["lang"];
	}
	else
	{
		$lang = 'ca';
        setcookie("lang", $lang, time() + (3600 * 24 * 30),"/");
	}

    $lang = 'ca';
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

L\'accés a les seves dades personals serà efectuat per personal autoritzat i subjecte així mateix a una obligació de secret, els mateixos i es tractaran de conformitat amb la LOPD 15/1999 així com del Reial Decret 1702/2007 en el seu desenvolupament, no podent-se utilitzar en cap cas per a finalitats diferents de les aquí autoritzades ni amb fins comercials o publicitaris, així com no podent-se cedir a terceres parts. En qualsevol moment vostè podrà exercitar els drets d\'accés, rectificació, oposició i, si és el cas, cancel·lació, mitjançant les eines de la pròpia web o comunicant-ho per correu electrònic a btiquets@btiquets.com.');
?>