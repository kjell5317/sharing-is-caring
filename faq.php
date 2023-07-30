<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FAQ</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <link rel="stylesheet" href="css/datenschutzerklärung.css">
    <link rel="icon" type="image/svg" href="assets/favicon.svg">
</head>

<body>
    <?php include "components/header.php" ?>
    <main>
        <h1>FAQ</h1>
        <h2>Was ist "Sharing is Caring?"</h2>
        <p>Wir sind eine Plattform, auf der du dein übriggebliebenes Essen teilen kannst oder kostenlos das Essen
            anderer Nutzer abholen kannst.
            Damit wollen wir der Lebensmittelverschwendung entgegen wirken und gleichzeitig Menschen unterstützen, die
            ein kostenloses Essen gebrauchen können.
            Du benötigst sowohl für der Einstellen von Essen als auch zum Abholen einen Account.
        </p>
        <h2>Warum brauche ich einen Account?</h2>
        <p>Damit du Beiträge erstellen und verwalten kannst, benötigst du ein Account. 
            Außerdem kannst du nur mit einem Account Essen beanspruchen und dir den genauen Abholort anschauen. 
            Dadurch stellen wir sicher, dass kein unbefugter einfach deine Adresse bekommt.
        </p>
        <h2>Welche Daten werden von mir gespeichert?</h2>
        <p>Wir speichern so wenig wie möglich über dich. Das heißt wir haben nur deine E-Mail-Adresse um deinen Account
            zu verifizieren und dich im zweifelsfall erreichen zu können und dein Password (Hash), damit du dich
            anmelden kannst.
            Weiterhin wissen wir welche Beiträge von dir online sind und welches Essen du gerne abholen möchtest.
        </p>
        <h2>Wie erstelle ich einen Beitrag?</h2>
        <p>Zuerst musst du ein Account erstellen, ist das geschafft, hast du in der Menüleiste die Möglichkeit deine Beiträge zu verwalten und neue Einträge zu erstellen.
            Ohne Account ist dies beides leider nicht möglich.
        </p>
        <h2>Wie hole ich Essen ab?</h2>
        <p>Um Essen abholen zu können musst du eingeloggt sein. Bist du eingeloggt, klicke einfach bei dem Essen welches dich interessiert auf "Zeig mir mehr" und du gelangst zur Eintragsseite.
            Auf der Eintragsseite angekommen kannst du "Will ich haben" klicken und du bekommst du Abholadresse angezeigt.
        </p>
        <h2>Was ist eine Google API und warum nutzen wir das?</h2>
        <p>Eine API ist eine Schnittstelle, die es uns ermöglicht, Funktionen anzubieten, die wir nicht selber
            entwickelt haben.
            Wir nutzen die Google Maps Distance Matrix API, die es uns ermöglicht, die Entfernung zwischen zwei Orten zu
            berechnen. Diese Entfernung wird dann
            beim Essen angezeigt. Dafür werden jedoch personenbezogene Daten, wie deine IP-Adresse und dein Standort an
            Google weitergegeben, da die Berechnung
            der Entfernung auf Servern von Google stattfindet und nicht durch uns vorgenommen werden kann. Du kannst
            deine Zustimmung jederzeit <a href="nutzungsbedingungen.php">hier</a> widerrufen.
        </p>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>