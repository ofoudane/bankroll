<?php
    session_start();
    if( !isset($_SESSION['e-mail']) || !isset($_SESSION['sessionId'])) 
        header('Location: index.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Une Bankroll">
    <meta name="author" content="Omar Foudane">
    <title>Mes Bankroll</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <style>
        body{
            background-image:url("images/backgroundBank.jpg");
            -webkit-background-size: cover;
            background-size: cover;
        }
        .forms-group{
            background-color:rgba(220, 234, 227, 0.68);
            border-radius:10px;
        }
        .limited-Width{
            max-width:400px;
        }
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
            <a class="nav-link nav-item" href="Profil.php">profil</a>
            <a class="nav-link nav-item active" href="myBankroll.php">Vos Bankroll</a>
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
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Bankroll</li>
    </ol>
</nav>

<div class="container-fluid">
    <div class="row col-11 mt-2 py-2 mx-auto ">
        <div class="owl-carousel owl-theme forms-group py-3 mx-auto limited-Width">
            <div class="item" data-hash="insert">
                <div class="container-fluid ">
                    <form class="needs-validation"  id="createBankroll" novalidate>
                        <h4 class="text-center text-danger">Créer une bankroll</h4>
                        <h1 class="col-8 mx-auto display-1 text-center"><i class="far fa-plus-square"></i></h1>
                        <div class="pt-2 form-group col-11 mx-auto">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                </div>
                                <input type="text" minlength="3" placeholder="Nom" id="nomBankroll" name="nomBank" class="form-control" required/>
                                <div class="invalid-feedback" id="messageNomBankroll">
                                    Le nom doit être renseigné et sa longueur supérieur à 3
                                </div>
                                <div class="valid-feedback">
                                    Ce nom est valide.
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-11 mx-auto">
                            <div class="input-group mt-2 ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </div>
                                </div>
                                <input type="number" min="0" id="solde_depart" name="soldeDepart" required placeholder="Solde de départ" class="form-control">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-euro-sign"></i>
                                    </div>
                                </div>
                                <div class="valid-feedback">
                                    Montant Valid
                                </div>
                                <div class="invalid-feedback" id="validationMontant">
                                    Entrez un nombre positif
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 pb-2 text-center col-11 mx-auto" id="messageSuccessCreation">
                            <p class="text-white">Bankroll créé avec succés</p>
                        </div>

                        <div class="container-fluid col-11 mx-auto row justify-content-center">
                            <button class="btn btn-primary mx-auto" type="submit">
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="item" data-hash="cash-out">
                <div class="container-fluid ">
                    <form class="needs-validation" id="cash-outBankroll" novalidate>
                        <h4 class="text-center text-danger">Tirer de l'argent</h4>
                        <h1 class="display-1 text-center col-8 mx-auto"><i class="fas fa-briefcase"></i></h1>
                        <div class="pt-2 form-group col-11 mx-auto">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                </div>
                                <input type="text" placeholder="Nom" name="nomBank" id="nomBankrollCash-Out" class="form-control" required/>
                                <div class="valid-feedback">
                                    Bankroll valide
                                </div>
                                <div class="invalid-feedback" id="messageNomBankrollCash-Out">
                                    Bankroll inexistante
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-11 mx-auto">
                            <div class="input-group mt-2 ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </div>
                                </div>
                                <input type="number" min="0" id="montantCash-Out" required name = "montant" placeholder="Montant" class="form-control">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-euro-sign"></i>
                                    </div>
                                </div>
                                <div class="valid-feedback" >
                                    Montant Valid
                                </div>
                                <div class="invalid-feedback" id="ValidationMontantCash-Out">

                                </div>
                            </div>
                        </div>

                        <div class="pt-2 pb-2 text-center col-11 mx-auto" id="messageSuccessCashout">
                            <p class="text-white">Montant retiré avec succés</p>
                        </div>

                        <div class="container-fluid col-11 mx-auto row justify-content-center">
                            <button class="btn btn-primary mx-auto" type="submit">
                                Retirer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="item" data-hash="add">
                <div class="container-fluid ">
                    <form class="needs-validation" id="addMoneyBankroll" method="post" novalidate>
                        <h4 class="text-center text-danger">Ajouter de l'argent</h4>
                        <h1 class="col-8 display-1 text-center mx-auto"><i class="fas fa-cart-plus"></i></h1>
                        <div class="pt-2 form-group col-11 mx-auto">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                </div>
                                <input type="text" placeholder="Nom" name="nomBank" id="nomBankroll-AddMoney" class="form-control" required/>
                                <div class="invalid-feedback">
                                    Cette bankroll est inexistante
                                </div>
                                <div class="valid-feedback" id="messageNomBankrollAddMoney">
                                    Cette bankroll existe
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-11 mx-auto">
                            <div class="input-group mt-2 ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </div>
                                </div>
                                <input type="number" min="0" step="5" name="montant" id="montant-AddMoney" required placeholder="Montant" class="form-control">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-euro-sign"></i>
                                    </div>
                                </div>
                                <div class="valid-feedback">
                                    Montant valid
                                </div>
                                <div class="invalid-feedback" id="validationMontantAddMoney">
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 pb-2 text-center col-11 mx-auto" id="messageSuccessAddMoney">
                            <p class="text-white">Montant ajouté avec succés</p>
                        </div>

                        <div class="container-fluid col-11 mx-auto row justify-content-center">
                            <button class="btn btn-primary mx-auto" type="submit">
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-4 ">
            <h4 class="text-center text-danger d-block mb-4">Liste des Bankrolls</h4>
            <div class="table-responsive ">
                <table class="table table-bordered table-hover bg-dark text-center">
                    <thead class="bg-white">
                        <th>Nom</th>
                        <th>Solde</th>
                        <th>ROI</th>
                        <th></th>
                    </thead>
                    <tbody id="bankroll-table">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container-fluid mx-auto">

        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Supprimer Bankroll" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Etes vous sûr de bien vouloir supprimer cette bankroll</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" onclick="supprimerBankroll()" data-dismiss="modal">Oui</button>
                    <button type="button" class="btn btn-outline-primary " data-dismiss="modal">Non</button>
                </div>
            </div>
        </div>
    </div>


</div>


<div class="container">
    <br>
</div>



<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/validation.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/bankroll.js"></script>

</body>
</html>
