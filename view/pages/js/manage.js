
const formatter = new Intl.NumberFormat('en-US', {
  minimumFractionDigits: 2,      
  maximumFractionDigits: 2,
});

function chart(vote) {
  var allV = 0;
  var nbNV = vote.votants.reduce((acc, obj) => acc + parseInt(obj.votePossibility), 0);
  allV += nbNV;
  allV = vote.reponses.reduce((acc, obj) => acc + obj.votant.length, allV);
  var data = vote.reponses.map(x => {

    let obj = {
      'y': parseFloat(formatter.format((x.votant.length * 100) / allV)),
      'label': x.reponse,
      'value': x.votant.length
    }
    return obj
  });
  var nonvotant = { 'y': parseFloat(formatter.format((nbNV * 100) / allV)), 'label': 'Non votant', 'value': nbNV };
  data.push(nonvotant);


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
      toolTipContent: "{label} Nombre de votes : {value} ",
      showInLegend: "true",
      legendText: "{label}",
      indexLabelFontSize: 16,
      indexLabel: "{label} - {y}% ",
      dataPoints: data
    }]
  });
  chart.render();


}

function manageList() {
  $.ajax({
    method: "GET",
    url: "./view/pages/manageList.php",
    data: {
      "create": true
    }
  }).done(function (e) {
    $(".body")[0].innerHTML = e;


  }).fail(function (e) {
    $("body").append(e.responseText);
    error = e;
  });

}

function manage(id) {
  $.ajax({
    method: "GET",
    url: "./view/pages/manage.php",
    dataType: "json",
    data: {
      "vote": id
    }
  }).done(function (e) {
    $(".body")[0].innerHTML = e.string;
    if (e.data != null && (e.data.status.localeCompare("close") == 0)) chart(e.data);



  }).fail(function (e) {
    $("body").append(e.responseText);
    error = e;
  });

}

function supprimerVote(id) {
  $.ajax({
    method: "POST",
    url: "./view/pages/deleteVote.php",
    data: {
      "id": id
    }
  }).done(function (e) {
    manageList();


  }).fail(function (e) {
    console.log(e);
    $("body").append(e.responseText);
    error = e;
  });



}

function closeVote(id) {
  $.ajax({
    method: "POST",
    url: "./view/pages/closeVote.php",
    dataType: "json",
    data: {
      "id": id
    }
  }).done(function (e) {
    manage(e);


  }).fail(function (e) {

    $("body").append(e.responseText);
    error = e;
  });
}



function relance(id) {
  $.ajax({
    method: "GET",
    url: "./view/pages/relance.php",
    dataType: "json",
    data: {
      "id": id
    }
  }).done(function (e) {


  }).fail(function (e) {
    $("body").append(e.responseText);
    error = e;
  });
}