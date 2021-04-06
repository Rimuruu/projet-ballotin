<?php
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
  header("Location: ../../index.php");
}

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
      <div class="container m-2">
      <div class="ligne row m-2"><label class="col-sm-3 form-label">Question</label> <input class="col form-control" id="question" type="text" /></div>
      <div class="responses">
        <div class="response row m-2"><label class="col-sm-3 form-label"> Response 1</label> <input class="col form-control" id="reponse1" type="text" /></div>
      </div>
      <div class="container m-2 row">
      <button class="btn btn-secondary col m-2"  onclick="appendResponse()">Ajouter une réponse</button>
      <button class="btn btn-secondary col m-2"  onclick="removeResponse()">Enlever une réponse</button>
      </div>

      <div class="votants container">
        <div class="votant m-2 row align-items-start justify-content-evenly"><div class="col row my-auto"><label class="form-label col-sm-3 my-auto" >Votants 1</label> <input class="form-control col"  name="mail" type="text" /></div>
          <div class="votediv m-2 col-sm-2 "><label class="form-label d-block text-center">Vote</label><input checked class="voteBox d-block mx-auto" type="checkbox"></div>
          <div class="votediv m-2 col-sm-2 "><label class="form-label d-block text-center">Procuration 1</label><input class="voteBox d-block mx-auto" type="checkbox"></div>
          <div class="votediv m-2 col-sm-2"><label class="form-label d-block text-center">Procuration 2</label><input class="voteBox d-block mx-auto" type="checkbox"></div>
        </div>

      </div>
      <div class="container m-2 row">
      <button class="btn btn-secondary col m-2" onclick="appendVotant()">Ajouter un votant</button>
      <button class="btn btn-secondary col m-2"  onclick="removeVotant()">Enlever un votant</button>
      </div>
      <div class="container-fluid m-2 text-center">
      <button id="sendButton" class="mx-auto btn btn-primary" onclick="send()">Créer</button>
      </div>
      <label id="error"></label>
      <div>


    </div>


</body>
<script>
  const regexmail = new RegExp('.?@.?\..*');
  const reducer = (accumulator, currentValue) => accumulator && regexmail.test(currentValue.votant);
  const error = $("#error")[0];
  const owner = <?php echo "'".$_SESSION["mail"]."'"?>;
  const button = $("#sendButton")[0];
  function appendResponse() {
    let clone = $('.response:first').clone();
    let kidLabel = clone.children("label")[0];
    let kidInput = clone.children("input")[0];
    kidLabel.innerHTML = "Reponse " + ($(".responses:first").children().length + 1);
    kidInput.classList.add("responseInput");
    kidInput.value = "";
    clone.appendTo(".responses");
  }

  function removeResponse() {
    if ($('.responses').children().length > 1) $('.responses').children().last().remove();
  }

  function appendVotant() {
    let clone = $('.votant:first').clone();
    let kidLabel = clone.children(".col:first").children("label")[0];
    let kidInput = clone.children(".col:first").children("input")[0];
    kidLabel.innerHTML = "Votant " + ($(".votants:first").children().length + 1);
    kidInput.value = "";
    kidInput.classList.add("votantInput");
    clone.appendTo(".votants");
  }

  function removeVotant() {
    if ($('.votants').children().length > 1) $('.votants').children().last().remove();
  }

  function mappingVotant(x) {
    let jObj = $(x);
    console.log(jObj);
    let nom = jObj.children(".col:first").children("input:first")[0].value;
    let vote = jObj.children(".votediv:first").children("input:first")[0].checked;
    let proc1 = jObj.children(".votediv:nth-of-type(2)").children("input:first")[0].checked;
    let proc2 = jObj.children(".votediv:nth-of-type(3)").children("input:first")[0].checked;
    return {
      votant: nom,
      votePossibility: [vote, proc1, proc2].filter(Boolean).length
    };
  }

  function mappingResponse(x) {
    let jObj = $(x);
    let reponse = jObj.children("input:first")[0].value;
    return {
      reponse: reponse,
      votants: []
    };
  }

  function send() {
    button.hidden=true;
    console.log($("votant:first"));
    let votants = $(".votant").toArray().map(mappingVotant);
    let reponses = $(".response").toArray().map(mappingResponse);
    let question = $("#question")[0].value;
    if (question == "") {error.innerText = "Question vide";button.hidden = false;}
    else if (!votants.reduce(reducer, true)){ error.innerText = "L'email d'un votant est incorrect";button.hidden = false;}
    else {
      let vote = {
        question : question,
        reponses : reponses,
        votants : votants,
        owner : owner
      };
      $.ajax({
        method: "POST",
        url: "../../controller/traitement.php",
        dataType: "json",
        data: {
          "vote": vote
        }
      }).done(function(e) {
        button.hidden = false;
        console.log("success");

      }).fail(function(e) {
        button.hidden = false;
        $("body").append(e.responseText);
      });


    }
    

  }
</script>

</html>