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
		<?php include "components/header.php"; ?>
		<main>
			<div class="cardspage">
				<?php 
				include_once "logic/CardController.php";
				include_once "logic/MainMemoryBasedCardDAO.php";
				$memory = MainMemoryBasedCardDAO::getInstance();
				echo htmlOfCard($memory->loadCard());
				?>
			</div>
		</main>
		<?php include "components/footer.php"; ?>
	</body>
</html>
