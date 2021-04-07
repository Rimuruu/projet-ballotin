<?php
include '../../controller/vote.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
  header("Location: ../../index.php");
}
$vote = getVote($_POST['id']);
$nonvotants = count($vote['votants']);
if ($vote['owner'] != $_SESSION["mail"]) header("Location: ../../index.php");
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
      <div class="container p-4">
        <div class='row'>
          <div class='col'><label class="fw-bold">Réponses</label></div>
          <div class='col'><label class="fw-bold">Votants</label></div>
        </div>


        <?php
        foreach ($vote['reponses'] as $reponse) {
          echo "<div class='row'>";
          echo "<div class='col'><label>" . $reponse["reponse"] . "</label></div> <div class='col'><label>" . count($reponse["votant"]) . "</label></div>";

          echo "</div>";
          $nonvotants -= count($reponse["votant"]);
        }
        echo "<div class='row'>";
        echo "<div class='col'><label>Non votant </label></div> <div class='col'><label>" . $nonvotants . "</label></div>";

        echo "</div>";


        ?>

        <?php if ($vote["status"] == "going") echo "<form  class='container-fluid text-center m-4' action='./closeVote.php' method='POST'><button class='btn btn-danger m-2' name='id' value='" . $vote["id"] . "' type='submit'>Fermer le vote</button></form>";
        if ($vote["status"] == "close") 
        {
          echo '<div class="border rounded" id="chartContainer" style="height: 370px; width: 100%;"></div>';
          echo "<form class='container-fluid text-center m-4' action='./deleteVote.php' method='POST'><button class='btn btn-danger m-2'  name='id' value='" . $vote["id"] . "' type='submit'>Supprimer le vote</button></form>";
        }
        
        ?>
      
      </div>
    </div>
    



  </div>


</body>
<script src="./canvasJS/canvasjs.min.js"></script>
<script>
  var vote = <?php echo json_encode($vote) ?>;
  var CanvasJS = CanvasJS;
  var data = vote.reponses.map(x => {
    let obj = {
      'y': (x.votant.length*100)/vote.votants.length,
      'label': x.reponse
    }
    return obj
  });
  var nonvotant = {'y': ((vote.votants.length - vote.reponses.reduce((acc,obj)=> acc+obj.votant.length,0))*100)/vote.votants.length,'label':'Non votant'};
  data.push(nonvotant);
  window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2", 
	exportEnabled: false,
	animationEnabled: true,
	title: {
		text: vote.question
	},
	data: [{
		type: "pie",
		startAngle: 25,
		toolTipContent: "<b>{label}</b>: {y}%",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}%",
		dataPoints: data
	}]
});
chart.render();

}

</script>

</html>