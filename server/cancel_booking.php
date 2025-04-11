<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../public/login.php");
    exit;
}

// Vérifier si l'ID de réservation est fourni
if (!isset($_POST['booking_id']) || empty($_POST['booking_id'])) {
    $_SESSION['error_message'] = "Identifiant de réservation manquant.";
    header("Location: ../public/my_booking.php");
    exit;
}

$booking_id = intval($_POST['booking_id']);
$user_id = $_SESSION['user_id'];

// Vérifier si la réservation existe et appartient à l'utilisateur
$sql_check = "SELECT b.id, a.name as activity_name 
              FROM bookings b 
              JOIN activities a ON b.activity_id = a.id 
              WHERE b.id = ? AND b.user_id = ?";

if ($stmt_check = $conn->prepare($sql_check)) {
    $stmt_check->bind_param("ii", $booking_id, $user_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "La réservation n'existe pas ou ne vous appartient pas.";
        header("Location: ../public/my_booking.php");
        exit;
    }

    $booking = $result->fetch_assoc();
    $activity_name = $booking['activity_name'];
    $stmt_check->close();

    // Supprimer la réservation
    $sql_delete = "DELETE FROM bookings WHERE id = ? AND user_id = ?";
    if ($stmt_delete = $conn->prepare($sql_delete)) {
        $stmt_delete->bind_param("ii", $booking_id, $user_id);

        if ($stmt_delete->execute()) {
            $_SESSION['success_message'] = "Votre réservation pour l'activité '{$activity_name}' a été annulée avec succès.";
            header("Location: ../public/my_booking.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Une erreur est survenue lors de l'annulation de la réservation. Veuillez réessayer.";
            header("Location: ../public/my_booking.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Erreur de préparation de la requête.";
        header("Location: ../public/my_booking.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Erreur de préparation de la requête.";
    header("Location: ../public/my_booking.php");
    exit;
}
?>

