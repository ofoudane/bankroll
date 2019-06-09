<?php
    session_start();
	if(isset($_SESSION['e-mail']) && isset($_SESSION['sessionId']))
		header('Location: pagePerso.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Une Bankroll">
    <meta name="author" content="Omar FOUDANE" >
    <title>Bankroll</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <style>
        body{
            background-image: url("images/Background.jpg");
            -webkit-background-size: cover;
            background-size: cover;
        }
        .reduced-opacity{
            background-color:rgba(1, 24, 38, 0.85);
        }
        .reduced-opacity > * {
            opacity: 1 !important;
        }
    </style>
<body>
    <h1 class="  reduced-opacity text-center text-white">
       <i class="fab fa-btc"></i>  Bankroll
    </h1>
<div class="container-fluid mt-4 mb-4" style="max-height:400px;max-width:400px;">
    <div class="row col-11 mx-auto  reduced-opacity border pt-2 rounded">
        <div class="owl-carousel owl-theme">
            <div class="item" data-hash="login">
                <div class="row justify-content-center pt-2">
                    <a href="#login"><button type="button" class="btn  btn-outline-primary active">
                        Se connecter
                    </button></a>
                    <a href="#register"><button type="button" class="offset-1 btn  btn-outline-danger">
                        S'inscrire
                    </button></a>
                </div>

                <form class="mx-auto py-2 " id="loginForm" method="post" >
                    <img src="images/ball.png" class="image rounded-circle mx-auto" style="max-height:100px;max-width:100px" alt="person">
                    <div class="form-group col-11 pt-4 mx-auto">
                        <div class="input-group">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <input type="email" class="form-control" name="adresse_mail" placeholder="mail@mail.com" required>
                        </div>
                    </div>

                    <div class="form-group col-11 pt-4 mx-auto">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="password" class="form-control" name="mot_de_passe" placeholder="Mot de passe" required>
                        </div>
                    </div>
                    <div class="container col-11 pt-2 mx-auto row justify-content-center">
                        <button class="btn btn-outline-warning mx-auto" name="submit" type="submit">Se connecter</button>
                    </div>
                    <p class="mt-4 text-center"><a class="text-white" data-toggle="modal" data-target="#forgotPassword" href="#">Vous avez oublié votre mot de passe ?</a></p>
                    <p class="mt-2 text-center text-warning" id="loginMessage">
                    </p>
                </form>

            </div>
            <div class="item" data-hash="register">
                <div class="row justify-content-center pt-2">
                    <a href="#login">
                        <button type="button" class="btn  btn-outline-primary ">
                            Se connecter
                        </button>
                    </a>
                    <a href="#register">
                        <button type="button" class="offset-1 btn  btn-outline-danger active">
                            S'inscrire
                        </button>
                    </a>
                </div>

                <div class="mx-auto py-2" >
                  <form id="registerForm" class="mx-auto py-2 " method="post">
                    <img src="images/ball.png" class="image rounded-circle mx-auto" style="max-height:100px;max-width:100px" alt="person">

                    <div class="form-group col-11 pt-2 mx-auto">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </div>
                            </div>
                            <input type="text" required name="nom" class="form-control" placeholder="Nom">
                        </div>
                    </div>
                    <div class="form-group col-11 pt-2 mx-auto">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </div>
                            </div>
                            <input type="text" required name="prenom" class="form-control" placeholder="Prenom">
                        </div>
                    </div>

                    <div class="form-group col-11 pt-2 mx-auto">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <input type="email" class="form-control" name="mail" placeholder="mail@mail.com" required>
                        </div>
                    </div>

                    <div class="form-group col-11 pt-2 mx-auto">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="password" class="form-control" name="mot_de_passe" placeholder="Mot de passe" required>
                        </div>

                    </div>
                    <div class="container col-11 pt-2 mx-auto row justify-content-center">
                        <button class="btn btn-outline-warning mx-auto" name="submit" type="submit">S'inscrire</button>
                    </div>
                    <p class="text-warning text-center pt-2" id="registerMessage">
                    </p>
                </form>

            </div>

        </div>
    </div>

        <div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="mot de passe oublié" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mot de passe oublié (En maintenance)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Saisissez votre adresse mail</p>
                        <div class="input-group">
                            <input type="email" disabled class="form-control" id="mail" placeholder="email">
                            <div class="valid-feedback">
                                Message envoyé à votre mail 
                            </div>
                            <div class="invalid-feedback">
                                Opération échouée
                            </div>
                        </div>
                        <p class="hiddenBeforeSend pt-2">Saisissez votre code de validation </p>
                        <input type="text" class="form-control hiddenBeforeSend" id="recoverKey" disabled placeholder="clé de validation">
                        <div class="hiddenBeforeValid">
                            
                        </div>
                    </div>
                    <div class="modal-footer" id="envoyerMessage">
                        <button type="button" class="btn btn-outline-danger " data-dismiss="" id="envoyer" disabled>Envoyer</button>
                        <button type="button" class="btn btn-outline-danger hiddenBeforeSend" data-dismiss="modal" id="valider">Valider</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="mt-2 col-12">

</div>

<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/index.js"></script>
</body>
</html>
