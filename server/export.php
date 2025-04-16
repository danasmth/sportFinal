<?php
    $userAgent = $_SERVER["HTTP_USER_AGENT"]; 

    if(stripos($userAgent,'Windows')!==false){
        $password = "";
    }else{
        $password = "root";
    }
    $host = "localhost";
    $login = "root";

    try{
        $connexion = new PDO("mysql:host=$host",$login,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

        $connexion->exec("Create database if not exists sportify_db");
        $connexion->exec("use sportify_db");
        $sql = " 
        -- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des activités sportives
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    duration INT NOT NULL COMMENT 'Durée en minutes',
    max_participants INT NOT NULL,
    coach VARCHAR(100) NOT NULL,
    level VARCHAR(20) DEFAULT NULL COMMENT 'débutant, intermédiaire, avancé'
);

-- Table des réservations
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity_id INT NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
);

-- Table des demandes de devis
CREATE TABLE IF NOT EXISTS quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    service_type ENUM('individual', 'custom', 'group') NOT NULL,
    details TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des messages de contact
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion des activités par défaut
INSERT INTO activities (name, description, duration, max_participants, coach, level) VALUES
('Yoga - Débutant', 'Cours collectif de yoga pour débutants', 60, 5, 'Michelle Legrand', 'débutant'),
('Yoga - Intermédiaire', 'Cours collectif de yoga de niveau intermédiaire', 60, 5, 'Michelle Legrand', 'intermédiaire'),
('Yoga - Avancé', 'Cours collectif de yoga de niveau avancé', 60, 5, 'Michelle Legrand', 'avancé'),
('Pilates - Débutant', 'Cours collectif de pilates pour débutants', 60, 3, 'Marion May', 'débutant'),
('Pilates - Intermédiaire', 'Cours collectif de pilates de niveau intermédiaire', 60, 3, 'Marion May', 'intermédiaire'),
('Pilates - Avancé', 'Cours collectif de pilates de niveau avancé', 60, 3, 'Marion May', 'avancé'),
('Renforcement Musculaire', 'Cours collectif de renforcement musculaire', 45, 5, 'Camille Lemont', NULL),
('Cycling', 'Cours collectif de cycling (vélo d\'appartement nécessaire)', 45, 3, 'Amy Taylor', NULL),
('Fitness', 'Cours collectif de fitness', 45, 5, 'Laura Jones', NULL),
('Programme Personnalisé', 'Coaching individuel avec suivi hebdomadaire', 60, 1, 'Laura Marins', NULL);

 ";       

        $connexion->exec($sql);
        $connexion= null ; 
        echo "data base est créé et les table et mme inseré";
        header("Location: ../public/index.php");
        exit();
    }catch(PDOException $e){
        echo $e->getMessage();
        exit();
    }
    

?>
