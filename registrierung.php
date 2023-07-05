<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/global.css" />
	<link rel="stylesheet" href="css/anmeldung.css">
	<link rel="icon" type="image/svg" href="assets/favicon.svg">
	<title>Registrieren</title>
</head>

<body>
	<?php include "components/header.php"; ?>
	<main>
		<h2>Trete noch heute bei!</h2>
		<h1>Registrierung</h1>
		<h3>Registriere dich bei uns um Essen anzubieten und abzuholen. Teile dein Essen mit ganz Oldenburg!</h3>
		<?php if ($error): ?>
			<p class="errormessage"> <?= $error ?> </p>
		<?php elseif ($info): ?>
			<p class="infomessage"> <?= $info ?> </p>
		<?php endif; ?>
		<form method="POST">
			<input type="hidden" name="register">
			<input type="email" id="email" name="email" required placeholder="E-Mail Adresse" aria-label="E-Mail"
				value="<?= isset($_SESSION["email"]) ? htmlentities($_SESSION["email"]) : ""; ?>" />
			<input type="password" id="password" name="password" required placeholder="Passwort"
				aria-label="Password" />
			<input type="password" id="repassword" name="repassword" required placeholder="Passwort widerholen"
				aria-label="Repeat password" />
			<div class="ToS">
				<input type="checkbox" id="TOS" name="TOS" value="TOS">
					<label for="TOS" > Ich akzeptiere die <a href="Nutzungsbedingungen.php">Nutzungsbedingungen</a> und 
					<a href="Datenschutzerklaerung.php">Datenschutzerklärung</a></label> <br>
			</div>
			<input type="submit" value="Registrieren" class="accent" />
		</form>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>