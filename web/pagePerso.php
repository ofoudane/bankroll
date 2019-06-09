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
    <title>Espace Perso</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <style>
        body{
            background-color:rgba(240,240,150,0.2);
        }
        .bg-canvas{
            background-color : rgba(255,255,255,0.5);
        }

        .half-border{
            border-width:3px !important;
        }
        .specialFormText{
            border-bottom:1px solid darkgrey;
            color:blueviolet;
        }
        .bankroll-info{
            border-bottom-width:5px !important;
            background-color:white;
        }


    </style>
</head>
<body data-spy="scroll" data-target=".internalMenu" data-offset="0">
<nav class="navbar navbar-expand-sm navbar-dark  bg-dark">
    <a class="navbar-brand" href="#">BankRoll</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuDeNavigation" aria-controls="menuDeNavigation" aria-expanded="false" >
        <span class="navbar-toggler-icon" data-toggle="tooltip" data-placement="left" title="affiche le menu"></span>
    </button>
    <div class="collapse navbar-collapse " id="menuDeNavigation">
        <ul class="navbar-nav mr-auto text-center">
            <a class="nav-link nav-item active" href="pagePerso.php" >espace-personnel</a>
            <a class="nav-link nav-item" href="Profil.php">profil</a>
            <a class="nav-link nav-item" href="myBankroll.php">Vos Bankroll</a>
            <a class="d-block d-sm-none nav-link nav-item mx-auto"><select class="availableBankroll form-control" style="width:135px">

            </select>
            </a>
        </ul>
        <ul class="navbar-nav text-center">
            <li class="nav-item mr-2">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt mr-right-1"></i>Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>

<nav class="navbar navbar-light d-none d-sm-flex  bg-light internalMenu" style="background-color: #e3f2fd !important; ">


    <ul class="nav nav-pills mx-auto">
        <li class="nav-item mr-3">
            <div class="input-group">
                <a class="nav-item nav-link" href="#actualBankroll">Bankroll</a>
                <select class="border border-success availableBankroll form-control ml-2" style="width:135px;border-radius:10px;">
                </select>
            </div>
        </li>
        <li class="nav-item dropdown d-none d-sm-block">
            <a class="nav-link " href="#statistiques">
                Statistiques
            </a>
        </li>
        <li class="nav-item dropdown  d-sm-block">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Paris
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#ajouterParis">Ajouter</a>
                <a class="dropdown-item" href="#parisGagnes">Gagnés</a>
                <a class="dropdown-item" href="#parisPerdus">Perdus</a>
                <a class="dropdown-item" href="#parisRembourses">Remboursé</a>
            </div>
        </li>

    </ul>
</nav>
<nav  class="navbar d-sm-none navbar-light bg-white internalMenu smallMenu" style="max-height:30px;">
    <ul class="nav nav-pills mx-auto">
        <li class="nav-item">
            <a class=" nav-link pt-0 pb-0 mt-1 mr-1 px-1" style="border-radius:5px ;border:3px solid #bbb" href="#actualBankroll">Bankroll</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-center pt-0 px-1 pb-0 mt-1 mr-1" style="border-radius:5px ;border:3px solid #bbb" href="#statistiques">Statistiques</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-center pt-0 px-1 pb-0 mt-1" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="border-radius:5px ;border:3px solid #bbb"  href="#paris" >Paris</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#ajouterParis">Ajouter</a>
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item" href="#parisGagnes">Gagnés</a>
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item" href="#parisPerdus">Perdus</a>
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item" href="#parisRembourses">Remboursés</a>
            </div>
        </li>
    </ul>
</nav>

<div class="container-fluid px-0  no-gutters" id="actualBankroll" >
    <div class="col-sm-11 col-10 mx-auto">
        <h2 class="border-bottom half-border text-center text-info mb-3 border-warning" >bankroll</h2>
        <div class="row">
            <div class="col-md-5 col-10 col-lg-4 mx-auto border-primary border bankroll-info rounded">
                <h2 class="text-success text-center mt-2"><span id="nombreDeParis">0</span></h2>
                <h3 class="text-center text-dark">Nombre de paris</h3>
            </div>
            <div class="d-block col-10 d-md-none"><br></div>
            <div class="col-md-5 col-10 col-lg-3 mx-auto border border-success bankroll-info rounded">
                <h2 class="text-center mt-2 text-success"><span id="soldeEnBankroll">0</span> &euro;</h2>
                <h3 class="text-center text-dark">Solde</h3>
            </div>

            <div class="d-block col-10 d-lg-none">
                <br>
            </div>
            <div class="col-md-5 col-lg-3 col-10 mx-auto border bankroll-info border-danger rounded">
                <h2 class="text-success text-center mt-2"><span id="beneficeBankroll">0</span> &euro;</h2>
                <h3 class="text-dark text-center">Bénéfice</h3>
            </div>
        </div>
        <div>
            <br>
        </div>
    </div>
