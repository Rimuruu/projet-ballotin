<?php
session_start();
if(!(isset( $_SESSION["mail"])&&isset( $_SESSION["mdp"]))){
  header("Location: ../../index.php");
}

?>

<html lang="fr">

<head>
  <meta charset="utf-8">

  <title>Projet Ballotin</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../../css/styles.css">
  <style>
    .ligne {
      display: block;
      margin-bottom: 10px;
    }

    label {
      display: block;
      width: 250px;
    }

    button {
      height: 50px;
    }

    .erreur {
      color: red;
    }
  </style>
</head>

<body>
  <div class="body">
    <div class="container-login">

    <div><?php echo "Connecté : ".$_SESSION["mail"]?> <a href="./disconnect.php">Se deconnecter</a></div>
    <a href="./voteList.php">Voter</a>
    <a href="./create.php">Créer un vote</a>
    <a href="./manageList.php">Gérer un vote</a>
    </div>



  </div>


</body>
<script>

</script>

</html>