<?php
include "logic/usermanagement.php";
include "logic/CardController.php";
include_once "logic/SessionBasedCardDAO.php";
$memory = SessionBasedCardDAO::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	echo "hi";
	if (isset($_SESSION['lastDisplayedCard']) && isset($_POST['eintrag'])) {
		$_SESSION['lastDisplayedCard']->claim();
		echo "claimed";
	}
}
$memory->storeClaimedCard();

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
			echo htmlOfCards($memory->loadClaimedCardsOfUser(unserialize($_SESSION['loggedInUser'])));
			?>
		</div>
		<h4>Meine Einträge</h4>
		<div class="cardspage">
			<?php
			echo htmlOfCards($memory->loadCardsOfUser(unserialize($_SESSION['loggedInUser'])));
			?>
		</div>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>