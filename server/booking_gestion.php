<?php
session_start();
require_once 'db.php';

//verifier si l'utilisateur est connecté 
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ){
    $_SESSION['error_message'] = "vous devez vous connecter pour acceder à cette page";
    header("Location: ../public/login.php");
    exit();
}

//verifier si le formulaire a ete soumis 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['activity_id'])) {
    $activity_id = intval($_POST['activity_id']);
    $user_id = $_SESSION['user_id'];

    //verifier si l'activité existe 
    $sql_check_activity = "SELECT * FROM activities WHERE id = ?";
    if($stmt_check = $conn->prepare($sql_check_activity)) {
        $stmt_check->bind_param("i", $activity_id);  // Correction ici: "i" au lieu de ""
        $stmt_check->execute();
        $result_activity = $stmt_check->get_result();

        if($result_activity->num_rows === 0) {
            $_SESSION['error_message'] = "Activité introuvable";
            header("Location:../public/activities.php");
            exit();
        }

        $activity = $result_activity->fetch_assoc();
        $stmt_check->close();

        // Vérifier si l'utilisateur est déjà inscrit à cette activité
        $sql_check_booking = "SELECT * FROM bookings WHERE user_id = ? AND activity_id = ?";
        if ($stmt_booking = $conn->prepare($sql_check_booking)) {
            $stmt_booking->bind_param("ii", $user_id, $activity_id);
            $stmt_booking->execute();
            $result_booking = $stmt_booking->get_result();

            if ($result_booking->num_rows > 0) {
                $_SESSION['error_message'] = "Vous êtes déjà inscrit à cette activité.";
                header("Location: ../public/activities.php");  // Correction ici
                exit;
            }

            $stmt_booking->close();

            // Vérifier le nombre de participants actuels (fonctionnalité optionnelle)
            $sql_count = "SELECT COUNT(*) as count FROM bookings WHERE activity_id = ?";
            if ($stmt_count = $conn->prepare($sql_count)) {
                 $stmt_count->bind_param("i", $activity_id);
                 $stmt_count->execute();
                 $result_count = $stmt_count->get_result();
                 $row_count = $result_count->fetch_assoc();
                 $current_participants = $row_count['count'];
 
                // Vérifier si le nombre maximum de participants est atteint
                if ($current_participants >= $activity['max_participants']) {
                     $_SESSION['error_message'] = "Désolé, le nombre maximum de participants pour cette activité est atteint.";
                     header("Location: ../public/activities.php");
                     exit;
                 }
 
                $stmt_count->close();

                // Procéder à l'inscription
                $sql_insert = "INSERT INTO bookings (user_id, activity_id) VALUES (?, ?)";
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("ii", $user_id, $activity_id);

                    if ($stmt_insert->execute()) {
                        $_SESSION['success_message'] = "Vous êtes inscrit avec succès à l'activité '{$activity['name']}'.";
                        header("Location: ../public/booking_confirmation.php?id=" . $stmt_insert->insert_id);
                        exit;
                    } else {
                        $_SESSION['error_message'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
                        header("Location: ../public/activities.php");
                        exit;
                    }

                    $stmt_insert->close();
                } else {
                    $_SESSION['error_message'] = "Une erreur est survenue. Veuillez réessayer plus tard.";
                    header("Location: ../public/activities.php");
                    exit;
                }
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue. Veuillez réessayer plus tard.";
                header("Location: ../public/activities.php");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Une erreur est survenue. Veuillez réessayer plus tard.";
            header("Location: ../public/activities.php");
            exit;
        }
    }



}













