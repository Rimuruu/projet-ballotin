<?php
session_start();
$log=(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]));

?>

<html lang="fr">

<head>
  <meta charset="utf-8">

  <title>Projet Ballotin</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="./view/pages/canvasJS/canvasjs.min.js"></script>
  <script src="./view/pages/js/createVote.js"></script>
  <script src="./view/pages/js/manage.js"></script>
  <script src="./view/pages/js/vote.js"></script>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/styles.css">

</head>

<body class="bg-dark" <?php echo$log? 'onload="init()"':'onload="loginPage()"';?>>
  <div class=" container bg-light">
  <div id=bar>

  </div>
      <div class="container-fluid h-100 body bg-light">
      </div>



</body>

<script>
const regexmail = new RegExp('.?@.?\..*');
  

function init(){
  navbar();
  home();
}

function home(){
  $.ajax({
        method: "GET",
        url: "./view/pages/home.php",
        data: {
          "home": true
        }
      }).done(function(e) {
        $(".body")[0].innerHTML = e;
    
      }).fail(function(e) {
        
        $("body").append(e.responseText);
        error = e;
      }); 
}



function loginPage(){
  $.ajax({
        method: "GET",
        url: "./view/pages/loginPage.php",
        data: {
          "home": true
        }
      }).done(function(e) {
        
        $(".body")[0].innerHTML = e;
    
      }).fail(function(e) {
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      }); 
}


function navbar(){
  console.log("bar");
  $.ajax({
        method: "GET",
        url: "./view/pages/navbar.php"
      }).done(function(e) {
        console.log(e);
        $("#bar")[0].innerHTML = e;
    
      }).fail(function(e) {
      }); 
}

function disconnect(){
  $.ajax({
        method: "GET",
        url: "./view/pages/disconnect.php",
        data: {
          "disconnect": true
        }
      }).done(function(e) {
        $("#bar")[0].innerHTML = "";
        loginPage();
    
      }).fail(function(e) {
        
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      });

}



  function send() {
    let erreur = $(".erreur")[0];
    let mail = $("#mail")[0].value
    if (!mail) {
      erreur.innerText = "Pas de mail indiquer";
    } else if (!regexmail.test(mail)) {
      erreur.innerText = "Ce n'est pas un mail";
    } else {
      $.ajax({
        method: "POST",
        url: "./controller/traitement.php",
        dataType: "json",
        data: {
          "mail": mail
        }
      }).done(function(e) {
        console.log("success")
        erreur.innerText = 'Mot de passe envoyé';

      }).fail(function(e) {
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      });
    }


  }

  function login() {
    let mail = $("#mail")[0].value;
    let mdp = $("#mdp")[0].value;
    let erreur = $(".erreur")[0];
    if (!mail) {
      erreur.innerText = "Pas de mail indiquer";
    } else if (!regexmail.test(mail)) {
      erreur.innerText = "Ce n'est pas un mail";
    } else if (!mdp) {
      erreur.innerText = "Pas de mot de pass indiquer"
    }
    $.ajax({
        method: "POST",
        url: "./view/pages/login.php",
        dataType: "json",
        data: {
          "mail": mail,
          "mdp": mdp
        }
      }).done(function(e) {
        console.log("success")
        if(e == "connecté"){
          home();
          navbar();
        }
        else erreur.innerText = e;
        console.log(e);

      }).fail(function(e) {
        console.log("erreur",e);
        $("body").append(e.responseText);
        error = e;
      });

  }

</script>

</html>