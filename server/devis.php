<?php
session_start();
require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;   


$errors= [];

// recuperer les données du formulaire de maniere securisé
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nom= isset(($_POST['nom'])) ? htmlspecialchars($_POST['nom']): "non spécifié";
    $email=isset($_POST['email']) ? htmlspecialchars($_POST['email']) :"non spécifié";
    $tel= isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) :"non spécifié";
    //  verifier si le boutton radio is checked
    $type_cour=isset($_POST['choice']) ? $_POST['choice'] : "non spécifié";
    $programme_perso=isset($_POST['program']) ? $_POST['program'] : "non spécifié";
    $details=isset($_POST['details']) ? htmlspecialchars($_POST['details']) : "non spécifié";


    // pour les checkbox
    $objectifs = $_POST['choix'] ?? [];
    $objectifs = is_array($objectifs) ? $objectifs : [$objectifs];
     
    // La condition est inversée ici, ce qui cause un problème
    if (!empty($objectifs)){
        $objectifs_txt = "";
        foreach ($objectifs as $i => $obj) {
            $objectifs_txt .= ($i > 0 ? ", " : "") . $obj;
        }
    } else {
        $objectifs_txt = "non spécifié";
    }


    //pour les select
    $duree=$_POST['duree'];
    $nbr_seances=$_POST['nbr'];
    $lieu=isset($_POST['lieu']) ? $_POST['lieu'] : "non spécifié";
    $message=htmlspecialchars($_POST['msg']);




    //clalcuelr le tarif:
        $tarif_base=50; //tarif d'une seance
        $tarif_totale=($type_cour == "individuel") ? $tarif_base*1.5 : $tarif_base;

        //reduction selon la durée
        switch($duree){
            case "3mois":
                $tarif_totale*=0.9;
                break;
            case "6mois":
                $tarif_totale*=0.85;
                break;
            case "1an":
                $tarif_totale*=0.8;
                break;
            default:
              break;            
        }

        //extraction de nbr de seances
        //extraire une suite de chiffres dans une chaine de caracteres donné( $nbr_seances)
        //resultat dans $matches
        preg_match('/\d/',$nbr_seances,$matches);
        $nb=isset($matches[0]) ? intval($matches[0]) : 1;
        $prix_finale=$tarif_base * $nb *4; // estimation pour 1 mois

       
        

        // envoie de mail

        
        
        if(empty($errors)){
            try {
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;
                
                //configuration smtp
                $mail->isSMTP();
                $mail->Host ='smtp.gmail.com';
                $mail->SMTPAuth =true;
                $mail->Username = 'sportifysportify70@gmail.com';
                $mail->Password = 'ofygufrqjlhqhigk'; // Utilisez un mot de passe d'application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' =>false,
                        'allow_self_signed' => true,
                    ],
                ];
                
                //Destinataire
                $mail->setFrom('sportifysportify70@gmail.com', 'Sportify');
                $mail->addAddress($email); // adresse de destination
                
                //contenu
                $mail->Subject = 'Demande de devis';
                $mail->Body = "Nom: $nom\nEmail: $email\nTéléphone: $tel\nType de cour: $type_cour\n
                               Programme personalisé: $programme_perso\nDétails : $details\nObjectifs : $objectifs_txt\nDurée du programme : $duree\nNombre de séances/semaine: $nbr_seances\nLieu d'entrainement : $lieu\n💰 Estimation du tarif total : $prix_finale $\n
                               \n\nNous vous remercions de nous faire confiance et restons disponibles pour toute précision.";
                
                // Remplacer cette partie dans votre fichier server/devis.php
                $mail->send();
                $_SESSION['success_message'] = "Votre demande de devis a été envoyée avec succès! Nous vous contacterons bientôt.";
                header('Location: ../public/devis.php');
                exit;
            } catch (Exception $e) {
                echo "erreur d'envoi :" . $mail->ErrorInfo;
                exit;
            }
        } else {
            $_SESSION['error_message'] = implode("<br>", $errors);
            header('Location: ../public/devis.php');
            exit;
        }
    } else {
        // Correction du chemin de redirection si pas de POST
        header('Location: ../public/devis.php');
        exit;
    }

?>