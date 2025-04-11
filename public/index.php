<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div class="hero-section">
      <div class="overlay"></div>
      <div class="hero-content">
        <h1 class="display-4 fw-bold">Sportify</h1>
        <div class="col-lg-8 mx-auto">
          <p class="lead mb-4">Votre plateforme unique pour réserver des activités sportives en ligne. Rejoignez nos coachs experts pour des séances de renforcement musculaire, fitness, yoga, et plus encore!</p>
          <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
            <a href="activities.php" class="btn btn-custom-primary btn-lg px-4">Voir les activités</a>
            <a href="login.php" class="btn btn-outline-light btn-lg px-4">S'inscrire / Se connecter</a>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <h1> ⚙️decouvrez notre fonctionnalités </h1> 
        <div class="row">
            <div class="col-lg-3" id="leftpart">
                <h4>perte de poids a distance:</h4>
              <img src="../images/poids.jpg" alt="perdre du poids">
            </div>
            <div class="col-lg-3" id="rightpart">
                <p>Perdez du poids efficacement, où que vous soyez, avec notre programme de suivi à distance ! <br>
                    Notre programme de perte de poids à distance est conçu pour vous accompagner tout au long de votre parcours, en vous offrant un plan personnalisé et un suivi régulier,  Que vous soyez à la maison, en voyage, ou même au bureau, notre approche flexible et accessible vous aide à atteindre vos objectifs. </p> 
                
            </div>
            <div class="col-lg-3" id="leftpart">
                <h4>coaching en ligne</h4>
                <img src="../images/coaching.jpg" alt="coaching en ligne">
            </div>
            <div class="col-lg-3" id="rightpart">
                <p>Atteignez vos objectifs depuis chez vous avec notre coaching en ligne personnalisé ! <br>
                    Notre programme de coaching en ligne vous permet de bénéficier d'un suivi professionnel et de conseils adaptés à vos besoins, où que vous soyez. Que vous soyez débutant ou confirmé, nos coachs certifiés vous guideront à chaque étape pour maximiser vos résultats</p>
                
            </div>
   
        </div>

        <hr>

        <div class="row">
            
          <div class="col-lg-3" id="leftpart">
              <h4>Challenge sportif</h4>
              <img src="../images/challenge.jpg" alt="challenge sportif">
          </div>
          <div class="col-lg-3 " id="rightpart">
             <p>Repoussez vos limites avec nos défis sportifs ! <br>
                Rejoignez notre communauté et participez à des challenges sportifs passionnants qui vous motivent à vous dépasser. Que vous soyez un athlète confirmé ou un débutant, nos défis sont conçus pour tous les niveaux et vous permettront de rester actif tout en vous amusant.</p>
          </div>
          <div class="col-lg-3" id="leftpart">
            <h4>Espace communautaire</h4>
            <img src="../images/communoté.jpg" alt="communautée">
          </div>
          <div class="col-lg-3" id="rightpart">
            <p>Rejoignez notre espace communautaire et faites partie d'une équipe qui vous soutient à chaque étape de votre parcours fitness ! <br>
                Notre espace communautaire est bien plus qu'un simple forum. C'est un lieu d'échange, de partage et de soutien où vous pouvez vous connecter avec d'autres passionnés de fitness, poser des questions, partager vos réussites et vous motiver mutuellement.</p>
          </div>
          
            
        </div>
        

       
        <hr>

    </div>



    <div class="container">
        <h1 class="services-title"> ✨Nos services</h1>
        <div class="services-container">
            <section class="service-card">
                <div class="service-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="service-header">
                    <h3>Programmes personnalisés</h3>
                </div>
                <div class="service-body">
                    <p>Un coaching sur mesure pour atteindre vos objectifs spécifiques</p>
                    <p><strong>Bénéfices :</strong></p>
                    <ul>
                        <li>Programmes adaptés à votre niveau</li>
                        <li>Possibilité de suivre les entraînements à domicile</li>
                        <li>Suivi constant pour ajuster les plans selon les progrès réalisés</li>
                    </ul>
                </div>
            </section>

            <section class="service-card">
                <div class="service-icon">
                    <i class="fas fa-apple-alt"></i>
                </div>
                <div class="service-header">
                    <h3>Suivi Nutritionnel</h3>
                </div>
                <div class="service-body">
                    <p>Des conseils diététiques personnalisés pour optimiser vos résultats sportifs</p>
                    <p><strong>Bénéfices :</strong></p>
                    <ul>
                        <li>Plans alimentaires adaptés à vos objectifs</li>
                        <li>Consultation avec un expert en nutrition</li>
                        <li>Conseils pratiques pour équilibrer vos repas</li>
                    </ul>
                </div>
            </section>

            <section class="service-card">
                <div class="service-icon">
                    <i class="fas fa-video"></i>
                </div>
                <div class="service-header">
                    <h3>Cours en Live & Replay</h3>
                </div>
                <div class="service-body">
                    <p>Des séances de fitness en direct, avec possibilité de replay</p>
                    <p><strong>Bénéfices :</strong></p>
                    <ul>
                        <li>Séances interactives en temps réel</li>
                        <li>Replays disponibles 24/7</li>
                        <li>Variété de cours: yoga, pilates, musculation, cardio, etc.</li>
                    </ul>
                </div>
            </section>
        </div>
        <hr>
    </div>



    <div class="container">
        <h2>💬Avis de nos memebres</h2>

        <div class="row">
            <div class="col-lg-6">
                <div class="testimonial-card">
                    <p class="testimonial-text">Une platforme intuitive et facile a utiliser, je recommande !</p>
                    <h5 class="testimonial-name"> -Karim D</h5>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="testimonial-card">
                    <p class="testimonial-text">Un vrai accompagnement professionnel, avec des conseils personnalisés qui font la différence</p>
                    <h5 class="testimonial-name"> -Sophie L</h5>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="testimonial-card">
                    <p class="testimonial-text">Service au top ! L'équipe est à l'écoute et les entraînements sont variés et efficaces</p>
                    <h5 class="testimonial-name"> -Laura G</h5>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="testimonial-card">
                    <p class="testimonial-text">Un excellent service ! J'ai pu atteindre mes objectifs rapidement grâce à leur programme personnalisé</p>
                    <h5 class="testimonial-name"> -Thomas B</h5>
                </div>
            </div>
        </div>
    </div>


    

  </main>


  <footer>
     <div class="container">
        <div  class="row">
            <div class="col-lg-6">
                <h4>A propos de nous</h4>
                <p>Sportify est une plateforme dédiée au bien-être et au fitness, offrant des programmes personnalisés, 
                    un coaching en ligne et une communauté motivante pour atteindre vos objectifs sportifs.
                 </p>
            </div>

            <div class="col-lg-6 text-center">
                <h4>Suivez-nous</h4><br>
                <i class="fab fa-facebook-f"></i> <!--icone de facebook--><a href="https://www.facebook.com" target="_blank">facebook</a> <br>
                <i class="fab fa-instagram"></i><a href="https://www.instagram.com" target="_blank">instagram</a>
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

  <script src="../scripts/validation.js"></script>

    
</body>
</html>
