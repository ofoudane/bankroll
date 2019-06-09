<?php
require_once "../Verification/verifieSession.php";
global $db;
if(VALID){
    $sum = 0;
    $nom = pg_escape_string($_POST['nom']);
    $etat = 2 ;

    $requete = "select * from getParisParEtat('$nom',$etat,'".MAIL."','".SESSIONID."')";
    $result = $db->prepare($requete);
    $result->execute();

    if($result->rowCount() == 0 ){
        $answer = "<tr class='text-center table-warning' ><td colspan='4'>Vous n'avez aucun paris remboursé</td> </tr>";
    }
    else{
        $answer = "";
        while($row = $result->fetch(PDO::FETCH_BOTH)){
            $answer = $answer . "<tr class='table-info'>
                                   <td>$row[1]</td>
                                   <td>$row[2]</td>
                                   <td>$row[3]</td>
                                   <td><button type=\"button\" class=\"btn btn-outline-danger border-0 deleteParis\" data-toggle=\"modal\" data-target=\"#deleteModal\" id='$row[0]'><i class=\"far fa-trash-alt\"></i></button></td>
                                </tr>";
            $sum += $row[2];
        }
        $answer = $answer . "<tr class=\"table-secondary\">
                                <td colspan=\"2\" class=\"text-center border border-dark\">Total Remboursé</td>
                                <td colspan=\"2\" class=\"text-center border border-dark\">$sum &euro; </td>
                            </tr>";
    }
    $result->closeCursor();
    echo $answer;
}
