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

    .votant {

      align-items: center;
      display: grid;
      grid-template-areas: ". . . . .";
      margin: 10px;
    }

    .votediv>* {
      align-items: center;
      display: block;
    }


    .container-forms {
      display: grid;
      grid-template-areas: "."".";
      padding: 50px;
      background-color: 6D676E;
      box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }
  </style>
</head>

<body>
  <div class="body">
    <div class="container-forms">
      <div><?php echo "Connecté : " . $_SESSION["mail"] ?> <a href="./home.php">Home</a></div>
      <div class="ligne"><label>Question</label> <input id="question" type="text" /></div>
      <div class="responses">
        <div class="response"><label> Response 1</label> <input id="reponse1" type="text" /></div>
      </div>
      <button onclick="appendResponse()">Ajouter une réponse</button>
      <button onclick="removeResponse()">Enlever une réponse</button>


      <div class="votants">
        <div class="votant"><label>Votants 1</label> <input required name="mail" type="text" />
          <div class="votediv"><label>Vote</label><input checked class="voteBox" type="checkbox"></div>
          <div class="votediv"><label>Procuration 1</label><input class="voteBox" type="checkbox"></div>
          <div class="votediv"><label>Procuration 2</label><input class="voteBox" type="checkbox"></div>
        </div>

      </div>
      <button onclick="appendVotant()">Ajouter un votant</button>
      <button onclick="removeVotant()">Enlever un votant</button>
      <button id="sendButton" onclick="send()">Créer</button>
      <label id="error"></label>



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
    let kidLabel = clone.children("label")[0];
    let kidInput = clone.children("input")[0];
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
    let nom = jObj.children("input:first")[0].value;
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