<?php
session_start();
if ( !isset($_SESSION['id'])){
    header('location: index.php');
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
    
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
    <link rel="stylesheet" href="sidebar/side.css">
</head>
<body>
    <?php include 'sidebar/sidebar.php'; ?>
    <main class="main-content p-4">
        <?php
            switch ($page) {
                case 'students':
                    include 'pages/students.php';
                    break;
                case 'events':
                    include 'pages/events.php';
                    break;
                case 'users':
                    include 'pages/users.php';
                    break;
                case 'dashboard':
                    include 'pages/tableau.php';
                    break;
                case 'calendrier':
                    include 'pages/calendrier.php';
                    break;
                case 'paiement':
                    include 'pages/paiement.php';
                    break;
                default:
                    echo "<h1>Page non trouvée</h1>";
            }
        ?>
    </main>
    <button id="scrollTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <a href="#top" class = "text-decoration-none text-white">↑</a>
    </button>
    <script src="scroll.js"></script>
    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>