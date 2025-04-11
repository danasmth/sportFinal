<?php
session_start();
require_once '../server/db.php';

//verifier si l'utilisateur est connecté
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ){
    header("Location: ../public/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

//recuperer les reservations de l'utilisateur 
$sql = "SELECT b.id as booking_id, b.booking_date, a.name as activity_name , a.description, a.duration , a.coach, a.level
        FROM bookings b
        JOIN activities a ON b.activity_id = a.id 
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    //erreur de preparation de la requete 
    $_SESSION['error_message'] = "Erreur lors de la recuperation des reservations";
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/style.css">
        <link rel="stylesheet" href="../styles/bootstrap.min.css">
        <!-- Add our new activities CSS file -->
        <link rel="stylesheet" href="../styles/activities.css">
        <!-- Google Fonts - Montserrat -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!--inclure font-awesome une bibliotheque d'icone-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- Add Bootstrap Icons for activity icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <title>Mes Réservations - Sportify</title>
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
                                <a class="nav-link" href="login.php">Connexion / Inscription </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page header section similar to activities.php -->
    <div class="page-header">
        <img src="../images/workout1.jpg" alt="Workout Banner" class="page-header-image">
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>MES RÉSERVATIONS</h1>
            <p class="lead">Consultez et gérez vos activités sportives réservées</p>
        </div>
    </div>

    <main class="container py-5">
        <?php
        //afficher les messages de succes ou d'erreur 
        if(isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'; 
            echo htmlspecialchars($_SESSION['success_message']);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['success_message']); 
        }

        if(isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo htmlspecialchars($_SESSION['error_message']);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button></div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <?php if($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-light table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Activité</th>
                            <th>Coach</th>
                            <th>Durée</th>
                            <th>Niveau</th>
                            <th>Date de réservation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php while ($booking = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['activity_name']); ?> </td>
                                <td><?php echo htmlspecialchars($booking['coach']);?> </td>
                                <td><?php echo $booking['duration']; ?> min</td>
                                <td><?php echo !empty($booking['level']) ? htmlspecialchars($booking['level']) : 'Tous niveaux'; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($booking['booking_date']));  ?> </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="booking_confirmation.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-sm btn-info">Détails</a>
                                        <form action="../server/cancel_booking.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Annuler</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <p>Vous n'avez pas encore de réservations</p>
                <a href="activities.php" class="btn btn-primary mt-3">Voir les activités disponibles</a>
            </div>
        <?php endif;?>
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

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>





