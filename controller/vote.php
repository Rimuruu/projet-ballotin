<?php




function createVote($mail,$question,$responses,$votants){
    if (file_exists("../model/vote.json")) {
        
        $contents = file_get_contents("../model/vote.json");
        $info = json_decode($contents, true);
        $vote = [
            "id"=>$info["cpt"],
            "owner"=>$mail,
            "question"=>$question,
            "reponses" => $responses,
            "votants"=> $votants,
            "status" => "going",  
        ];
        $info["cpt"] = $info["cpt"] +1; 
        array_push($info["data"],$vote);
        $modif = json_encode($info);
        $file = fopen("../model/vote.json", "w");
        fwrite($file, $modif);
    return $vote;    
    }



}

function getVote($mail){
    if (file_exists(dirname(__FILE__)."/../model/vote.json")) {
        $contents = file_get_contents(dirname(__FILE__)."/../model/vote.json");
        $info = json_decode($contents, true);



        $results = array_filter(
    
            $info["data"],
            function($v, $k) use ($mail) { 
                return $v["owner"] == $mail;
             },ARRAY_FILTER_USE_BOTH
        );
        

        return $results;
    }
    return dirname(__FILE__)."/../model/vote.json";


}




?>