<header class="p-3 bg-dark text-white"> <!-- Header section pulls navbar-->
  <div class="d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
    <a href="/Phone_CompareSite/phone_comparison_site/index.php">
    <img src="/Phone_CompareSite/assets/icons/PhoneSite.png" alt="Logo" class="logo-img">
    </a>
      <h1 class="m-0 fs-4">Your Phone Comparison Site</h1>
    </div>

    <form action="/Phone_CompareSite/search.php" method="get" class="position-relative">
      <input type="text" id="search-box" name="q" class="form-control" placeholder="Search phones...">
      <div id="search-results" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
    </form>
  </div>

  <?php require_once __DIR__ . '/navbar.php'; ?>
</header>