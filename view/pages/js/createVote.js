
const reducer = (accumulator, currentValue) => accumulator && regexmail.test(currentValue.votant);
var error = $("#error")[0];
var owner = "";
var button = $("#sendButton")[0];
var rowVotant = "";

function initCreate(){
    $.ajax({
        method: "GET",
        url: "./view/pages/create.php",
        data: {
          "create": true
        }
      }).done(function(e) {
        $(".body")[0].innerHTML = e;
        error = $("#error")[0];
        owner = $("#owner")[0].innerText;
        button = $("#sendButton")[0];
        rowVotant = $('.votant:first').clone();
        $("#liste-btn").click(function(){
          $("#liste").click();
        });
        $("#liste")[0].onchange = e => { 
          openFile(e);
       }
    
      }).fail(function(e) {
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      });


    
}

function appendResponse() {
  let clone = $(".response:first").clone();
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
  /*let clone = rowVotant.clone();
  let kidLabel = clone.children(".col:first").children("label")[0];
  let kidInput = clone.children(".col:first").children("input")[0];
  kidInput.value = "";
  kidInput.classList.add("votantInput");
  clone.appendTo(".votants");*/
  createVotant("",true,true,true);
}


function createVotant(votant,vote,proc1,proc2){
  let clone = rowVotant.clone();
  let kidInput = clone.children(".col:first").children("input")[0];
  let kidInput1 = clone.children(".votediv:first").children("input:first")[0];
  let kidInput2 = clone.children(".votediv:eq( 1 )").children("input:first")[0];
  let kidInput3 = clone.children(".votediv:eq( 2 )").children("input:first")[0];
  console.log(clone.children(".votediv"));
  console.log(kidInput, kidInput1, kidInput2, kidInput3);
  kidInput1.checked = vote;
  kidInput2.checked = proc1;
  kidInput3.checked = proc2;
  kidInput.value = votant;
  clone.appendTo(".votants");
}



function removeVotant() {
  if ($('.votants').children().length > 1) $('.votants').children().last().remove();
}

function removeSpecific(e){
  if ($('.votants').children().length > 1){
      $(e).parent().parent().remove();


  }


}

function mappingVotant(x) {
  let jObj = $(x);
  console.log(jObj);
  let nom = jObj.children(".col:first").children("input:first")[0].value;
  let vote = jObj.children(".votediv:first").children("input:first")[0].checked;
  let proc1 = jObj.children(".votediv:eq( 1 )").children("input:first")[0].checked;
  let proc2 = jObj.children(".votediv:eq( 2 )").children("input:first")[0].checked;
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

function sendV() {
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
      url: "./controller/traitement.php",
      dataType: "json",
      data: {
        "vote": vote
      }
    }).done(function(e) {
      manageList()

    }).fail(function(e) {
      button.hidden = false;
      $("body").append(e.responseText);
    });


  }
  

}

function listeChange(){
  let selector = $("#selector")[0];
  console.log(selector);
  if(selector.value == "INFO.json"){
    $.getJSON("./liste/INFO.json", function(json) {
      $('.votants').empty();
      $('.votants').children().first().remove();
      json.forEach(element => createVotant(element.email,true,false,false));
  }).fail(function(e) {console.log(e)});
  }
  else if (selector.value == "MIAGE.json"){
    $.getJSON("./liste/MIAGE.json", function(json) {
      $('.votants').empty();
      $('.votants').children().first().remove();
      json.forEach(element => createVotant(element.email,true,false,false));
      
  });
  }

}

function openFile(e){
  var file = e.target.files[0]; 
  var reader = new FileReader();
  reader.onload = onReaderLoad;
  reader.readAsText(file); 
}

function onReaderLoad(event){
  console.log(event.target.result);
  var obj = JSON.parse(event.target.result);
  $('.votants').empty();
  obj.forEach(element => createVotant(element.email,element.vote,element.proc1,element.proc2));
}