<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/global.css" />
	<link rel="icon" type="image/svg" href="assets/favicon.svg">
	<title>Sharing is Caring</title>
</head>

<body>
	<?php
	include "components/header.php";
	include_once "logic/SQLCardDAO.php";
	include_once "logic/SQLAddressDAO.php";
	?>
	<main>
		<div class="cardspage">
			<?php
			$db = Database::getInstance();
			$conn = $db->getDatabase();
			$cardmanager = new SQLCardDAO($conn);
			$addressmanager = new SQLAddressDAO($conn);

			$cards = $cardmanager->loadAllUnclaimedCards();
			if (sizeof($cards) > 0) {
				foreach ($cards as $card) {
					$card = unserialize($card);
					include "components/card.php";
				}
			} else {
				echo "Es gibt kein Essen zu retten :(";
			}

			?>
		</div>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>