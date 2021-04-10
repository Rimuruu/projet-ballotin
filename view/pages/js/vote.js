
function voteList(){
    $.ajax({
        method: "GET",
        url: "./view/pages/voteList.php",
        data: {
          "create": true
        }
      }).done(function(e) {
        $(".body")[0].innerHTML = e;
       
    
      }).fail(function(e) {
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      });


}


function vote(id){
  $.ajax({
      method: "GET",
      url: "./view/pages/vote.php",
      dataType: "json",
      data: {
        "vote": id
      }
    }).done(function(e) {
        console.log(e);
      $(".body")[0].innerHTML = e.string;
      if (e.data.status == "close") chart(e.data);

     
  
    }).fail(function(e) {
      console.log(e);
      $("body").append(e.responseText);
      error = e;
    });

}

function result(id,result){
  $.ajax({
      method: "GET",
      url: "./view/pages/vote.php",
      dataType: "json",
      data: {
        "vote": id,
        "result":result
      }
    }).done(function(e) {
        console.log(e);
      $(".body")[0].innerHTML = e.string;
      if (e.data.status == "close") chart(e.data);

     
  
    }).fail(function(e) {
      console.log(e);
      $("body").append(e.responseText);
      error = e;
    });

}


function voteSend(id){
  let reponses = $(".rep:checked")[0].value;
  $.ajax({
      method: "POST",
      url: "./view/pages/setVote.php",
      dataType: "json",
      data: {
        "vote": id,
        "reponse" : reponses
      }
    }).done(function(e) {
        console.log(e);
        result(e.id,e.result)
      

     
  
    }).fail(function(e) {
      console.log(e);
      $("body").append(e.responseText);
      error = e;
    });

}
