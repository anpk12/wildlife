
Redovisning
================================================================================

Kmom01: Me-sida med Anax-MVC
--------------------------------------------------------------------------------

Mitt kodknackande görs i huvudsak i Vim 7.4 . Jag testar det lokalt med
den klassiska httpd:n från Apache samt Iceweasel (Debians rebrandade Firefox)
och laddar upp det jag lyckas skapa på
studentservern med FileZilla 3.9.0.5 . Dessa mjukvaror kör jag i
Debian 8.2 (jessie) med Linux 4.2.0-0. Som skrivbordsmiljö använder jag
Xfce 4.10 som jag kan rekommendera till de som vill ha något enkelt och
Gnome 2-liknande.

Jag är väldigt van vid att använda ramverk när jag programmerar generellt,
men inte speciellt van om vi begränsar oss till webbprogrammering.
Min erfarenhet då består i huvudsak av de tre första uppgifterna i den förra
versionen av den här kursen (phpmvc). Då använde jag html5boilerplate (som
kanske inte har så mycket med php att göra) samt skapade grunden till ett eget
mvc-ramverk i php.

Då jag hållit på med programmering under ganska lång tid nu både på hobby-nivå,
under utbildning samt professionellt så känner jag igen i stort sett samtliga
begrepp, även om jag kanske stött på en del av dem under andra sammanhang än
webbrelaterade. Men det betyder inte att jag är någon expert på php och mvc.
Det märks också att php är ett språk under utveckling.

Anax verkar vara ett genomtänkt ramverk, men för en så enkel webbplats som
den jag skapat i Kmom01 så känns det onödigt komplicerat.
Navbar-funktionaliteten, CSource och Markdown-hanteringen var trevliga och
förenklade avsevärt utvecklingen av webbplatsen, men har
ju egentligen inte mycket med MVC att göra (i mina ögon). Jag är kanske inte
en hundra procent övertygad MVC:are ännu, men hoppas att fördelarna ska bli
tydligare för mig efterhand som jag lär mig mer.

Jag tycker om och anammar
gärna idéer om att skilja på logik/funktionalitet och presentation, men
fullstora MVC-ramverk gör mig en aning förvirrad och jag funderar på om man
kanske kan utveckla efter MVC-konceptet utan ett stort ramverk eller kanske
med ett lite-ramverk. Men en annan aspekt kan vara att begränsningar eller
ramar som man får med ett ramverk kanske kan bidra till ökad kreativitet och
produktivitet, om man _lär_ sig ramverket. Då får man en tydlig arbetsprocess
för att lägga till nytt innehåll eller en ny sida, istället för att kunna göra
precis hur som helst vilket kanske leder till större beslutsångest och mer
inkonsekventa lösningar.

Jag följde den rekommenderade övningen efter bästa förmåga och lärde mig på så
sätt grunderna i hur man _använder_ Anax. Jag har inte studerat den interna
logiken/implementationen i någon större utsträckning men hoppas på att kunna
göra det inför kommande kursmoment.

Jag läste lite på/om php-fig och noterade
att CSource.php både hade klassdeklarationer och sidoeffekter i strid med
php-fig:s rekommendationer. Något som också skapade oväntade problem för mig
när jag först försökte visa källkoden för webbplatsen. Jag löste det genom
att radera sidoeffekterna nederst i filen.

Istället för att kopiera me.php till index.php skapade jag en symbolisk länk
i filsystemet till me.php med namnet index.php vilket fungerade både lokalt
och på studentservern (det gick även fint att ladda upp länken med FileZilla).

Jag hade lite problem med att få kravet med snygga länkar att fungera lokalt,
så det ska jag kanske se lite mer på också. Även annan konfigurering av min
http-server. Tidigare har jag lyckats konfigurera det så att varje användare
i systemet får en egen webroot ("public\_html") i sin hemkatalog, en funktion
jag älskar av någon anledning. Men för det här kursmomentet har jag jobbat
i /var/www/ vilket jag ogillar. Det måste jag kolla upp också.

Jag använder git för versionshantering och är väldigt van med det både från
egna projekt och jobbrelaterade. Jag kommer dock troligtvis inte ladda upp något
på github om inte kursen kräver det.

