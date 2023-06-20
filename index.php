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
	$db = Database::getInstance();
	$conn = $db->getDatabase();
	$cardmanager = new SQLCardDAO($conn);
	$addressmanager = new SQLAddressDAO($conn);

	if (isset($_GET['search']) && !empty($_GET['search'])) {
		$cards = $cardmanager->queryCards($_GET['search']);
	} else {
		$cards = $cardmanager->loadUnclaimedCardsSequential(5);
	}
	?>
	<main>
		<div class="cardspage" id="cardspage">
			<?php
			if (sizeof($cards) > 0): ?>
				<?php foreach ($cards as $card) {
					$card = unserialize($card);
					include "components/card.php";
				} ?>
			<?php else: ?>
				<p style=magrin-top:10px;>Es gibt kein Essen zu retten</p>
			<?php endif; ?>
		<?php include_once "logic/InfiniteScrolling.php" ?>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>