</div>


<div class="container-fluid row  no-gutters border-top border-light" id="statistiques" >
    <div class="col-sm-11 col-11  mx-auto " >
        <h2 class="border-bottom half-border text-center text-info  border-warning" >Statistiques</h2>
        <div class=" mt-4 mb-4 row justify-content-around ">
            <div class="bg-white col-10 canvas-background  mx-auto col-md-5">
                <canvas id="Graph-Par-Nombre-Paris" >

                </canvas>
            </div>
            <div class="w-100 d-block d-md-none ">
                <br>
            </div>
            <div class="bg-white col-10 col-md-5 mx-auto" >
                <canvas id="Graph-Par-Montant" >
                </canvas>
            </div>
        </div>

        <div class="container-fluid mt-2 mx-auto col-sm-8 col-md-8 col-sm-11 " >
            <div class="owl-carousel owl-theme owl-Normal-carousel" >
                    <div class="item" >
                        <canvas class="bg-canvas d-block w-100" id="dailyStats"></canvas>
                    </div>
                    <div class="item">
                        <canvas class="bg-canvas d-block w-100" id="monthlyStats"></canvas>
                    </div>
                    <div class="item">
                        <canvas class="bg-canvas d-block w-100" id="yearlyStats"></canvas>
                    </div>
            </div>

        </div>
    </div>
</div>

