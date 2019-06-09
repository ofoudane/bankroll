<?php
    session_start();
    if(!isset($_SESSION['e-mail']) || !isset($_SESSION['sessionId']))
        header('Location: index.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Une Bankroll">
    <meta name="author" content="Omar Foudane">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <style>

    </style>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark  bg-dark">
    <a class="navbar-brand" href="#">BankRoll</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuDeNavigation" aria-controls="menuDeNavigation" aria-expanded="false" >
        <span class="navbar-toggler-icon" data-toggle="tooltip" data-placement="left" title="affiche le menu"></span>
    </button>
    <div class="collapse navbar-collapse " id="menuDeNavigation">
        <ul class="navbar-nav mr-auto text-center">
            <a class="nav-link nav-item" href="pagePerso.php">espace-personnel</a>
            <a class="nav-link nav-item active" href="Profil.php">profil</a>
            <a class="nav-link nav-item" href="myBankroll.php">Vos Bankroll</a>
        </ul>
        <ul class="navbar-nav text-center">
            <li class="nav-item mr-2">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt mr-right-1"></i>Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
<nav aria-label="breadcrumb" class="col-11 mx-auto mt-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="pagePerso.html">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil</li>
    </ol>
</nav>

<div class="container-fluid">
    <div class="row col-11 mt-2  mx-auto " >
        <div class="forms-group bg-light p-4 mx-auto  " style="border-radius:10px;">
            <form method="post"  class="needs-validation" novalidate>
                <h4 class="text-center text-primary ">Changement de mot de passe (En maintenance)</h4>
                <div class="mx-auto col-11">
                    <div class="form-group mx-auto">
                            <label for="motDePasse" class="pl-0 col-form-label text-left container-fluid">Nouveau Mot de passe</label>
                            <input id="motDePasse"  type="password" class="form-control col-12" disabled/>
                            <div class="invalid-feedback">
                                Mot de passe invalid
                            </div>
                    </div>
                    <div class="form-group mx-auto">
                        <label for="confirmation" class="pl-0 col-form-label text-left container-fluid">Confirmer votre mot de passe</label>
                        <input id="confirmation"  type="password"  class="form-control col-12" disabled/>
                        <div class="invalid-feedback">
                            Mot de passe différents !!
                        </div>
                    </div>

                    <div class="form-group mx-auto hidden-before-send">
                        <label for="cleRecup" class="pl-0 col-form-label text-left container-fluid ">Clé de récupération</label>
                        <input id="cleRecup"  type="text" class="form-control col-12 " disabled/>
                    </div>
                    <p class="text-center pt-2 text-danger changeFail hidden-before-validate">Echec au changement du mot de passe</p>
                    <p class="text-center pt-2 text-danger changeSuccess hidden-before-validate">Mot de passe changé avec succés</p>
                    <div class="justify-content-center row mb-2 hidden-before-send">
                        <div class="btn btn-outline-success" id="validatePass" disabled>Valider</div>
                    </div>
                    <div class="justify-content-center row mb-2">
                        <button type="button" class="btn btn-outline-success" disabled id="sendPass">Envoyer</button>
                    </div>
                    </div>
            </form>
        </div>

    </div>



</div>


<div class="container">
    <br>
</div>



<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/validation.js"></script>
<script src="js/profil.js"></script>

</body>
</html>
