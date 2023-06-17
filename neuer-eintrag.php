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
    <form method="post" class="neuereintrag" action="logic/CardManager.php" enctype="multipart/form-data">
      <div class="form-section">
        <input type="hidden" name="newEntry">
        <label for="title">Titel</label>
        <input type="text" id="title" name="title" placeholder="Titel" required>
        <label for="food-type">Essensart</label>
        <select name="food-type" id="food-type" required>
          <option value="" selected disabled>Bitte Wählen...</option>
          <option value="vegan">Vegan</option>
          <option value="veggi">Vegetarisch</option>
          <option value="schwein">Schwein</option>
          <option value="fleisch">Fleisch</option>
          <option value="getrank">Getränk</option>
          <option value="sonst">Anderes</option>
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
        <input type="file" id="food-image" name="food-image" accept="image/*" required>
        <script>
          document.getElementById("food-image").onchange = evt => {
            const [file] = document.getElementById("food-image").files
            if (file) {
              preview.src = URL.createObjectURL(file)
            }
          }
        </script>
      </div>
      <div class="form-section">
        <label for="description">Beschreibung</label>
        <textarea id="description" name="description" rows="4" placeholder="Beschreibe dein Essen etwas..."
          required></textarea>
        <button class="accent" type="submit">Kostenlos einstellen</button>
      </div>
    </form>
  </main>
  <?php include "components/footer.php"; ?>
</body>

</html>