<div class="container" id="paris">
    <div class="col-sm-11 col-11 mx-auto mt-2" >
        <h2 class="border-bottom col-11 mx-auto half-border text-center text-info  border-warning" >Paris</h2>
        <div class="owl-theme owl-carousel " id="ajouterParis">
            <div class="item" >
                <form class=" rounded border pt-2 pb-2 " id="directParisForm" >
                    <fieldset class="col-12 align-items-center">
                        <legend class="specialFormText">Paris par match</legend>
                        <div class="col-11 mx-auto mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Intitulé</div>
                                </div>
                                <input required type="text" class="form-control" name="nomParis" placeholder="Nom"/>
                            </div>
                        </div>
                        <div class="col-11 mx-auto mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                                </div>
                                <input type="text" value="" class="input-bankrollName text-center form-control" disabled required id="nomBank" />
                            </div>
                        </div>
                        <div class="row mx-auto">
                            <div class="col-md-5 col-11 mx-auto mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Mise</div>
                                    </div>
                                    <input required type="number" min="0"   class="form-control" name = "miseParis" placeholder="15"/>
                                    <div class="input-group-append">
                                        <div class="input-group-text">€</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-11 mx-auto mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Cote</div>
                                    </div>
                                    <input required type="text" class="form-control" name = "coteParis" placeholder="2.5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-11 mx-auto mb-2">
                            <div class="input-group">
                                <div class="input-group-preprend">
                                    <div class="input-group-text">Etat</div>
                                </div>
                                <select class="form-control col" name="etatBankroll" required >
                                    <option value="1">
                                        Gagné
                                    </option>
                                    <option value="0">
                                        Perdu
                                    </option>
                                    <option  value="2">
                                        Remboursé
                                    </option>
                                </select>
                            </div>
                            <p id="messageDirectParisInsert" class="pt-2 text-center"></p>
                            <div class="justify-content-center row pt-2 pb-2  ">
                                <button type="submit" class="btn mx-auto btn-outline-primary" >Ajouter</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="item"  >
                <form class=" rounded border pt-2 pb-2 " id="ajouterParisParMatch" >
                    <fieldset class="col-12 align-items-center">
                        <legend class="specialFormText">Paris Par Match</legend>
                        <div class="col-11 mx-auto mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Intitulé</div>
                                </div>
                                <input required type="text" class="form-control" id="nomParis" placeholder="Nom"/>
                            </div>
                        </div>
                        <div class="row mx-auto">
                            <div class="col-11 mx-auto col-md-5 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                                    </div>
                                    <input type="text" value="" class="input-bankrollName text-center form-control" disabled required id="nomBankr" />
                                </div>
                            </div>

                            <div class="col-md-5 col-11 mx-auto mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Mise</div>
                                    </div>
                                    <input required type="number" min="0" id="miseTotal"  class="form-control" placeholder="15"/>
                                    <div class="input-group-append">
                                        <div class="input-group-text">€</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-11 mx-auto mb-2">
                            <div class="input-group">
                                <div class="input-group-preprend">
                                    <div class="input-group-text">Type</div>
                                </div>
                                <select class="form-control col" id="typeParis" required >
                                    <option value="0">
                                        Normal
                                    </option>
                                    <option value="1">
                                        Combiné
                                    </option>
                                    <option  value="2">
                                        Multiple
                                    </option>
                                </select>
                            </div>
                        </div>
                        <fieldset>
                            <legend class="text-center text-warning">Definir les matchs</legend>
                            <div class="col-11 mx-auto mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Côte</div>
                                    </div>
                                    <input class="form-control" type="number" min="0" id="coteMatch" placeholder="x2,x3...?">
                                </div>
                            </div>
                            <div class="col-11 mx-auto mb-2">
                                <div class="input-group">
                                    <div class="input-group-preprend">
                                        <div class="input-group-text">Etat</div>
                                    </div>
                                    <select class="form-control col" id="etatMatch" required >
                                        <option value="1">
                                            Gagné
                                        </option>
                                        <option value="0">
                                            Perdu
                                        </option>
                                        <option  value="2">
                                            Remboursé
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-9 sol-sm-6 col-md-5 mx-auto mb-2">
                                <button class="form-control btn btn-outline-success" type="button" id="ajouterMatch">Ajouter Match</button>
                            </div>
                            <p id="messageAjoutMatch" class="text-center pt-2">

                            </p>

                        </fieldset>
                        <fieldset>
                            <legend class="text-center text-info">Matchs</legend>
                            <div class="col-sm-11 col-12 mx-auto mb-2">
                                <table class="table table-hover mx-auto mt-1 table-bordered table-dark text-dark bg-white text-dark">
                                    <thead class="text-center">
                                        <th>Côte</th>
                                        <th>Etat</th>
                                        <th>Supprimer</th>
                                    </thead>
                                    <tbody class="text-center " id="listeMatchAjoute">
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>

                    </fieldset>
                </form>
            </div>
        </div>
        <div class="container-fluid table-responsive">
            <table id="parisGagnes" class="text-center table table-hover responsive-table mx-auto mt-3 table-bordered table-dark text-dark bg-white text-dark">
                <thead >
                    <th class="text-center">Intitulé</th>
                    <th class="text-center">Mise</th>
                    <th class="text-center">Gain</th>
                    <th class="text-center ">Supprimer</th>
                </thead>
                <tbody id="WinTable">
                </tbody>
            </table>
        </div>
        <div class="container-fluid table-responsive">
            <table id="parisPerdus" class="table table-hover responsive-table table-bordered table-dark bg-white text-center text-dark">
                <thead >
                <th class="text-center">Intitulé</th>
                <th class="text-center">Mise</th>
                <th class="text-center">Raté</th>
                <th class="text-center">Supprimer</th>
                </thead>
                <tbody id="LoseTable">
                </tbody>
            </table>
        </div>
        <div class="container-fluid table-responsive">
            <table id="parisRembourses" class="text-center table table-hover table-bordered responsive-table table-dark bg-white text-dark">
                <thead>
                <th class="text-center ">Intitulé</th>
                <th class="text-center ">Mise</th>
                <th class="text-center ">Raté</th>
                <th class="text-center ">Supprimer</th>
                </thead>
                <tbody id="DrawTable">

                </tbody>
            </table>
        </div>
        <div >
            <br>
        </div>
    </div>

</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Etes vous sûr de bien vouloir supprimer ce paris?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="validationSuppression">Oui</button>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>


<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
<script src="js/dashboard.js"></script>
</body>
</html>