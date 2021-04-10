<?php 
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
    echo "";
  }
else {
echo '
  <nav class="navbar p-2  navbar-light bg-light">
        <a class="navbar-brand" id="owner" href="#">'. $_SESSION["mail"] .' </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#" onclick="home()">Home </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" onclick="voteList()">Voter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" onclick="manageList()">Gérer un vote</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" onclick="initCreate()">Créer un vote</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"  onclick="disconnect()">Se deconnecter</a>
            </li>


        </div>
      </nav>';
}

      ?>