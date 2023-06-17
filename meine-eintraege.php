<?php
include "logic/UserManagement.php";
include_once "logic/SQLCardDAO.php";
include_once "logic/SQLAddressDAO.php";

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
	<?php
	include "components/header.php";
	$db = Database::getInstance();
	$conn = $db->getDatabase();
	$cardmanager = new SQLCardDAO($conn);
	$addressmanager = new SQLAddressDAO($conn);
	?>
	<main>
		<h4>Abholen</h4>
		<div class="cardspage">
			<?php
			$cards = $cardmanager->loadUserClaimedCards();
			if (sizeof($cards) > 0) {
				foreach ($cards as $card) {
					$card = unserialize($card);
					include "components/card.php";
				}
			} else {
				echo "Du hast noch kein Essen zum Abholen markiert";
			}
			?>
		</div>
		<h4>Meine Einträge</h4>
		<div class="cardspage">
			<?php
			$cards = $cardmanager->loadUserCards();
			if (sizeof($cards) > 0) {
				foreach ($cards as $card) {
					$card = unserialize($card);
					include "components/card.php";
				}
			} else {
				echo "Du hast noch kein Essen hochgeladen";
			}
			?>
		</div>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>