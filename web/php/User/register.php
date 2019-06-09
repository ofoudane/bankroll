<?php
    session_start();    
    require_once __DIR__ . "/../../../bankroll-connect/db-connect.php";
    global $db;

    $mail = $_POST['mail'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $motDePasse = $_POST['mot_de_passe'];


    $mail = pg_escape_string($mail);
    $nom = pg_escape_string($nom);
    $prenom = pg_escape_string($prenom);
    $motDePasse = pg_escape_string($motDePasse);

    $requete = "select addUser('$mail','$nom','$prenom','$motDePasse')";
    $result = $db->prepare($requete);
    $result->execute();
    $resultat = $result->fetch();
    if($resultat[0])
        $answer = "Compte crée avec succés";
    else
        $answer = "Création de compte échoué";

    $result->closeCursor();
    echo $answer;    
