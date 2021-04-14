<?php
include  dirname(__FILE__).'/../../controller/account.php';
include  dirname(__FILE__).'/../../controller/vote.php';
ob_start();
session_start();
$str = "";
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"])&& isLog($_SESSION["mail"],$_SESSION["mdp"]))) {
    $str .= "403 FORBIDDEN";
    ob_end_clean();
    echo json_encode(["string"=>$str,"data"=>null]);
} else {
    $vote = getVote($_GET['vote']);
    $nonvotants = countVotePossibility($vote["votants"]);
    if ($vote['owner'] != $_SESSION["mail"]) {
        $str .= "403 FORBIDDEN";
        ob_end_clean();
        echo json_encode(["string"=>$str,"data"=>null]);
    } else {
        $Allvotant = 0;
        $Abstention = 0;
        foreach ($vote["votants"]as$votant) {
            $Allvotant += intval($votant["votePossibility"]);
            $Abstention += intval($votant["votePossibility"]);
        }
        foreach ($vote["reponses"]as$reponse) {
            $Allvotant += count($reponse["votant"]);
        }
        $str .= '<div class="container p-4"><p>Le taux de participation est de '.number_format((100-($Abstention*100/$Allvotant)),2).'%</p></div> ';
        if ($vote["status"] == "close") {
            $str .= '<div class="container p-4">
        <div class="row">
          <div class="col"><label class="fw-bold">Réponses</label></div>
          <div class="col"><label class="fw-bold">Votants</label></div>
        </div>

';
       
            foreach ($vote['reponses'] as $reponse) {
                $str .= "<div class='row'>";
                $str .= "<div class='col'><label>" . $reponse["reponse"] . "</label></div> <div class='col'><label>" . count($reponse["votant"]) . "</label></div>";

                $str .= "</div>";
            }
            $str .= "<div class='row'>";
            $str .= "<div class='col'><label>Non votant </label></div> <div class='col'><label>" . $nonvotants . "</label></div>";

            $str .= "</div></div>";
        }

        if ($vote["status"] == "going") {
            $str .= "<div  class='container-fluid text-center m-4' ><button class='btn btn-info m-2' onClick='return relance(" . $vote["id"] . ")' name='id'>Relancer les votants</button><button class='btn btn-danger m-2' onClick='return closeVote(" . $vote["id"] . ")' name='id' value='" . $vote["id"] . "' type='submit'>Fermer le vote</button></div>";
        }
        if ($vote["status"] == "close") {
            $str .= '<div class="border rounded" id="chartContainer" style="height: 370px; width: 100%;"></div>';
            $str .= "<div class='container-fluid text-center m-4' ><button class='btn btn-danger m-2'  name='id' onClick='return supprimerVote(" . $vote["id"] . ")' value='" . $vote["id"] . "' type='submit'>Supprimer le vote</button></form>";
        }

       

        $str .='</div>';
        ob_end_clean();
        echo json_encode(["string"=>$str,"data"=>$vote]);
    }
}
