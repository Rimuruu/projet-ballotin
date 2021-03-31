<?php
include '../../controller/vote.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
    header("Location: ../../index.php");
  }
$vote = getVote($_POST['id']);
$nonvotants = count($vote['votants']);
if($vote['owner'] != $_SESSION["mail"]) header("Location: ../../index.php");
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
            <th>Reponse</th>
            <th>Votant</th>
           

          </tr>
        </thead>
        <tbody>

<?php
    foreach ($vote['reponses'] as $reponse) {
            echo "<tr>";
            echo "<td><label>".$reponse["reponse"] . "</label></td> <td><label>".count($reponse["votant"]) . "</label></td>";
           
            echo "</tr>";
            $nonvotants -= count($reponse["votant"]);
          }
          echo "<tr>";
            echo "<td><label>Non votant </label></td> <td><label>".$nonvotants . "</label></td>";
           
            echo "</tr>";

            
?>
        </tbody>
    </table>
    <?php if($vote["status"]=="going") echo "<form  action='./closeVote.php' method='POST'><button name='id' value='".$vote["id"]."' type='submit'>Fermer le vote</button></form>";
          if($vote["status"]=="close") echo "<form  action='./deleteVote.php' method='POST'><button name='id' value='".$vote["id"]."' type='submit'>Supprimer le vote</button></form>";
    ?>
    </div>



  </div>


</body>
<script>

</script>

</html>