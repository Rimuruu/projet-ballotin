<?php
include '../../controller/vote.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
  header("Location: ../../index.php");
}
$votes = getVotesFromVotant($_SESSION["mail"]);


?>

<html lang="fr">

<head>
  <meta charset="utf-8">

  <title>Projet Ballotin</title>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/styles.css">
</head>

<body>
<div class="h-100 container-fluid bg-dark">
    <div class="container bg-light">
    <nav class="navbar  navbar-light bg-light">
        <a class="navbar-brand" href="#"><?php echo $_SESSION["mail"] ?> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="./home.php">Home </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./voteList.php">Voter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./manageList.php">Gérer un vote</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./create.php">Créer un vote</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./disconnect.php">Se deconnecter</a>
            </li>

            
        </div>
      </nav>
      <div class='container-fluid p-2'>
          <div class="row">
          <div class="col">
          <h3>Nom du vote</h3>
          
          </div>
          <div class="col">
          <h3>Date</h3>
          
          </div>
          <div class="col">
          <h3>Voter</h3>
          
          </div>
          </div>
          <?php

          foreach ($votes as $vote) {
            echo "<div class='row m-3 '>";
            echo "<div class='col'><label>".$vote["question"] . "</label></div>  <div class='col'><label> " . $vote["date"]["mday"] . "/" . $vote["date"]["mon"]."</label></div>";
            echo "<div class='col'><form  action='./vote.php' method='POST'><button name='id' class='btn btn-secondary' value='".$vote["id"]."' type='submit'>Voter</button></form></div>";
            echo "</div>";
          }



          ?>
          </div>

    </div>



  </div>


</body>
<script>

</script>

</html>