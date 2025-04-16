<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once('../server/db.php');

//recuperer toutes les activities depuis la base de donnees
$sql = "SELECT * FROM activities ORDER BY name ";
$result = $conn->query($sql);

// Messages will be displayed after the HTML header
?>

<!DOCTYPE html>
<html lang="en">
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
    <title>Activités - Sportify</title>
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
                        <a class="nav-link" href="index.php">Accueil</a> <!-- Consider adding logic to make 'active' dynamic -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="activities.php">Activités</a> <!-- Consider adding logic to make 'active' dynamic -->
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
                        <!-- Optional: Add Profile/Dashbod link here -->
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

  <div class="page-header">
    <img src="../images/workout2.jpg" alt="Workout Banner" class="page-header-image">
    <div class="page-header-overlay"></div>
    <div class="page-header-content">
      <h1>DÉCOUVREZ NOS ACTIVITÉS</h1>
      <p class="lead">Des programmes sportifs adaptés à tous les niveaux pour atteindre vos objectifs fitness et bien-être</p>
      <a href="#activities-section" class="btn btn-primary">Explorer nos activités</a>
    </div>
  </div>

  <main class="container py-5" id="activities-section">
    <?php
    //afficher les messages de succes ou d'erreur 
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION['success_message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        unset($_SESSION['success_message']);
    }

    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION['error_message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        unset($_SESSION['error_message']);
    }
    ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        // Vérifier si des activités ont été trouvées
        if ($result && $result->num_rows > 0) {
            // Afficher chaque activité
            while ($activity = $result->fetch_assoc()) {
                // Compter le nombre actuel de participants 
                $sql_count = "SELECT COUNT(*) as count FROM bookings WHERE activity_id = ?";
                $stmt_count = $conn->prepare($sql_count);
                $stmt_count->bind_param("i", $activity['id']);
                $stmt_count->execute();
                $result_count = $stmt_count->get_result();
                $row_count = $result_count->fetch_assoc();
                $current_participants = $row_count['count'];
                $stmt_count->close();

                // Vérifier si l'activité est complète
                $is_full = ($current_participants >= $activity['max_participants']);
                
                $icon_class = "bi-activity";  
                $activity_name_lower = strtolower($activity['name']);
                
                if (strpos($activity_name_lower, 'yoga') !== false) {
                    $icon_class = "bi-peace";
                } elseif (strpos($activity_name_lower, 'pilates') !== false) {
                    $icon_class = "bi-heart-pulse";
                } elseif (strpos($activity_name_lower, 'renforcement') !== false) {
                    $icon_class = "bi-lightning";
                } elseif (strpos($activity_name_lower, 'cycling') !== false) {
                    $icon_class = "bi-bicycle";
                } elseif (strpos($activity_name_lower, 'fitness') !== false) {
                    $icon_class = "bi-trophy";
                } elseif (strpos($activity_name_lower, 'programme') !== false) {
                    $icon_class = "bi-calendar-check";
                }
        ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-img-top">
                            <?php
                            // Map activity names to image files
                            $image_file = 'workout.jpg'; // Default image
                            
                            if (strpos($activity_name_lower, 'yoga') !== false) {
                                $image_file = 'yoga.jpg';
                            } elseif (strpos($activity_name_lower, 'pilates') !== false) {
                                // Check pilates level
                                if (strpos($activity_name_lower, 'débutant') !== false) {
                                    $image_file = 'pilates_beginner.jpg';
                                } elseif (strpos($activity_name_lower, 'intermédiaire') !== false) {
                                    $image_file = 'pilates_intermediate.jpg';
                                } elseif (strpos($activity_name_lower, 'avancé') !== false) {
                                    $image_file = 'pilates_advanced.jpg';
                                } else {
                                    $image_file = 'pilates.jpg'; // Generic pilates image
                                }
                            } elseif (strpos($activity_name_lower, 'renforcement') !== false) {
                                $image_file = 'renforcement.jpeg';
                            } elseif (strpos($activity_name_lower, 'cycling') !== false) {
                                $image_file = 'cycling.jpg';
                            } elseif (strpos($activity_name_lower, 'fitness') !== false) {
                                $image_file = 'fitness.jpg';
                            } elseif (strpos($activity_name_lower, 'programme') !== false) {
                                $image_file = 'coaching.jpg';
                            }
                            
                            // Check if file exists, otherwise use fallback
                            $image_path = "../images/" . $image_file;
                            if (!file_exists($image_path)) {
                                // Fallback to these images if specific ones don't exist
                                $fallback_images = ['workout.jpg', 'workout1.jpg', 'workout2.jpg', 'poids.jpg', 'coaching.jpg'];
                                $image_file = $fallback_images[array_rand($fallback_images)];
                            }
                            ?>
                            <img src="../images/<?php echo $image_file; ?>" alt="<?php echo htmlspecialchars($activity['name']); ?>">
                            <div class="card-img-overlay">
                                <h6><?php echo htmlspecialchars($activity['name']); ?></h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($activity['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($activity['description']); ?></p>
                            
                            <div class="activity-detail">
                                <i class="bi bi-clock"></i>
                                <span>Durée: <?php echo $activity['duration']; ?> min</span>
                            </div>
                            
                            <div class="activity-detail">
                                <i class="bi bi-people"></i>
                                <span>Participants: <?php echo $current_participants; ?>/<?php echo $activity['max_participants']; ?></span>
                            </div>
                            
                            <?php if (!empty($activity['level'])): ?>
                                <div class="activity-detail">
                                    <i class="bi bi-bar-chart"></i>
                                    <span>Niveau: <?php echo htmlspecialchars($activity['level']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="activity-detail mb-3">
                                <i class="bi bi-person-badge"></i>
                                <span>Coach: <?php echo htmlspecialchars($activity['coach']); ?></span>
                            </div>

                            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                                <?php if ($is_full): ?>  
                                    <button class="btn btn-secondary w-100" disabled>Complet</button>
                                <?php else: ?>
                                    <form action="../server/booking_gestion.php" method="POST">
                                        <input type="hidden" name="activity_id" value="<?php echo $activity['id']; ?>">
                                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline-primary w-100">Connectez-vous pour vous inscrire</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<div class="col-12"><div class="alert alert-info">Aucune activité disponible pour le moment.</div></div>';
        }
        ?>
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

  <!-- Add Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>