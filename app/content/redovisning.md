
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