Stilmässigt gick jag efter hacker-med-dålig-smak och känner att jag lyckades
ganska bra. Jag är glad att jag kommit igång på riktigt med kursen nu och
hoppas att jag ska kunna börja med nästa kursmoment så snart som möjligt.

Kmom02: Kontroller och modeller
--------------------------------------------------------------------------------
Det här kursmomentet gick ganska bra. Jag var tvungen att slå upp en del
saker i php-manualen runt arrayer i php samt lite annat,
som date()-funktionen. Jag har även nystat upp en del av kopplingarna mellan
de olika delarna av Anax i större utsträckning för att klara det här
kursmomentet.

Det jag hade mest problem med var nog att skicka parametrar till
kontrollern samt att designa kontrollern och vyerna så att de blev
enkla att använda ifrån frontkontrollern/me.php . Jag valde att redan
i frontkontrollern avgöra om användaren ville uppdatera en kommentar
och baserat på det välja vilken kontroller-metod jag skulle anropa med
$app->dispatcher->forward. Problemet med det blev tydligt när jag
skulle lägga till kommentarsfält på flera undersidor/routes. Jag blev
tvungen att duplicera lite mer kod än jag skulle önska vilket så klart
ökar risken för misstag. Se koden för routerna "guestbook" och "guestbook2"
i me.php . I fortsättningen kommer jag att försöka flytta sådan logik
till kontrollern i större utsträckning.

Jag hade också en del problem med stylingen av kommentarerna då jag
bara kan grundläggande CSS samt började lite väl sent med det momentet
(jag var ju "så gott som klar"...). Jag blev tvungen att snabbt förstå
hur float fungerade när jag egentligen var lite för trött. Men det ordnade
sig. Visst, det ser kanske inte ut exakt som Stackoverflow, men jag
är ganska nöjd. Om jag skulle jobbat vidare med det hade jag kanske
försökt presentera metadatan lite mer diskret med ljusare färger och
mindre textstorlek. Delete-knappen hade kunnat ha en bild av en soptunna
istället för en länktext.

Composer verkar vara bra om man ska använda en färdig modul, som när
jag installerade phpmvc/comment. Men för utvecklingen kopierade jag
CommentController.php och CommentsInSession.php till app/src och bytte
namespace, eftersom jag ville versionshantera dem i samma
git-repository som resten av uppgiften och slippa gå via Composer för att
testa nya versioner medans jag jobbade. Jag är säker på att det finns bra
paket i Packagist, men jag har inte sett mig omkring utöver
användarinstruktionerna.

Jag vet inte om jag har greppat terminologin helt ännu, men jag förstår
ganska väl hur frontkontrollern, vyerna, kontrollern och modellen är
kopplade till varandra. Jag tror jag förstår _poängen_ med mvc något
bättre efter den här uppgiften.

Jag reflekterade inte över några svagheter i phpmvc/comment förutom två
uppenbara; kommentarerna existerar bara i sessionen samt avsaknad av
felhantering. Jag kan inte påstå att jag gjorde någon stor ansträngning
för att förbättra det, men jag lade in stöd för Gravatar samt döljer formuläret
tills man klickar på en länk.

Kmom03: Bygg ett eget tema
--------------------------------------------------------------------------------

Jag tror mig ha skapat ett tema som uppfyller de ställda kraven.
Jag stötte på en del problem på vägen. Vid ett tillfälle blev hela
sidan tom och ingen html skickades till webbläsaren. Jag hade glömt att
stänga en parentes och lägga till ett semikolon i frontkontrollern.
Jag följde guiden efter bästa förmåga och för det mesta fick jag
önskat resultat. Jag fick de responsiva brytpunkterna att fungera med en
gång, men jag hade problem att få regionerna till att ändra storlek
när jag drog i webbläsaren. Då såg jag att jag hade flera definitioner
av @total-width. Ibland tyckte jag instruktionerna var lite otydliga.
Jag fick också problem när jag försökte återanvända CSS från tidigare
kursmoment, då började helt plötsligt den responsiva griden uppföra
sig felaktigt. Sidebar:en och triptych-1, 2 och 3 la sig nedanför
main bland annat. Istället för att felsöka valde jag att återgå
till den fungerande structure.less och navbar.less .

