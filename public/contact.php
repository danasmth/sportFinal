<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/activities.css">
    <link rel="stylesheet" href="../styles/home.css">
    <!-- Ajout du CSS spécifique pour la page contact -->
    <link rel="stylesheet" href="../styles/contact.css">
    <!-- Google Fonts - Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--inclure font-awesome une bibliotheque d'icone-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Contact - Sportify</title>
</head>
<body>
    <!-- Afficher les messages de succès ou d'erreur -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?> 

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

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
                            <a class="nav-link active" href="contact.php">Contact</a>
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
                                <a class="nav-link" href="login.php">Connexion / Inscription</a>
                             </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <div class="contact-header text-center mb-5">
            <h1 class="display-4">Contactez-nous</h1>
            <p class="lead">Nous sommes à votre écoute pour toute question ou suggestion</p>
        </div>

        <div class="row">
            <!-- Contact Info -->
            <div class="col-md-5 mb-4">
                <div class="contact-info-card">
                    <h2>Nos Coordonnées</h2>
                    <p>N'hésitez pas à nous contacter pour toute questions ou demande d'information.</p>
                    <ul class="list-unstyled contact-details">
                        <li class="mb-3">
                            <i class="fas fa-phone-alt me-2"></i>
                            <strong>Téléphone :</strong> +33 1 23 45 67 89
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <strong>Email :</strong> <a href="mailto:sportify@mail.com">sportify@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <strong>Adresse :</strong> 123 Rue du Jean Jauré, 75000 Paris
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Horaires :</strong> Lun-Ven: 9h-18h | Sam: 10h-16h
                        </li>
                    </ul>
                    
                    <div class="social-links mt-4">
                        <h4>Suivez-nous</h4>
                        <a href="https://www.facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.twitter.com" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-md-7">
                <div class="contact-form-card">
                    <h2>Envoyez-nous un message</h2>
                    <form id="contactForm" action="../server/contact.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contactName" class="form-label">Votre Nom</label>
                                <input type="text" class="form-control" id="contactName" name="contactName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contactEmail" class="form-label">Votre Email</label>
                                <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contactSubject" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="contactSubject" name="contactSubject" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactMessage" class="form-label">Votre Message</label>
                            <textarea class="form-control" id="contactMessage" name="contactMessage" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom-primary">Envoyer le Message</button>
                    </form>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>