<?php
session_start(); // Démarrer la session
require_once 'db.php'; // Inclure la configuration de la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et nettoyer les données du formulaire
    $name = trim($_POST['contactName']);
    $email = trim($_POST['contactEmail']);
    $subject = trim($_POST['contactSubject']);
    $message = trim($_POST['contactMessage']);
    $errors = [];

    // Validation côté serveur
    if (empty($name)) {
        $errors[] = "Le nom complet est requis.";
    }
    if (empty($email)) {
        $errors[] = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }
    if (empty($subject)) {
        $errors[] = "Le sujet est requis.";
    }
    if (empty($message)) {
        $errors[] = "Le message est requis.";
    }

    // Si aucune erreur, enregistrer le message dans la base de données
    if (empty($errors)) {
        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $name, $email, $subject, $message);

            if ($stmt->execute()) {
                // Envoyer un email à l'adresse de la boutique (simulation)
                $to = "sportify@mail.com";
                $subject_email = "Nouveau message de contact: $subject";
                $message_email = "Nouveau message de $name ($email)\n";
                $message_email .= "Sujet: $subject\n";
                $message_email .= "Message: $message\n";

                // Dans un environnement réel, on utiliserait mail() ou une bibliothèque comme PHPMailer
                // mail($to, $subject_email, $message_email, "From: $email");

                // Stocker un message de succès dans la session
                $_SESSION['success_message'] = "Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.";

                // Rediriger vers la page de contact
                header("Location: ../public/contact.php");
                exit;
            } else {
                $errors[] = "Une erreur est survenue lors de l'enregistrement de votre message. Veuillez réessayer.";
            }

            $stmt->close();
        } else {
            $errors[] = "Une erreur est survenue. Veuillez réessayer plus tard.";
        }
    }

    // S'il y a des erreurs, les stocker dans la session et rediriger
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode("<br>", $errors);
        header("Location: ../public/contact.php");
        exit;
    }
} else {
    // Si la page est accédée directement sans soumission de formulaire
    header("Location: ../public/contact.php");
    exit;
}





