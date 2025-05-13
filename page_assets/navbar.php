<?php // navbar.php ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-2">
  <div class="container-fluid">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="btn btn-dark nav-btn mx-2" href="/Phone_CompareSite/phone_comparison_site/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-dark nav-btn mx-2" href="/Phone_CompareSite/phone_comparison_site/ranking.php">Ranking</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-dark nav-btn mx-2" href="/Phone_CompareSite/phone_comparison_site/phone.php">Phones</a>
        </li>

        <!-- Adds extra buttons for profile page and logout-->
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <a class="btn btn-primary nav-btn mx-2" href="/Phone_CompareSite/phone_comparison_site/profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <form method="post" action="" class="d-inline">
              <button type="submit" name="logout" class="btn btn-danger nav-btn mx-2">Logout</button>
            </form>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>