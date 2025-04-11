<?php
session_start();
require_once 'db.php';

//initialize error variable
$error = "";

//check if the form was submitted 
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['registerName']);
    $email = trim($_POST['registerEmail']);
    $password = $_POST['registerPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($name)) {
        $errors[] = "Le nom complet est requis";
    }

    if(empty($email)){
        $errors[] = "l'adresse email est requise";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    }
    
    if(empty($password)){
        $errors[] = "le mot de passe est requis";
    }

    if($password !== $confirmPassword){
        $errors[] = "les mots de passe ne correspondent pas ";
    }

    //check if email is already existes
    if(empty($errors)){
        $sql_check = "SELECT id FROM users WHERE email = ?";
        if($stmt_check = $conn->prepare($sql_check)){
            $stmt_check->Bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result(); //store result to check num_rows

            if($stmt_check->num_rows > 0){
                $errors[] = "Cette adresse email est deja utilisée ";
            }
            $stmt_check->close();
        } else {
            $errors[] = "Erreur lors de la verification de l'email";
        }
    }

    //process registration if no errors 
    if(empty($errors)){
        //hash the password securely 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //prepare insert sql statement 
        $sql_insert = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        if($stmt_insert = $conn->prepare($sql_insert)){
            $stmt_insert->bind_param("sss", $name, $email, $hashed_password);

            //execute the statement 
            if($stmt_insert->execute()){
                //registration seccessful 
                $_SESSION['success_message'] = "Inscription réussis! vous pouvez maintenant vous connecter.";
                header(header: "Location: ../public/register.php"); //redirect to login page
                exit();
            }else {
                //registration failed 
                $errors[] = "Erreur lors d l'inscription. Veuillez réessayer plus tard.";
            }

            $stmt_insert->close();

        } else {
            $errors[] = "Erreur lors de la préparation de l'inscription.";
        }

    }


    //handle errors
    if(!empty($errors)){
        $_SESSION['error_message'] = implode("<br>", $errors);
        header("Location: ../public/register.php"); //redirect to register page with errors
        exit();
    }

    $conn->close(); //close the database connection


} else {
    //not a post request
    header("Location: ../public/index.php"); 
    exit();
}





