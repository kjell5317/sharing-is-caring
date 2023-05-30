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
			<br>
				<div class="cardspage">
				</div>
				<h4>Meine Einträge</h4>
				<br>
					<div class="cardspage">
						<?php 
						include "logic/CardController.php";
						include "logic/SessionBasedCardDAO.php";
						$memory = SessionBasedCardDAO::getInstance();
						echo htmlOfCard($memory->loadCard());
						?>
					</div>
					<br>
						<br>
						</main>
						<?php include "components/footer.php"; ?>
					</body>
				</html>
