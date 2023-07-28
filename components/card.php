<div class="card">
    <link rel="stylesheet" href="css/card.css" />
    <img class="photo" src="<?= htmlentities($card->imagePath) ?>"
        onerror="this.onerror=null; this.src='assets/nopic.png';" />
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
        <?php
        $address = $addressmanager->get($card->adr_id);
        $first = $address->street . ' ' .
            $address->number . ' ';
        $second = $address->postalCode . ' ' .
            $address->city;
        if (isset($_SESSION["url"])) {
            $result = file_get_contents($_SESSION["url"] . urlencode($first . $second));
            if ($result !== false) {
                $second = $result;
                /*                 $v = json_decode($result)->rows[0]->elements[0]->distance->text;
                if (isset($v)) {
                $second = $v . " (" . $address->city . ")";
                } */
            }
        }
        echo $second;
        ?>
    </p>
    <a class="weiter" href="eintrag.php?id=<?= htmlentities($card->id) ?>">
        <p style="margin: 0;">Zeig mir mehr</p>
        <img src="assets/arrow.svg" class="arrow" />
    </a>
</div>