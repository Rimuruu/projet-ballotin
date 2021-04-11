<?php



function homePages(){
  
}

function getManage(){
    $vote = getVote($_GET['id']);
    $nonvotants = count($vote['votants']);
    echo '<div class="container p-4">
        <div class="row">
          <div class="col"><label class="fw-bold">Réponses</label></div>
          <div class="col"><label class="fw-bold">Votants</label></div>
        </div>';



        foreach ($vote['reponses'] as $reponse) {
          echo "<div class='row'>";
          echo "<div class='col'><label>" . $reponse["reponse"] . "</label></div> <div class='col'><label>" . count($reponse["votant"]) . "</label></div>";

          echo "</div>";
          $nonvotants -= count($reponse["votant"]);
        }
        echo "<div class='row'>";
        echo "<div class='col'><label>Non votant </label></div> <div class='col'><label>" . $nonvotants . "</label></div>";

        echo "</div>";


     

       if ($vote["status"] == "going") echo "<form  class='container-fluid text-center m-4' action='./closeVote.php' method='POST'><button class='btn btn-danger m-2' name='id' value='" . $vote["id"] . "' type='submit'>Fermer le vote</button></form>";
        if ($vote["status"] == "close") {
          echo '<div class="border rounded" id="chartContainer" style="height: 370px; width: 100%;"></div>';
          echo "<form class='container-fluid text-center m-4' action='./deleteVote.php' method='POST'><button class='btn btn-danger m-2'  name='id' value='" . $vote["id"] . "' type='submit'>Supprimer le vote</button></form>";
        }

      

      echo '</div>';
}

function getCreate(){
    
}


function disconnect(){
    session_start();
    session_destroy();
    session_unset();
}


if(isset($_GET["disconnect"])){
    disconnect();
}
else if(isset($_GET["home"])){
    homePages();
}
else if(isset($_GET["create"])){
    getCreate();
}
