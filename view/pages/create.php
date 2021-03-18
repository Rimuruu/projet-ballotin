<html lang="fr">
<head>
  <meta charset="utf-8">

  <title>Projet Ballotin</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../../css/styles.css">
  <style>
    .ligne{
      display:block;
      margin-bottom: 10px;
    }
    label{
      display:block;
      width:250px;
    }

    button{
      height:50px;
    }

    .erreur{
      color:red;
    }

  </style>
</head>

<body>
  <header><h1>Projet Ballotin</h1></header>
    <div class="body">
        <div class ="container-login">
            <div class="ligne"><label >Email</label> <input id="mail" type="text" /></div>
            <div class="ligne" ><label >mot de passe</label> <input id="mdp" type="text" /><button onclick="send()">Envoie mot de passe</button></div>
            <div class="erreur"></div>
          </div>
        
    
    
    </div>


</body>
<script>
  const regexmail = new RegExp('.?@.?\..*');
  let erreur = $(".erreur")[0];
  
  function send(){
    let mail = $("#mail")[0].value
    if (!mail){
      erreur.innerText = "Pas de mail indiquer";
    }else if (!regexmail.test(mail)){
      erreur.innerText = "Ce n'est pas un mail";
    }
    else{
      $.ajax({
    method: "POST",
    url: "../../controller/account.php",
    dataType: "json",
    data: { "mail": mail }
  }).done(function (e) {
    error = 'success';

  }).fail(function (e) {
    $("body").append(e.responseText);
    error = e;
  });
    }


  }






</script>

</html>