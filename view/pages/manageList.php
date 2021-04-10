<?php
include '../../controller/vote.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
  echo "403 FORBIDDEN";
}
else{

$votes = getVotes($_SESSION["mail"]);
echo '<div class="container p-3 border">
        <div class="row">

          <div class="col text-center">
            <h3>Question</h3>
          </div>
          <div class="col text-center">
            <h3>Date</h3>
          </div>
          <div class="col text-center">
            <h3>Gérer</h3>
          </div>


        </div>';

    

        foreach ($votes as $vote) {
          echo "<div class='row p-3 '>";
          echo "<div class='col text-center'><label class='form-label d-block mx-auto col col-m-auto'>" . $vote["question"] . "</label></div>  <div class='col text-center'><label> " . $vote["date"]["mday"] . "/" . $vote["date"]["mon"] . "</label></div>";
          echo "<div class='col text-center'><button name='id' class='btn btn-secondary' onClick='return manage(".$vote["id"].")' value='" . $vote["id"] . "' >Manage</button></div>";
          echo "</div>";
        }





      echo '</div>';

    }

      ?>