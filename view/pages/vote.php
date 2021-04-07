<?php
include '../../controller/vote.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
    header("Location: ../../index.php");
}
$vote = getVote($_POST['id']);
$isVotant = $result2 = array_search(
    $_SESSION["mail"],
    array_column($vote["votants"], 'votant')
);
if ($isVotant === false) header("Location: ../../index.php");
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
            <?php echo   "<h2> Vous avez " . ($vote["votants"][$isVotant]["votePossibility"]>0?$vote["votants"][$isVotant]["votePossibility"] - 1:0) . " procuration </h2>" ?>
            <form action="./setVote.php" method="post">
            <?php  echo '<input type="hidden" name="id" value="'.$_POST['id'].'">'; ?>
                <table>
                    <thead>
                        <tr>
                            <th columnspan="2">Réponses</th>



                        </tr>
                    </thead>
                    <tbody>


                        <?php
                        foreach ($vote['reponses'] as $reponse) {
                            echo "<tr>";
                            echo "<td><label>" . $reponse["reponse"] . "</label></td> <td><input  class='form-check-input' type='radio' name='reponse' value='" . $reponse["reponse"] . "' required ></td>";
                            echo "</tr>";
                        };


                        ?>

                    </tbody>
                </table>
                <?php
                if (isset($_POST["result"])) {
                    if ($_POST["result"]) {
                        echo "<label>Vote envoyé</label>";
                        if ($vote["votants"][$isVotant]["votePossibility"] > 0) echo "<label>Il vous reste " . $vote["votants"][$isVotant]["votePossibility"] . " vote</label>";
                    } else {
                        echo "<label>".$_POST["result"]."</label>";
                    }
                }


                ?>
                <?php if($vote["status"] =="going") {
                    if($vote["votants"][$isVotant]["votePossibility"]>0) echo "<button class='btn btn-primary' type='submit'>Voter</button>";
                    else echo "<label>Vous avez déjà voté</label>";
                }
                      else { echo "<label>Le vote est fermé</label>";
                        echo '<div class="border rounded" id="chartContainer" style="height: 370px; width: 100%;"></div>';

                      }
                
                ?>
            </form>
        </div>



    </div>


</body>
<script src="./canvasJS/canvasjs.min.js"></script>
<script>
  var vote = <?php echo json_encode($vote) ?>;
  var CanvasJS = CanvasJS;
  var data = vote.reponses.map(x => {
    let obj = {
      'y': x.votant.length,
      'label': x.reponse
    }
    return obj
  });
  var nonvotant = {'y': vote.votants.length - data.reduce((acc,obj)=> acc+obj.y,0),'label':'Non votant'};
  data.push(nonvotant);
  window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	exportEnabled: false,
	animationEnabled: true,
	title: {
		text: vote.question
	},
	data: [{
		type: "pie",
		startAngle: 25,
		toolTipContent: "<b>{label}</b>: {y}",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}",
		dataPoints: data
	}]
});
chart.render();

}

</script>

</html>