<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/anmeldung.css" />
		<title>Anmelden</title>
	</head>
	<body>
		<?php include "components/header.php"; ?>
		<main>
			<h2>Willkommen zurück!</h2>
			<h1>Anmeldung</h1>
			<h3>
        Melde dich an um deine Angebote zu verwalten und Zugriff zu deinem
        Dashboard zu erlangen.
      </h3>
			<form action="anmeldung.php">
				<input
          type="text"
          id="email"
          name="email"
          required
          placeholder="E-Mail Adresse"
        />
				<input
          type="password"
          id="password"
          name="password"
          required
          placeholder="Passwort"
        />
				<input type="submit" value="Anmelden" class="accent" />
			</form>
		</main>
		<?php include "components/footer.php"; ?>
	</body>
</html>