Till sist
fick jag även problem när jag laddade upp mitt arbete på studentservern.
Det är ett misstag som jag upprepar i varje kursmoment; jag väntar till
sista dagen med att ladda upp och testa mitt arbete på studentservern.
Den här gången fick jag problem med stilmallarna. Rutnätet och övrig
stil var som bortblåst. När jag besökte style.php med webbläsaren fick
jag några felmeddelanden som efter en stund fick mig att tänka på
rättigheter. Jag har tidigare noterat att style.less.cache samt style.css
verkar genereras av webbserverprocessen. Jag testade först att göra det
tillåtet för _alla_ användare på systemet att läsa och skriva dessa två
filer. Det fungerade fortfarande inte, så då satte jag fulla rättigheter
på katalogen webroot/css/anax-grid och tog bort ovan nämnda filer.
Därefter fungerade det.

Det ska sägas att jag inte är speciellt intresserad av design. Men
LESS, lessphp, Semantic.gs och andra less-moduler gör det ju möjligt
att abstrahera bort en del av detaljerna, så jag är positivt inställd
till dem. Jag kan placera ut innehåll i responsiva rutnät utan att
behöva fundera ut alla css-detaljer själv. Jag har väldigt begränsad
(men inte obefintlig) erfarenhet av CSS och har mest använt det
för enklare saker som storlek på rubriker och färger på länkar.
Fast ett komplicerat projekt har jag gjort också; en renderare
för utslagsturneringar i php, html och css. Den var inte speciellt
semantiskt korrekt (mest för att jag inte kunde hitta lämpliga
html-element för det jag ville göra) men fungerade ganska bra.

Det är fint att få lära sig enkla metoder för att skapa gridbaserade
layouts när det behövs, men om jag skapar webbsidor åt mig själv
kommer jag nog att
fortsätta hålla det enkelt och fokusera på innehåll, läsbarhet och
semantik.

Normalize framstår som ett väldigt värdefullt hjälpmedel. Jag har
inget intresse av att läsa in mig på hur olika webbläsare skiljer
sig i sin tolkning av css, så det är fantastiskt att kunna använda
Normalize.

Bootstrap såg jag endast hastigt på och Font Awesome likaså. Men
de verkar användbara.

Jag har i huvudsak gjort som i övningen utan några större utsväningar.
Jag lekte lite med display: none för några av regionerna när jag
gjorde temat responsivt.

Jag har _inte_ gjort extrauppgiften, men jag har ägnat den en del tankar.
För att uppnå ett tema som inte är anpassat för ett visst ramverk
skulle jag försöka lägga upp det som ett bibliotek/lib. Jag skulle
skapa funktioner för att lägga till innehåll i de olika regionerna,
t.ex. addContent('featured-1', 'content goes here') eller
setContent(...). Det skulle ju innebära att jag gjorde temat beroende
av PHP, men inget speciellt PHP-ramverk eller så.

Det skulle då vara väldigt likt systemet med templates och
$app->views->addString(...) i Anax.

Kmom04: Databasdrivna modeller
--------------------------------------------------------------------------------

Det här kursmomentet tog en hel del tid för mig då det var
mycket instruktioner att följa och artiklar att läsa. Men
det mesta gick ganska smärtfritt. En sak jag hade problem med
var composer. Jag lyckades inte använda det för att installera
cdatabase. Men problemet hade att göra med ett annat paket
i min composer.json (ctextfilter om jag minns rätt).
I slutändan klonade jag ut cdatabase manuellt och installerade
under Anax/app/src .

Det tog mig också en stund att förstå att webserverprocessen behövde
ha skrivrättigheter till _mappen_ som innehöll sqlite3-databasen.
Jag fick det att fungera genom att sätta www-data som ägare till
både mappen och databasen. Jag använde även verktyget sqlite3
för att testa SQL-frågor och undersöka innehållet i tabellerna.

Formulärhanteringen som visas i kursmomentet (olika sätt att integrera
CForm i Anax) är jag ganska positiv till och jag håller med om
att det nog är en tidssparare. Jag valde att skapa formulären
explicit i UsersController och CommentController vilket lät mig
uppdatera modellerna direkt i callbackmetoderna. Dock duplicerade
jag en del kod för formulären när jag satte upp samma formulär
för _addAction_ som för _updateAction_. Men det är nog inget som
hindrar att man bryter ut det till en egen funktion som anropas
från respektive action.

