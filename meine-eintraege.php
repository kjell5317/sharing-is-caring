<?php
include "logic/UserManagement.php";
include "logic/CardTranslator.php";
include_once "logic/SQLCardDAO.php";

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
	?>
	<main>
		<h4>Abholen</h4>
		<div class="cardspage">
			<?php
			$cardmanager = new SQLCardDAO($conn);
			echo htmlOfCards($cardmanager->loadUserClaimedCards());
			?>
		</div>
		<h4>Meine Einträge</h4>
		<div class="cardspage">
			<?php
			$cardmanager = new SQLCardDAO($conn);
			echo htmlOfCards($cardmanager->loadUserCards());
			?>
		</div>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>