<?php
session_start();
require_once 'db.php';


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Input Retrieval ---
    $email = trim($_POST['loginEmail']);
    $password = $_POST['loginPassword'];
    $errors = [];

    // --- Basic Validation ---
    if (empty($email)) {
        $errors[] = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }

    // --- Process Login if No Basic Errors ---
    if (empty($errors)) {
        // Prepare SQL statement to fetch user by email
        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result(); // Get result set

            if ($result->num_rows == 1) {
                // User found, fetch data
                $user = $result->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, login successful
                    // Regenerate session ID for security
                    session_regenerate_id(true);

                    // Store user data in session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];

                    // Redirect to a logged-in page (e.g., homepage or activities)
                    header("Location: ../public/index.php"); // Redirect to homepage after login
                    exit();
                } else {
                    // Invalid password
                    $errors[] = "Email ou mot de passe incorrect.";
                }
            } else {
                // No user found with that email
                $errors[] = "Email ou mot de passe incorrect.";
            }
            $stmt->close();
        } else {
            // Handle prepare error
            $errors[] = "Erreur lors de la tentative de connexion.";
            // In production, log: error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
    }

    // --- Handle Login Errors ---
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode("<br>", $errors);
        // Redirect back to login page with errors
        header("Location: ../public/login.php");
        exit();
    }

    $conn->close(); // Close the database connection

} else {
    // Not a POST request, redirect to homepage
    header("Location: ../public/index.php");
    exit();
}
