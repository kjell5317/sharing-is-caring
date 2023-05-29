<?php include "logic/usermanagement.php"; ?>
<header>
  <a href="index.php" class="nav-el" id="logo"
    ><img src="assets/logo.png" alt="Logo"
  /></a>
  <input type="checkbox" id="nav-toggle" class="nav-toggle" />
  <nav>
    <ul class="nav-el">
      <li>
        <form action="index.php" class="nav-el">
          <input type="text" placeholder="Ich suche nach..." name="search" />
          <button type="submit"><img src="assets/search.svg" /></button>
        </form>
      </li>
      <?php if (isset($_SESSION['loggedInUser'])): ?>
        <li><a href="neuer-eintrag.php">Neuer Eintrag</a></li>
        <li><a href="meine-eintraege.php">Meine Einträge</a></li>
        <li><a href="?logout" class="accent">Abmelden</a></li>
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
</header>
