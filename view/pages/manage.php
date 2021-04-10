<?php
include '../../controller/vote.php';
ob_start();
session_start();
$str = "";
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {

  $str .= "403 FORBIDDEN";
  ob_end_clean();
  echo json_encode(["string"=>$str,"data"=>NULL]);
}
else{
$vote = getVote($_GET['vote']);
$nonvotants = countVotePossibility($vote["votants"]);
if ($vote['owner'] != $_SESSION["mail"]) {

  $str .= "403 FORBIDDEN";
  ob_end_clean();
  echo json_encode(["string"=>$str,"data"=>NULL]);
}
else {
 
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

        $str .= "</div>";


        if ($vote["status"] == "going") {
          $str .= "<div  class='container-fluid text-center m-4' ><button class='btn btn-danger m-2' onClick='return closeVote(" . $vote["id"] . ")' name='id' value='" . $vote["id"] . "' type='submit'>Fermer le vote</button></div>";
        }
        if ($vote["status"] == "close") {
          $str .= '<div class="border rounded" id="chartContainer" style="height: 370px; width: 100%;"></div>';
          $str .= "<div class='container-fluid text-center m-4' ><button class='btn btn-danger m-2'  name='id' onClick='return supprimerVote(" . $vote["id"] . ")' value='" . $vote["id"] . "' type='submit'>Supprimer le vote</button></form>";
        }

       

        $str .='</div></div>';
        ob_end_clean();
        echo json_encode(["string"=>$str,"data"=>$vote]);
   
    
}

}

?>