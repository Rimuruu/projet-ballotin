<?php include dirname(__FILE__).'/../../controller/vote.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
  echo "403 FORBIDDEN";
}
else{
$votes = getVotesFromVotant($_SESSION["mail"]);



        echo '<div class="container-fluid p-2">
        <div class="row">
          <div class="col text-center">
            <h3>Nom du vote</h3>

          </div>
          <div class="col text-center">
            <h3>Date</h3>

          </div>
          <div class="col text-center">
            <h3>Voter</h3>

          </div>
        </div>';
    
        foreach ($votes as $vote) {
          echo "<div class='row m-3 '>";
          echo "<div class='col text-center'><label>" . $vote["question"] . "</label></div>  <div class='col text-center'><label> " . $vote["date"]["mday"] . "/" . $vote["date"]["mon"] . "</label></div>";
          echo "<div class='col text-center'><button name='id' class='btn btn-secondary'  onClick='return vote(".$vote["id"].")' value='" . $vote["id"] . "' >Voter</button></div>";
          echo "</div>";
        }



      echo '</div>'; }
      
      
      
      ?>