Jag är nog inte fullständigt övertygad om förträffligheten i
att använda cdatabse. Jag har inte studerat den noga så jag
missar kanske något, men jag upplever det som att den försöker
skydda mig från att behöva skriva SQL, genom att istället få
mig att skriva saker som
db->query()->where('id = ?')->execute(...); Det finns nog en
poäng i att abstrahera kopplingen till databasen och hur
man sätter upp prepared statements, så att
jag som utvecklare inte behöver bry om jag använder sqlite
eller MariaDB.  Men SQL-koden i sig tycker jag kanske inte
man behöver dölja, om inte man kan göra det utan att införa
begränsningar. De flesta utvecklare kan förmodligen SQL,
och så som det abstraheras bort av cdatabase behöver man
fortfarande ha förståelse för det, hävdar jag.

En basklass för databasmodeller känns som en rimlig idé
som förmodligen leder till återanvändning av kod. Jag
ogillade den föreslagna implementationen av
getProperties(). Jag ogillar att automatiskt ta med alla
properties utom några specifika som jag listar (d.v.s. blacklisting)
och är rädd att jag helt plötsligt råkar få med en property
som inte har med databastabellen att göra. Jag är skeptisk
till att använda klassnamnet för att härleda tabellnamnet.
Sen undrar jag också hur man bör hantera modeller som backas
av flera tabeller. Det tycker jag inte att kursmomentet ger
svar på. T.ex. om jag skulle integrera kommentarssystemet
med användarsystemet, så att bara inloggade användare kunde
skriva kommentarer eller liknande. Då är jag osäker på om
det är en supermodell (;)) eller flera modeller.

För att uppgradera kommentarssystemet från Kmom02 till
att lagra kommentarerna i databas skapade jag en ny
modell som jag kallar Comment som ärver från basklassen.
Jag rättade till några gamla synder och flyttade
formulärhanteringen helt till CommentController med hjälp
av CForm. Ett problem att fundera över var hur man ska
stödja flera separata kommentarsflöden i den nya modellen.
Jag valde att lägga till en "flow"-kolumn i databastabellen.
Detta visade sig fungera bra. För att kunna radera alla
kommentarer i ett visst flöde skapade jag _deleteFlow($flow)_
i klassen Comment. Jag anser att den är lite för specifik
för den här modellen för att förtjäna en plats i basklassen.
Den anropas från CommentController::removeAllAction, d.v.s.
routen comment/removeAll/:flow (jag har inte exponerat den
via någon länk i nuläget). flow-parametern är en sträng
som matchar namnet på routen för kommentarsflödet;
'guestbook', 'guestbook2' eller 'redovisning'.
Jag har lämnat verbosity-inställningen för cdatabase
på då jag tänker att det kan vara intressant att se
vid granskningen också.

Jag har inte gjort extrauppgiften.

Notera att det finns en länk i navbar:en till "UsersController".
Det är testsidan som efterfrågas i uppgiften.

Kmom05: Bygg ut ramverket
--------------------------------------------------------------------------------

I det här kursmomentet skapade jag en modul för att
i huvudsak läsa ut systeminformation såsom
minnesförbrukning och belastning. Jag kallar den
anpk12/sysinfo. Jag använde inte någon existerande
kodbas. Modulen läser systeminformationen från /proc
och jag hittade den informationen jag behövde genom
manualsidan proc(5) på mitt Debian-system.

Jag hade
tänkt inkludera mer information då det finns mycket
intressant i /proc . T.ex. mer ingående information
om specifikt httpd-processens resursanvändning. Men
jag insåg att det var bättre att lägga ribban lågt
och frigöra tid till composer/packagist/github-delen
av uppgiften då jag ändå förstod det som det viktiga.

