<!--recuperer le message de succes venant de traitement.php -->
<?php 
session_start();
$successMessage='';
if(isset($_SESSION['success_message'])){
    $successMessage=$_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/devis.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <!-- Ajout du fichier CSS pour les activités -->
    <link rel="stylesheet" href="../styles/activities.css">
    <!-- Ajout du fichier CSS pour la page d'accueil -->
    <link rel="stylesheet" href="../styles/home.css">
    <!-- Google Fonts - Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--inclure font-awesome une bibliotheque d'icone-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Accueil - Sportify</title>
</head>
<body>
<!-- l'alerte JavaScript sera un message Bootstrap qui s'affiche dans la page -->
<?php if(!empty($successMessage)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050; min-width: 300px;">
    <?= htmlspecialchars($successMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
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
                        <a class="nav-link active" href="index.php">Accueil</a>
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
                            <a class="nav-link" href="login.php">Connexion / Inscription</a>
                         </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

    <main>
        <h2>Demande de Devis</h2>
        <h3>Nous nous engageons à vous répondre dans les plus brefs délais</h3>
        
        <form action="../server/devis.php" method="POST" id="quoteForm">
            <div class="box">
                <h4><i class="fas fa-user me-2"></i>Informations personnelles</h4>
                <div class="info-perso">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nom">Nom complet*</label> 
                            <input type="text" name="nom" id="quoteName" required> 
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email">Email*</label> 
                            <input type="email" name="email" id="quoteEmail" required> 
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tel">Téléphone*</label> 
                            <input type="text" name="tel" id="tel" required>
                        </div>
                    </div>
                </div>
                <hr>

                <h4><i class="fas fa-dumbbell me-2"></i>Type de cours</h4> 
                <div class="type-cour">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="individuel" name="choice" value="individuel" required>
                        <label class="form-check-label" for="individuel">Cours individuel</label>  
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="collectif" name="choice" value="collectif" required>
                        <label class="form-check-label" for="collectif">Cours collectif</label>
                    </div>
                </div>
                <hr>

                <h4><i class="fas fa-clipboard-list me-2"></i>Programme personnalisé</h4>
                <div class="programme-perso">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="option1" name="program" value="option1" required>
                        <label class="form-check-label" for="option1">Oui</label> 
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="option2" name="program" value="option2" required>
                        <label class="form-check-label" for="option2">Non</label>
                    </div>
                </div>

                <div id="detailsbox" class="mt-3" style="display: none;">
                    <label for="details">Veuillez préciser vos besoins</label>
                    <textarea name="details" id="details" rows="4" placeholder="Ex: coaching pour perdre du poids, préparation pour une compétition..."></textarea>
                </div>
                <hr>

                <h4><i class="fas fa-bullseye me-2"></i>Objectifs du programme</h4>
                <div class="objectifs">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="A" name="choix[]" value="perte de poids">
                                <label class="form-check-label" for="A">Perte de poids</label> 
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="B" name="choix[]" value="prise de masse">
                                <label class="form-check-label" for="B">Prise de masse</label> 
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="C" name="choix[]" value="ameliorer le cardio">
                                <label class="form-check-label" for="C">Améliorer le cardio</label> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="D" name="choix[]" value="remise en forme">
                                <label class="form-check-label" for="D">Remise en forme</label> 
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="E" name="choix[]" value="autre">
                                <label class="form-check-label" for="E">Autre</label> 
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <h4><i class="fas fa-calendar-alt me-2"></i>Fréquence & Durée</h4>
                <div class="duree-program">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duree">Durée souhaitée du programme*</label>
                            <select name="duree" id="duree" required>
                                <option value="1mois">1 mois</option>
                                <option value="3mois">3 mois</option>
                                <option value="6mois">6 mois</option>
                                <option value="1an">1 an</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nbr">Nombre de séances par semaine*</label>
                            <select name="nbr" id="nbr" required>
                                <option value="1fois">1 fois/semaine</option>
                                <option value="2fois">2 fois/semaine</option>
                                <option value="3fois">3 fois/semaine</option>
                                <option value="4fois+">4 fois ou plus</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>

                <h4><i class="fas fa-map-marker-alt me-2"></i>Lieu d'entraînement</h4>
                <div class="lieu">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="op1" name="lieu" value="domicile" required>
                        <label class="form-check-label" for="op1">À domicile</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="op2" name="lieu" value="salle" required>
                        <label class="form-check-label" for="op2">En salle de sport</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="op3" name="lieu" value="ligne" required>
                        <label class="form-check-label" for="op3">En ligne</label>
                    </div>
                </div>
                <hr>

                <h4><i class="fas fa-comment me-2"></i>Message complémentaire</h4>
                <div class="msg">
                    <label for="msg">Détails supplémentaires/Besoins spécifiques :</label>
                    <textarea name="msg" id="quoteDetails" rows="5"></textarea>
                </div>

                <div class="button-container">
                    <button type="submit">Demander un devis</button>
                </div>

                <div id="message"></div>
            </div>
        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/validation.js"></script>
    <script>
        // Afficher/masquer la section détails en fonction du choix "Programme personnalisé"
        document.addEventListener('DOMContentLoaded', function() {
            const option1 = document.getElementById('option1');
            const option2 = document.getElementById('option2');
            const detailsBox = document.getElementById('detailsbox');
            
            option1.addEventListener('change', function() {
                if(this.checked) {
                    detailsBox.style.display = 'block';
                }
            });
            
            option2.addEventListener('change', function() {
                if(this.checked) {
                    detailsBox.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
