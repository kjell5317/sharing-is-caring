<?php 
include_once "logic/UserManagement.php"; 
?>
<header>
  <a href="index.php" class="nav-el" id="logo"><img src="assets/logo.png" alt="Logo" /></a>
  <input type="checkbox" id="nav-toggle" class="nav-toggle" aria-label="Open menu" />
  <nav>
    <ul class="nav-el">
      <li>
        <form action="index.php" class="nav-el">
          <input type="text" placeholder="Ich suche nach..." name="search" aria-label="Suche" />
          <button type="submit" value="Suche"><img src="assets/search.svg" alt="Search Icon" /></button>
        </form>
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
</header>