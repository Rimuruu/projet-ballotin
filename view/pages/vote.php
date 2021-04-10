<?php 

include '../../controller/vote.php';
ob_start();
$str = "";
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
    $str .= "403 FORBIDDEN";
    ob_end_clean();
    echo json_encode(["string"=>$str,"data"=>NULL]);
}
else {
$vote = getVote($_GET['vote']);
$isVotant = $result2 = array_search(
    $_SESSION["mail"],
    array_column($vote["votants"], 'votant')
);
if ($isVotant === false){ 
    $str .= "403 FORBIDDEN";
    ob_end_clean();
    echo json_encode(["string"=>$str,"data"=>NULL]);

}
else {
    if($vote["status"]=="going" && $vote["votants"][$isVotant]["votePossibility"]>0){
    $str .=   "<h2> Vous avez " . $vote["votants"][$isVotant]["votePossibility"] ." ".($vote["votants"][$isVotant]["votePossibility"]>1?"votes":"  vote")." </h2>";

    $str .= '<input type="hidden" name="id" value="'.$_GET['vote'].'">'; 

    $str .='<table>
                    <thead>
                        <tr>
                            <th columnspan="2">Réponses</th>
                        </tr>
                    </thead>
                    <tbody>';


           
                        foreach ($vote['reponses'] as $reponse) {
                            $str .= "<tr>";
                            $str .= "<td><label>" . $reponse["reponse"] . "</label></td> <td><input  class='form-check-input rep' type='radio' name='reponse' value='" . $reponse["reponse"] . "' required ></td>";
                            $str .= "</tr>";
                        };


                  

                        $str .= '</tbody>
                </table>';
                    }
     
                if (isset($_GET["result"])) {
                    if ($_GET["result"]) {
                        $str .= "<label>Vote envoyé</label>";
                    } else {
                        $str .= "<label>".$_GET["result"]."</label>";
                    }
                }


       
               if($vote["status"] =="going") {
                    if($vote["votants"][$isVotant]["votePossibility"]>0) $str .= "<button onClick='return voteSend(".$_GET['vote'].")' class='btn btn-primary' >Voter</button>";
                    else $str .= "<p>Vous avez déjà voté. Les résultats seront affichés lorsque le vote sera clos.</p>";
                }
                      else { $str .= "<label>Le vote est terminé</label>";
                        $str .= '<div class="border rounded" id="chartContainer" style="height: 370px; width: 100%;"></div>';

                      }
                      ob_end_clean();
                      echo json_encode(["string"=>$str,"data"=>$vote]);

}
}


?>