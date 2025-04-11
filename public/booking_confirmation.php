<?php
session_start();
require_once '../server/db.php';

//verifier si l'utilisateur est connecté 
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: ../public/login.php");
    exit();
}

//verifier si l'id de reservation est fourni 
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: ../public/activities.php");
    exit();
}

$booking_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

//recuperer les detail de la reservation 
$sql = "SELECT b.id as booking_id, b.booking_date, a.name as activity_name, a.description, a.duration, a.coach, a.level
        FROM bookings b
        JOIN activities a ON b.activity_id = a.id
        WHERE b.id = ? AND b.user_id = ?"; 

if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0){
        //reservation non trouvée ou n'appartenant pas a l'utilisateur connectée 
        header("Location:../public/activities.php");
        exit();
    }

    $booking = $result->fetch_assoc();
    $stmt->close();

} else {
    //erreur lors de la preparation de la requete 
    header("Location:../public/activities.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation - Sportify</title>
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <!-- Google Fonts - Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--inclure font-awesome une bibliotheque d'icone-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../images/logo.jpg" alt="logo">
                    <span class="ms-2 brand-text">SPORTIFY</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="activities.php">Activités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="devis.php">Devis Personnalisé</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                            <!-- Logged In Links -->
                            <li class="nav-item">
                                <a class="nav-link active" href="my_booking.php">Mes Réservations</a>
                            </li>
                            <li class="nav-item">    
                                <span class="navbar-text me-2">
                                    Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                                </span>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link" href="../server/logout.php">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <!-- logged out link -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Connexion / Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h3 class="mb-0">Confirmation de Réservation</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill"></i> Votre réservation a été confirmée avec succès!
                            </div>

                            <h4>Détails de l'activité</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Activité</th>
                                    <td><?php echo htmlspecialchars($booking['activity_name']);?></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td><?php echo htmlspecialchars($booking['description']); ?></td>
                                </tr>
                                <tr>
                                    <th>Durée</th>
                                    <td><?php echo $booking['duration']; ?> minutes</td>
                                </tr>
                                <tr>
                                    <th>Coach</th>
                                    <td><?php echo htmlspecialchars($booking['coach']); ?></td>
                                </tr>
                                <?php if (!empty($booking['level'])): ?>
                                    <tr>
                                        <th>Niveau</th>
                                        <td><?php echo htmlspecialchars($booking['level']); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Date de réservation</th>
                                    <td><?php echo date('d/m/Y H:i', strtotime($booking['booking_date'])); ?></td>
                                </tr>
                            </table>

                            <p class="mt-4">Un email de confirmation a été envoyé à votre adresse email. Les détails de connexion pour la session en ligne vous seront communiqués ultérieurement.</p>

                            <div class="text-center mt-4">
                                <a href="activities.php" class="btn btn-primary">Retour aux activités</a>
                                <a href="my_booking.php" class="btn btn-secondary">Mes réservations</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h4>À PROPOS DE NOUS</h4>
                    <p>Sportify est une plateforme dédiée au bien-être et au fitness, offrant des programmes personnalisés, 
                        un coaching en ligne et une communauté motivante pour atteindre vos objectifs sportifs.
                    </p>
                </div>

                <div class="col-lg-6">
                    <h4>SUIVEZ-NOUS</h4>
                    <div class="social-links">
                        <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a><br>
                        <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="copyright">
                        © 2025 Sportify | Tous droits réservés.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>