Från början tänkte jag skapa någon form av status-sida
som skulle kunna pinga samt eventuellt kolla vilka
tjänster som körde på andra servrar/domäner genom att
ansluta till olika portar. Men jag skrotade den idén
när jag insåg att jag hellre skulle gjort någon form
av server-browser för multiplayerspel, och det hade
nog blivit ett för stort projekt. Speciellt när jag
inte hade någon tydlig idé om _vilket_ spel jag skulle
fokusera på.

Jag hämtade inspiration till min modul från verktygen
free, uptime, top etc.

Utvecklingen gick fint och jag fick möjlighet att öva
lite på regex i php. Jag slår upp mycket information
i php:s manual. Integrationen av min modul tycker
jag kan beskrivas som enkel, speciellt om man
använder funktionen htmlReport() för att generera
färdig html. Jag utvecklade först modulen som en del
av Anax-MVC, under app/src-katalogen. Sedan flyttade
jag den till ett eget repo som jag publicerade på
Github.

Publiceringen på Packagist gick smärtfritt. Det enda
som förvirrade mig ett ögonblick var när jag satte
upp service-hooken i Github, eftersom Packagist
fortfarande listade min modul som "not auto-updated".
Men då testade jag bara att göra en commit och det
fick Packagist att ta bort varningen om
auto-uppdatering. Förmodligen för att det var först
då Packagist fick någon notifiering från Github.

Att skriva dokumentationen och testa att modulen
fungerade gick bra. Jag klonade ut Anax-MVC på nytt
och beskrev alla steg jag gjorde (förhoppningsvis)
för att integrera anpk12/sysinfo, precis som
rekommenderat i den tillhörande övningen på dbwebb.
Dokumentationen som jag skapade placerade jag i
modulens egna README-fil,
https://github.com/anpk12/sysinfo/blob/master/README.

Vad jag kan se finns det ingen extrauppgift i det
här kursmomentet, så nej, jag har inte gjort någon.

Generellt tyckte jag det här kursmomentet var lite
roligare då man slapp följa en guide som en robot
och fick möjlighet att tänka mer fritt (samt välja
vilken modul man skulle göra).

Kmom06: Verktyg och CI
--------------------------------------------------------------------------------

Det här kursmomentet tyckte jag om. Intressanta
och inspirerande läsanvisningar.

Jag jobbade som utvecklare (med i huvudsak språket C)
på ett ställe för 4 år sedan. Där använde vi oss
flitigt av automatiserade unit tests. Testramverken
var utvecklade in-house tillsammans med många andra
verktyg som vi använde rutinmässigt. När vi började
koppla samman vår C-kod med Java i ett senare skede
började vi även använda JUnit. Vi använde oss också
så småningom av Hudson och senare Jenkins för
continous integration. Code coverage tror jag inte
att vi arbetade med systematiskt. En uppgift ansågs
inte färdig förrän det fanns tester som gick igenom
samt att någon eller några granskat koden och
godkänt den.

Det gick bra att skriva testfall med PHPUnit. Ett
problem som jag hade var att min modul, Anpk12\Sysinfo,
läste från en extern datakälla, /proc. Resultatet
_förväntas_ vara olika varje gång. Inledningsvis
tänkte jag att det kanske var tillräckligt att bara
skriva tester som såg till att det inte kraschade,
men jag tänkte om. För att kunna testa det ordentligt
gjorde jag en ändring i modulen så att man kan säga
åt den att läsa systeminfo från valfri nod i
filsystemet. Därmed kunde jag skapa en statisk
instans av /proc att använda i mina tester. Jag
skapade då test/Sysinfo/fakeproc/{loadavg,meminfo}.
Därefter kunde jag skriva tester som förväntade sig
exakta värden för exempelvis minnesförbrukning.

Att integrera med Travis gick utmärkt, jag tror
att mitt allra första bygge där gick igenom. Det
kanske inte var så förvånande då jag kört testerna
lokalt tidigare och läst i förväg hur jag skulle
sätta upp .travis.yml .

Även Scrutinizer gick bra. Uppnådde 100% code
coverage, men så är min modul ganska liten också.
Mitt enda problem var det där märket/badgen om
code coverage som uppgiften krävde. Av någon
anledning stod det "unknown" under lång tid trots
att allt verkade ha gått bra och vara rätt. Jag
läste flera gånger i manualen och kollade igenom
inställningarna. Dagen efter hade det uppdaterats.

