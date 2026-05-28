<?php
session_start();
require_once 'config.php';
if ( !isset($_SESSION['id_user'])){
    header('location: index.php');
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'acceuil';
    $req = $connexion -> prepare("SELECT * FROM users WHERE id_user = ?");
    $req -> execute([$_SESSION['id_user']]);
    $result = $req -> fetch();
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sidebar/nav.css">

    <link rel="stylesheet" href="styles/bootstrap.min.css">
</head>
<body>
    <?php include 'sidebar/navbar.php'; ?>
    <main class="main-content p-4">
        <?php
            switch ($page) {
                case 'acceuil':
                    include 'page-user/acceuil.php';
                    break;
                case 'comment':
                    include 'page-user/commentpayer.php';
                    break;
                case 'enfants':
                    include 'page-user/children.php';
                    break;
                case 'paiement':
                    include 'page-user/pay.php';
                    break;
                case 'evenement':
                    include 'page-user/event.php';
                    break;
                case 'calendrier':
                    include 'page-user/calendrier.php';
                    break;
                
                default:
                    echo "<h1>Page non trouvée</h1>";
            }
        ?>
    </main>
    <button id="scrollTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <a href="#top" class = "text-decoration-none text-white">↑</a>
    </button>
    <footer class="footer mt-auto py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-4 col-lg-3 mb-3 mb-md-0 text-center text-md-start">
                    <img src="./images/logo-removebg-preview.png" class="img-fluid w-25 h-25" alt="ici logo">
                </div>
                <div class="col-12 col-md-4 col-lg-3 text-center mb-md-0 text-md-start">
                    <span class="text-muted">&copy; 2026 ~ Groupe Scolaire Mont-Amba</span><br>
                    <span class="text-muted">Groupe SILLKLMTMM</span>
                </div>
                <div class="col-12 col-md-4 col-lg-3 text-center text-md-end">
                    <a href="#" class="text-muted me-3">Mentions légales</a>
                    <a href="#" class="text-muted me-3">Politique de conidentialité</a>
                    <a href="https://wa.me/+243842555645" target="_blank" class="text-muted">Contact </a>
                </div>
            </div>
        </div>
    </footer>
    <script src="scroll.js"></script>
    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="page-user/pay.js"></script>
</body>
</html>