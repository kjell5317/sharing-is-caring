<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/neuer-eintrag.css">
  <link rel="stylesheet" href="css/global.css">
  <link rel="icon" type="image/svg" href="assets/favicon.svg">
  <title>Neuer Eintrag</title>
</head>

<body>
  <?php include "components/header.php"; ?>
  <main>
    <div>
      <h1> Neuer Eintrag</h1>
      <h2>Teile dein Essen mit Oldenburg</h2>
    </div>
		<?php if ($error): ?>
			<p class="errormessage">
				<?= $error ?>
			</p>
		<?php elseif ($info): ?>
			<p class="infomessage">
				<?= $info ?>
			</p>
		<?php endif; ?>
    <form method="post" class="neuereintrag" action="logic/card/CardManager.php" enctype="multipart/form-data">
      <div class="form-section">
        <input type="hidden" name="newEntry">
        <label for="title">Titel</label>
        <input type="text" id="title" name="title" placeholder="Titel" required>
        <label for="food-type">Essensart</label>
        <select name="food-type" id="food-type" required>
          <option value="" selected disabled>Bitte Wählen...</option>
          <option value="Vegan">Vegan</option>
          <option value="Veggi">Vegetarisch</option>
          <option value="Schwein">Schwein</option>
          <option value="Fleisch">Fleisch</option>
          <option value="Getränk">Getränk</option>
          <option value="Anderes">Anderes</option>
        </select>
        <label for="expiration-date">Mindesthaltbarkeit</label>
        <input type="date" id="expiration-date" name="expiration-date" required>
        <div class="address">
          <div>
            <label for="street">Straße</label>
            <input type="text" id="street" name="street" placeholder="Straße" required>
          </div>
          <div>
            <label for="number">Hausnummer</label>
            <input type="text" id="number" name="number" placeholder="Hausnummer" required>
          </div>
        </div>
        <div class="address">
          <div>
            <label for="postal-code">Postleitzahl</label>
            <input type="text" id="postal-code" name="postal-code" placeholder="Postleitzahl" required>
          </div>
          <div>
            <label for="city">Ort</label>
            <input type="text" id="city" name="city" placeholder="Ort" required>
          </div>
        </div>
      </div>
      <div class="form-section image-container">
        <label for="food-image" class="upload-label">
          <img id="preview" class="food-img" src="assets/Placeholder.jpg" alt="Beispielbild" />
        </label>
        <input type="file" id="food-image" name="food-image" accept="image/*">
        <script>
          document.getElementById("food-image").onchange = evt => {
            const [file] = document.getElementById("food-image").files
            if (file) {
              //Mit freundlicher Unterstüzung von ChatGPT
              const image = new Image();
              const reader = new FileReader();
              reader.onload = (e) => {
                  image.onload = () => {
                      const canvas = document.createElement('canvas');
                      const ctx = canvas.getContext('2d');
                      
                      // Zielgröße
                      const targetWidth = 550;
                      const targetHeight = 420;
                      
                      canvas.width = targetWidth;
                      canvas.height = targetHeight;

                      const imageAspectRatio = image.width / image.height;
                      const targetAspectRatio = targetWidth / targetHeight;

                      let sourceX, sourceY, sourceWidth, sourceHeight;
                      if (imageAspectRatio > targetAspectRatio) {
                          // Das Originalbild ist breiter als das Zielbild
                          sourceHeight = image.height;
                          sourceWidth = sourceHeight * targetAspectRatio;
                          sourceX = (image.width - sourceWidth) / 2;
                          sourceY = 0;
                      } else {
                          // Das Originalbild ist schmaler oder genauso breit wie das Zielbild
                          sourceWidth = image.width;
                          sourceHeight = sourceWidth / targetAspectRatio;
                          sourceY = (image.height - sourceHeight) / 2;
                          sourceX = 0;
                      }
                      ctx.drawImage(image, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, targetWidth, targetHeight);
                      
                      // Das zugeschnittene Bild anzeigen
                      document.getElementById("preview").src = canvas.toDataURL();
                  }
                  image.src = e.target.result;
              };
              reader.readAsDataURL(file); 
            }
          }
        </script>
      </div>
      <div class="form-section">
        <label for="description">Beschreibung</label>
        <textarea id="description" name="description" rows="4" placeholder="Beschreibe dein Essen etwas..."></textarea>
        <button class="accent" type="submit">Kostenlos einstellen</button>
      </div>
    </form>
  </main>
  <?php include "components/footer.php"; ?>
</body>

</html>