Jag är mycket positiv till att använda den här
typen av hjälpmedel och metoder som ett sätt att
försöka uppnå högre kvalitet. Jag tror det är
väl investerad tid, och webbtjänsterna Travis
och Scrutinizer gör det väldigt enkelt att komma
igång (kontra att installera, konfigurera och
kanske i viss mån scripta/programmera en egen
miljö för automatiska tester). Jag jobbar som
regel med C eller C++ men det såg inte ut att
vara något hinder för dessa webbtjänster.

Jag har inte gjort extrauppgiften.

Kmom07/10: Project och examination
--------------------------------------------------------------------------------

Mitt projekt i drift på studentservern:
http://www.student.bth.se/~anpk12/phpmvc/kmom07/Anax-MVC/webroot/

Inloggning och användare (krav 1, 2, 3)

För att hantera användare har jag återanvänt klassen UsersController
från tidigare kursmoment och utökat den med hantering av inloggning.
Det betyder att andra kontroller använder den som en tjänst för att
se vem som är inloggad (om någon).

I början av projektet var jag
osäker på hur jag skulle hantera den typen av interaktion
mellan olika kontroller och modeller, vilket har lett till att jag
varit inkonsekvent med hur jag har angripit liknande problem. Jag
har testat mig fram. Men UsersController har en getLoggedInUserAction
som enbart returnerar id och akronym för den användare som är inloggad,
eller null om ingen är det. Jag lade senare till en identisk getLoggedInUser()
som inte är en action (och därmed ej direkt nåbar via en URL).
Nuvarande inloggade användare lagras i sessionen.

För att registrera en användare finns UsersController::signupAction
som presenterar ett formulär med CForm. Alla användare lagras i en
tabell i databasen (jag har använt sqlite3). Det finns även en
loginAction som skapar ett formulär för inloggning.

Varje användare har en profil som kan nås genom UsersController::idAction
och uppdateras genom UsersController::updateAction. Kod för att presentera
gravatars har jag lagt in i relevanta vyer.

Frågor, svar, kommentarer och taggar (krav 1, 2, 3)

Vid sidan om UsersController finns även QuestionsController, TagsController,
AnswersController och Comments2Controller (2 för att särskilja från min gamla
kontroller för kommentarer från tidigare kursmoment).
De interagerar med databastabellerna question, answer, tag,
questiontagassociation och comment.

Varje fråga har ett id. Varje svar kopplas till ett fråge-id. Därför kan
systemet hämta alla svar för en viss fråga. Kommentarer har i databastabellen
en kolumn för fråge-id och en för svar-id och kan därmed tekniskt sett
kopplas till både en fråga och ett svar samtidigt. Men jag ser till att
kommentarer kopplas till antingen en fråga eller till ett svar, aldrig
både och.

Hur har jag implementerat taggar? Det finns två tabeller som rör taggar,
_tag_ och _questiontagassociation_. _tag_ lagrar själva taggarna med id,
namn och beskrivning. När man postar en fråga kan man skriva in taggarna
i ett fält i formuläret. De taggar som inte finns skapas. I tillägg skapas
associationer mellan frågan och taggarna i tabellen _questiontagassociation_.
Associationerna är egentligen bara ett id (för själva associationen),
ett fråge-id och ett tag-id. På så vis kan samma tag kopplas till många
frågor utan att lagra namn och beskrivning med redundans. Samtidigt
kan en fråga kopplas till många taggar. Jag har inte lagt till något
användargränssnitt för att redigera tagbeskrivningar i webbläsaren, men om man
redigerar beskrivningarna i databasen så visas de på webbsidan.

Med modeller och kontroller ovanpå de ovan beskrivna databastabellerna
är det inte så svårt att implementera kraven. En sida för frågor?
questions/list, hämta alla frågor. För varje fråga, hämta användaren
som postat samt alla svar. Räkna svaren, skicka allting till en vy/mall
för presentation.

En sida för taggar? tags/list. Hämta alla taggar. Skicka taggarna med
beskrivningar till en vy som listar dem och länkar till
questions/tagged/<tagname>.

En sida för användare? users/list. Hämta alla användare och presentera dem
i en vy som även länkar till users/id/<userid> så att man kan klicka sig
vidare till användarprofilerna.

