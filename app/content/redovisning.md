
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

Kmom02: Kontroller och modeller
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
layouts, men om jag skapar webbsidor åt mig själv kommer jag nog att
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


