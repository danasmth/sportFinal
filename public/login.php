<?php
// Démarrer la session au début du fichier
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Sportify</title>
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <!-- Ajout du fichier CSS pour les activités -->
    <link rel="stylesheet" href="../styles/activities.css">
    <!-- Ajout du fichier CSS pour l'authentification -->
    <link rel="stylesheet" href="../styles/auth.css">
    <!-- Google Fonts - Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!-- Header avec navigation -->
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
                                <a class="nav-link" href="my_booking.php">Mes Réservations</a>
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
                                <a class="nav-link active" href="login.php">Connexion / Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    

    <div class="auth-container">
        <div class="auth-wrapper">
            <div class="auth-image" style="background-image: url('../images/fitness.jpg');">
                <div class="auth-image-content">
                    <h2>Bienvenue sur Sportify</h2>
                    <p>Connectez-vous pour accéder à votre espace personnel et gérer vos activités sportives.</p>
                </div>
            </div>
            <div class="auth-form">
                <h3>Connexion</h3>
                
                <?php
                // Afficher les messages d'erreur ou de succès
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show">' . htmlspecialchars($_SESSION['error_message']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    unset($_SESSION['error_message']);
                }
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show">' . htmlspecialchars($_SESSION['success_message']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    unset($_SESSION['success_message']);
                }
                ?>
                
                <form action="../server/login.php" method="POST">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="loginEmail" required placeholder="Votre adresse email">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="loginPassword" required placeholder="Votre mot de passe">
                    </div>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
                
                <div class="auth-links">
                    Pas encore de compte? <a href="register.php">S'inscrire</a>
                </div>
            </div>
        </div>
    </div>

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
