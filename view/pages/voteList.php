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
      <div><?php echo "Connecté : " . $_SESSION["mail"]; ?> <a href="./home.php">Home</a><a href="./disconnect.php">Se deconnecter</a></div>
      <table>
        <thead>
          <tr>
            <th>Question</th>
            <th>Date</th>
           

          </tr>
        </thead>
        <tbody>
          <?php

          foreach ($votes as $vote) {
            echo "<tr>";
            echo "<td><label>".$vote["question"] . "</label></td>  <td><label> " . $vote["date"]["mday"] . "/" . $vote["date"]["mon"]."</label></td>";
            echo "<td><form  action='./vote.php' method='POST'><button name='id' value='".$vote["id"]."' type='submit'>Voter</button></form></td>";
            echo "</tr>";
          }



          ?>

        </tbody>
      </table>
    </div>



  </div>


</body>
<script>

</script>

</html>