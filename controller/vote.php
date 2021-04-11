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
            "date" => getdate(), 
        ];
        $info["cpt"] = $info["cpt"] +1; 
        array_push($info["data"],$vote);
        $modif = json_encode($info);
        $file = fopen("../model/vote.json", "w");
        fwrite($file, $modif);
    return $vote;    
    }



}

function getVotes($mail){
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

function getVotesFromVotant($mail){
    if (file_exists(dirname(__FILE__)."/../model/vote.json")) {
        $contents = file_get_contents(dirname(__FILE__)."/../model/vote.json");
        $info = json_decode($contents, true);



        $results = array_filter(
    
            $info["data"],
            function($v, $k) use ($mail) { 
                foreach ($v["votants"] as $item) {
                    if ($item["votant"]==$mail) {
                        return true;
                    }
                }
                return false;
             },ARRAY_FILTER_USE_BOTH
        );
        

        return $results;
    }
    return dirname(__FILE__)."/../model/vote.json";


}


function getVote($id){
    if (file_exists(dirname(__FILE__)."/../model/vote.json")) {
        $contents = file_get_contents(dirname(__FILE__)."/../model/vote.json");
        $info = json_decode($contents, true);



        $result = array_search(
            $id
            ,array_column($info["data"],'id')
        );
        

        return $info["data"][$result];
    }
    return dirname(__FILE__)."/../model/vote.json";
}


function closeVote($id){
    if (file_exists(dirname(__FILE__)."/../model/vote.json")) {
        $contents = file_get_contents(dirname(__FILE__)."/../model/vote.json");
        $info = json_decode($contents, true);



        $result = array_search(
            $id
            ,array_column($info["data"],'id')
        );
        

        $info["data"][$result]["status"]="close";
        $modif = json_encode($info);
        $file = fopen(dirname(__FILE__)."/../model/vote.json", "w");
        fwrite($file, $modif);
    }

}

function deleteVote($id){
    if (file_exists(dirname(__FILE__)."/../model/vote.json")) {
        $contents = file_get_contents(dirname(__FILE__)."/../model/vote.json");
        $info = json_decode($contents, true);



        $result = array_search(
            $id
            ,array_column($info["data"],'id')
        );
        

        array_splice($info["data"], $result,1);
        $modif = json_encode($info);
        $file = fopen(dirname(__FILE__)."/../model/vote.json", "w");
        fwrite($file, $modif);
    }

}

function setVote($id,$mail,$reponse){
    if (file_exists(dirname(__FILE__)."/../model/vote.json")) {
        $contents = file_get_contents(dirname(__FILE__)."/../model/vote.json");
        $info = json_decode($contents, true);



        $result = array_search(
            $id
            ,array_column($info["data"],'id')
        );
        if($result === false) return "Erreur le vote n'existe pas";
        if($info["data"][$result]["status"]=="close") return "Erreur le vote est fermé";
        $result2 = array_search(
            $mail
            ,array_column($info["data"][$result]["votants"],'votant')
        );
        if($result2 === false) return "Erreur vous étes pas un votant";
        $result3 = array_search(
            $reponse
            ,array_column($info["data"][$result]["reponses"],'reponse')
        );
        if($result3 === false) return "Erreur réponse existe pas : ".$reponse;
        if($info["data"][$result]["votants"][$result2]["votePossibility"] > 0){
            array_push($info["data"][$result]["reponses"][$result3]["votant"],$mail);
            $info["data"][$result]["votants"][$result2]["votePossibility"] -= 1;
        }
        else {
            return FALSE;
        }
        $modif = json_encode($info);
        $file = fopen(dirname(__FILE__)."/../model/vote.json", "w");
        fwrite($file, $modif);

        return TRUE;


    }
}

function countVotePossibility($votants){
    $result= 0;
    foreach($votants as $votant){
        $result += $votant["votePossibility"];

    }
    return $result;

}




?>