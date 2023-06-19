<?php
include_once "logic/Database.php";
include_once "logic/UserManagement.php";
?>
<header>
  <a href="index.php" class="nav-el" id="logo"><img src="assets/logo.png" alt="Logo" /></a>
  <input type="checkbox" id="nav-toggle" class="nav-toggle" aria-label="Open menu" />
  <nav>
    <ul class="nav-el">
      <li>
        <form action="index.php" class="nav-el" autocomplete="off">
          <input type="text" placeholder="Ich suche nach..." name="search" aria-label="Suche"
            onkeyup="showResult(this.value)"
            value="<?= isset($_GET["search"]) ? htmlentities($_GET["search"]) : ""; ?>" />
          <button type="submit" value="Suche"><img src="assets/search.svg" alt="Search Icon" /></button>
        </form>
        <div id="livesearch"></div>
      </li>
      <?php if (isset($_SESSION['loggedInUser'])): ?>
        <li><a href="neuer-eintrag.php" class="hover">Neuer Eintrag</a></li>
        <li><a href="meine-eintraege.php" class="hover">Meine Einträge</a></li>
        <li><a href="?logout" class="accent" class="hover">Abmelden</a></li>
      <?php else: ?>
        <li><a href="anmeldung.php" class="accent">Anmelden</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <label for="nav-toggle" class="nav-toggle-label">
    <span id="st"></span>
    <span id="nd"></span>
    <span id="rd"></span>
  </label>
  <script>
    function showResult(str) {
      if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = "";
        document.getElementById("livesearch").classList.remove("active");
        document.querySelector("nav input[type='text']").style.borderRadius = "50px 0 0 50px";
        document.querySelector("nav button[type='submit']").style.borderRadius = "0 50px 50px 0";
        document.querySelector("nav form").style.borderRadius = "50px";
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("livesearch").innerHTML = this.responseText;
          document.getElementById("livesearch").classList.add("active");
          document.querySelector("nav input[type='text']").style.borderRadius = "25px 0 0 0";
          document.querySelector("nav button[type='submit']").style.borderRadius = "0 25px 0 0";
          document.querySelector("nav form").style.borderRadius = "25px 25px 0 0";
        }
      }
      xmlhttp.open("GET", "logic/LiveSearch.php?q=" + str, true);
      xmlhttp.send();

    }
  </script>
</header>