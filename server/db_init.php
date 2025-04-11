<?php

//script d'initialisation de la base de données
require_once 'db.php';

//creation des tables 
$tables = [
    //ta ble des utilisateurs
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );",

     // Table des activités sportives
     "CREATE TABLE IF NOT EXISTS activities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description TEXT NOT NULL,
        duration INT NOT NULL COMMENT 'Durée en minutes',
        max_participants INT NOT NULL,
        coach VARCHAR(100) NOT NULL,
        level VARCHAR(20) DEFAULT NULL COMMENT 'débutant, intermédiaire, avancé'
    );",

    // Table des réservations
    "CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        activity_id INT NOT NULL,
        booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
    );",

    // Table des demandes de devis
    "CREATE TABLE IF NOT EXISTS quotes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) DEFAULT NULL,
        service_type ENUM('individual', 'custom', 'group') NOT NULL,
        details TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );",

    // Table des messages de contact
    "CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );"

];


//executer les requetes de creation de tables 
foreach($tables as $sql) {
    if(!$conn->query($sql)) {
        echo "Erreur lors de la creation de la table: " . $conn->error . "<br>"; 
    }
}


//verifier si des activités existent deja 
$check_activities = "SELECT COUNT(*) as count FROM activities";
$result = $conn->query($check_activities);
$row = $result->fetch_assoc();


//inserer les activités par defaut si aucun n'existe 
if($row['count'] == 0) {
    $activities = [
        ["Yoga - Débutant", "Cours collectif de yoga pour débutants", 60, 5, "Michelle Legrand", "débutant"],
        ["Yoga - Intermédiaire", "Cours collectif de yoga de niveau intermédiaire", 60, 5, "Michelle Legrand", "intermédiaire"],
        ["Yoga - Avancé", "Cours collectif de yoga de niveau avancé", 60, 5, "Michelle Legrand", "avancé"],
        ["Pilates - Débutant", "Cours collectif de pilates pour débutants", 60, 3, "Marion May", "débutant"],
        ["Pilates - Intermédiaire", "Cours collectif de pilates de niveau intermédiaire", 60, 3, "Marion May", "intermédiaire"],
        ["Pilates - Avancé", "Cours collectif de pilates de niveau avancé", 60, 3, "Marion May", "avancé"],
        ["Renforcement Musculaire", "Cours collectif de renforcement musculaire", 45, 5, "Camille Lemont", NULL],
        ["Cycling", "Cours collectif de cycling (vélo d'appartement nécessaire)", 45, 3, "Amy Taylor", NULL],
        ["Fitness", "Cours collectif de fitness", 45, 5, "Laura Jones", NULL],
        ["Programme Personnalisé", "Coaching individuel avec suivi hebdomadaire", 60, 1, "Laura Marins", NULL]
    ];

    $stmt = $conn->prepare("INSERT INTO acrivities (name, description, duration, max_participants, coach, level) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach($activities as $activity) {
        $stmt->bind_param('ssiiss', $activity[0], $activity[1], $activity[2], $activity[3], $activity[4], $activity[5]);
        if(!$stmt->execute()) {
            echo "Erreur lors de l'insertion de l'activité :" . $stmt->error . "<br>";  
        }
    }

    $stmt->close();
    echo "Initialisation de la base de données terminée avec succès. ";

} else {
    echo "la base de données est déja initialisée.";
}


$conn->close();













