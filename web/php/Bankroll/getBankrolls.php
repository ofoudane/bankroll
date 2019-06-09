<?php
require_once '../Verification/verifieSession.php';
global $db;
if(VALID){

    $requete = "select * from getBankrolls('".MAIL."','".SESSIONID."')";
    $result = $db->prepare($requete);
    $result->execute();
    if($result->rowCount() > 0)
        $elements = "";
    else
        $elements = "<tr class='table-warning'>
                        <td colspan='5' >Vous n'avez pas encore crée de bankroll</td>
                      </tr>";
    
    while($row = $result->fetch(PDO::FETCH_BOTH)){
        $ROI = $row[2]/$row[3];
        $ROI = $ROI * 100;
        if($ROI < 100)
            $class = "table-danger";
        else if($ROI > 100)
            $class = "table-success";
        else
            $class = "table-info";

        $ROI = round($ROI,2);

        $elements = $elements . "<tr class='$class'>
                                    <td class='align-middle'>$row[1]</td>
                                    <td class='align-middle'>$row[2]</td>
                                    <td class='align-middle'>$ROI%</td>
                                    <td>
                                        <button type=\"button\" class=\"btn delete-btn btn-outline-danger border-0\" id='$row[0]' data-toggle=\"modal\" data-target=\"#deleteModal\"><i class=\"far fa-trash-alt\"></i></button>
                                    </td>
                                   </tr>";

    }

    $result->closeCursor();
    echo $elements;
}