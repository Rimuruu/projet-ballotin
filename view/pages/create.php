
<?php
echo '<div class="container m-2">
    <div class="ligne row m-2"><label class="col-sm-3 form-label">Question</label> <input class="col form-control" id="question" type="text" /></div>
    <div class="responses">
      <div class="response row m-2"><label class="col-sm-3 form-label"> Response 1</label> <input class="col form-control" id="reponse1" type="text" /></div>
    </div>
    <div class="container m-2 row">
      <button class="btn btn-secondary col m-2" onclick="appendResponse()">Ajouter une réponse</button>
      <button class="btn btn-secondary col m-2" onclick="removeResponse()">Enlever une réponse</button>
    </div>
    
    <div class ="container row">
    <div class="col text-center">Liste</div>
    <div class="col">
    <select onchange="listeChange()" class="form-select" id="selector" aria-label="Default select example">
        <option selected></option>
        <option value="MIAGE.json">MIAGE</option>
        <option value="INFO.json">INFO</option>
      </select>
    </div>    


    <div class ="container row">
    <div class="col text-center"><button type="button" class="btn col btn-secondary">Créer une liste</button></div>
    <div class="col text-center">
          <input style="display: none;" type="file"
          id="liste" name="liste"
          accept=".json">
          <button type="button" id="liste-btn" class="btn col btn-secondary">Ajouter une liste</button>
    </div>    
    
    
    </div>

    <div style="height: 400px;" class="votants container mh-25 overflow-auto">
      <div class="votant m-2 row align-items-start justify-content-evenly">
        <div class="col row my-auto"><label class="form-label col-sm-3 my-auto">Votant</label> <input class="form-control col" name="mail" type="text" /></div>
        <div class="votediv m-2 col-sm-2 "><label class="form-label d-block text-center">Vote</label><input checked class="voteBox d-block mx-auto" type="checkbox"></div>
        <div class="votediv m-2 col-sm-2 "><label class="form-label d-block text-center">Procuration 1</label><input class="voteBox d-block mx-auto" type="checkbox"></div>
        <div class="votediv m-2 col-sm-2"><label class="form-label d-block text-center">Procuration 2</label><input class="voteBox d-block mx-auto" type="checkbox"></div>
        <div class="votediv m-2 my-auto col-sm-2"><button onClick="removeSpecific(this)" class="btn btn-danger">X</button></div>
      </div>

    </div>
    <div class="container m-2 row">
      <button class="btn btn-secondary col m-2" onclick="appendVotant()">Ajouter un votant</button>
      <button class="btn btn-secondary col m-2" onclick="removeVotant()">Enlever un votant</button>
    </div>
    <div class="container-fluid m-2 text-center">
      <button id="sendButton" class="mx-auto btn btn-primary" onclick="sendV()">Créer</button>
    </div>
    <label id="error"></label>
    <div>


    </div>';

    ?>