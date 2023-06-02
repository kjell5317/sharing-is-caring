<?php
include "logic/UserManagement.php";
include "logic/CardTranslator.php";
include_once "logic/SessionCardDAO.php";

?>
<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/global.css" />
	<link rel="icon" type="image/svg" href="assets/favicon.svg">
	<title>Meine Einträge</title>
</head>

<body>
	<?php include "components/header.php"; ?>
	<main>
		<h4>Abholen</h4>
		<div class="cardspage">
			<?php
			$usermanager = new SessionUserDAO();
			echo htmlOfCards($usermanager->loadClaimedCards());
			?>
		</div>
		<h4>Meine Einträge</h4>
		<div class="cardspage">
			<?php
			$usermanager = new SessionUserDAO();
			echo htmlOfCards($usermanager->loadCards());
			?>
		</div>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>