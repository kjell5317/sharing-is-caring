
<div class="card">
    <link rel="stylesheet" href="css/Card.css" />
    <img class="photo" src="<?= htmlentities($card->imagePath) ?>" />
    <h1>
        <?= htmlentities($card->title) ?>
    </h1>
    <p class="category">
        <?= htmlentities($card->foodType) ?>
    </p>
    <p class="mhd">
        <?= htmlentities($card->expirationDate) ?>
    </p>
    <p class="ort">
        <?= htmlentities($addressmanager->get($card->adr_id)->postalCode . ' ' .
            $addressmanager->get($card->adr_id)->city) ?>
    </p>
    <a class="weiter" href="eintrag.php?id=<?= htmlentities($card->id) ?>">
        <p style="margin: 0;">Zeig mir mehr</p>
        <img src="assets/arrow.svg" class="arrow" />
    </a>
</div>