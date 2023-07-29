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
	include_once "logic/sqlDAO/SQLCardDAO.php";
	include_once "logic/sqlDAO/SQLAddressDAO.php";

	if (isset($_SESSION['currentNumberOfCards'])) { // reset the currentNumberOfCards
		unset($_SESSION['currentNumberOfCards']);
	}
	?>
	<main>
		<?php if ($info): ?>
			<p class="infomessage">
				<?= $info ?>
			</p>
		<?php endif; ?>
		<div id="cardspage" class="cardspage">
			<noscript>
				<?php
				$cardmanager = new SQLCardDAO();
				$addressmanager = new SQLAddressDAO();

				if (isset($_GET['search']) && !empty($_GET['search'])) {
					$cards = $cardmanager->queryUnclaimedCards($_GET['search']);
				} else {
					$cards = $cardmanager->loadAllUnclaimedCards();
				}

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
					var url = `logic/card/CardManager.php?numberOfCards=${numberOfCardsToLoad}&search=${new URLSearchParams(window.location.search).get('search')}`;
					console.log(url);
					request.open('GET', `logic/card/CardManager.php?numberOfCards=${numberOfCardsToLoad}&search=${new URLSearchParams(window.location.search).get('search')}`, true);
					request.onreadystatechange = function () {
						if (request.readyState === 4 && request.status === 200) {
							var cardspage = document.getElementById("cardspage");
							var cardsToLoad = request.responseText;
							if (cardsToLoad) {
								cardspage.insertAdjacentHTML('beforeend', cardsToLoad);
							}
							if (!cardspage.innerHTML) {
								cardspage.innerHTML = "<p style=magrin-top:10px;>Es gibt kein Essen zu retten</p>";
							}
						}
					};
					request.send();
				}

				function handleInfiniteScroll() {
					var endOfPage = window.innerHeight + window.pageYOffset >= (document.body.offsetHeight - 50);

					if (endOfPage) {
						loadNumberOfCards(initialCards);
					}
				}

				window.onload = function () {
					initialCards = Math.floor(window.innerWidth / 327);
					loadNumberOfCards(initialCards * Math.ceil(window.innerHeight / 410));
				};

				window.addEventListener("scroll", (event) => { handleInfiniteScroll() });
			</script>
	</main>
	<?php include "components/footer.php"; ?>
</body>

</html>