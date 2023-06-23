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
		$cards = $cardmanager->loadAllUnclaimedCards();
	}
	if (isset($_SESSION['currentNumberOfCards'])) { // reset the currentNumberOfCards
		unset($_SESSION['currentNumberOfCards']);
	}
	?>
	<main>
		<div class="cardspage" id="cardspage">
			<noscript>
			<?php
			if (sizeof($cards) > 0): ?>
				<?php foreach ($cards as $card) {
					$card = unserialize($card);
					include "components/card.php";
				} ?>
			<?php else: ?>
				<p style=magrin-top:10px;>Es gibt kein Essen zu retten</p>
			<?php endif; ?>
			</noscript>
			<script>
				function loadNumberOfCards(numberOfCardsToLoad) {   
					var request = new XMLHttpRequest();
					request.open('GET', "logic/CardFetcher.php?numberOfCards=" + numberOfCardsToLoad, true);
					request.onreadystatechange = function() {
						if (request.readyState === 4 && request.status === 200) {
							var cardspage = document.getElementById("cardspage");
							var cardsToLoad = request.responseText;
							console.log(cardsToLoad);
							cardspage.insertAdjacentHTML('beforeend', cardsToLoad);
						}
					};
					request.send();
				}

				// Die fünfzig sind ein bisschen extra space damit schon früher geladen wird
				function handleInfiniteScroll() {
					var endOfPage = window.innerHeight + window.pageYOffset >= (document.body.offsetHeight - 50);

					if (endOfPage) {;
						loadNumberOfCards(2);
					}
				}
				
				// Kann maybe raus get wahrscheinlich auf mit php
				window.onload = function () {
					$initialCards = 6;
					loadNumberOfCards($initialCards);
				};

				window.addEventListener("scroll",(event) => {handleInfiniteScroll()});
			</script>
	</main>
</body>

</html>