About-sidan har jag implementerat som en statisk sida direkt i frontkontrollern.

För att visa vilka frågor en användare ställt och vilka den besvarat
(på profilsidan, users/id/<userid>) vidarebefordrar jag requesten
via dispatcher-tjänsten till questions/list samt questions/answered-by
med parametrar som begränsar utskrifterna till frågor kopplade till
den aktuella användaren. Det känns som ett av de mer lyckade besluten
min design.


För att stödja användargenererat innehåll i Markdown kör jag frågor,
svar och kommentarer igenom Markdown-filtret i relevanta vyer/mallar.

Förstasidan

Förstasidan är implementerad med hjälp av följande kontroller och actions:
- questions/list/5 (maxPosts-parametern satt till 5)
- tags/popular
- users/most-active

De anropas i tur och ordning via dispatcher->forward från frontkontrollern.


Allmänt om hur projektet gick att genomföra

För mig var det svåraste att bestämma hur de olika kontrollerna och
modellerna skulle interagera med varandra. Jag är inte nöjd med alla
mina (olika) lösningar på det, men har kanske fått en del insikter om
hur det kan hanteras i framtiden. Jag tror det hade varit värdefullt
att få in lite övning och vägledning runt den här problemställningen
i ett tidigare kursmoment, om möjligt. Dock är kursen ganska tidskrävande
som det är och jag har svårt att komma med förslag på vad man eventuellt
hade kunnat ta bort.

Jag tyckte egentligen inte projektet var alltför svårt, även om jag
inte känner mig nöjd med alla mina lösningar. Jag har i huvudsak jobbat
med kursen på helgerna då jag utför avlönat arbete på (mer än) heltid.
Efter två intensiva helger i början av Maj kände jag att jag löst
alla moment som jag uppfattade som svåra och att det mest var enklare
saker som kvarstod (lägga till relevanta länkar mellan de olika routerna,
snygga till presentationen, etc). Sen gick det ett gäng veckor utan att
jag hade möjligthet att jobba med projektet i någon större utsträckning,
så det blev ändå lite stress på slutet. Därför har jag valt att inte
göra de optionella kraven. Om jag förstått allting rätt är det här den
sista kursen jag behöver för att få ut både kandidat- och masterexamen
i datavetenskap, så jag känner att jag kan unna mig att ta ett lägre
betyg.

Jag tycker projektet var på en rimlig nivå. Jag var också mer motiverad
att sätta igång med det eftersom formatet passade mig bättre än de
tidigare kursmomenten; en lista på krav som man mer eller mindre fick
lösa hur man ville kontra väldigt långa och detaljerade guider.

En sak som var svår för mig var att jag inte har stenkoll på html,
css eller javascript. Html och css har jag hållt på med vid några
tillfällen tidigare, javascript ytterst lite. Själva designbiten
intresserar mig heller inte så mycket, så därför hamnar det väl på
min lista över svåra moment både i projektet och i tidigare kursmoment.


Tankar om kursen, materialet och handledningen

Som jar var inne på i det förra stycket så är jag lite tveksam till
upplägget med långa och detaljerade guider i kursmomenten. Det är
väldigt trevligt för att man nästan kan vara säker på att man kommer
att klara det. Dessutom är min uppfattning att det är enkelt att få
hjälp både från medstudenter och lärare. Men problemet som jag upplever
är att det inte känns kreativt att bara följa en massa steg-för-steg
guider. Jag blir helt enkelt omotiverad, vilket leder till att allting
tar mer tid. Samtidigt förstår jag att det inte är lätt att designa
en distanskurs, och kursen i fråga handlar ju väldigt mycket om
designmönster (i mina ögon), då blir det konstigt om man löser uppgifterna
utan att applicera mönstrena i fråga.

Jag är nöjd med kursen. Jag kan rekommendera kursen. Men jag har inte
läst något paket, och det skulle jag kanske rekommendera i första hand
även om jag tycker att jag klarade mig ganska bra. Jag ger kursen
8 av 10. Det som drar ner betyget för mig är upplägget med
steg-för-steg guiderna.
Men förmodligen är det många som är väldigt nöjda med just det upplägget.

