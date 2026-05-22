

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Scolaire</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="side.css"/>
</head>
<body>

  <!-- ══════════════ NAVBAR (top) ══════════════ -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
      <!-- Brand -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <div class="brand-icon d-flex align-items-center justify-content-center">
          <i class="bi bi-mortarboard-fill"></i>
        </div>
        <span class="brand-name">Groupe Scolaire Mont Amba</span>
      </a>

      <!-- Toggle button (hamburger) -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible menu -->
      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-2">
          <li class="nav-item">
            <a href="?page=acceuil" class="nav-link sidebar-link">
              <i class="bi bi-house-fill"></i>
              <span>Acceuil</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=comment" class="nav-link sidebar-link">
              <i class="bi bi-question-circle-fill"></i>
              <span>Comment ça marche</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=enfants" class="nav-link sidebar-link">
              <i class="bi bi-person-badge"></i>
              <span>Mes enfants</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=paiement" class="nav-link sidebar-link">
              <i class="bi bi-credit-card-fill"></i>
              <span>Paiement</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=evenement" class="nav-link sidebar-link">
              <i class="bi bi-calendar-event-fill"></i>
              <span>Événement</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=calendrier" class="nav-link sidebar-link">
              <i class="bi bi-calendar-week-fill"></i>
              <span>Calendrier</span>
            </a>
          </li>
        </ul>

        <!-- User info + Déconnexion button -->
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center gap-2">
            <div class="avatar-circle d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="bi bi-person-fill"></i>
            </div>
            <div class="text-end">
              <div class="user-name"><?= $_SESSION['nom'] ?></div>
              <small class="user-role">Utilisateur</small>
            </div>
          </div>
          <a href="logout.php" class="btn btn-deconnexion">
            <i class="bi bi-box-arrow-left me-2"></i>Déconnexion
          </a>
        </div>
      </div>
    </div>
  </nav>
  <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>