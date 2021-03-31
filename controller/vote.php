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



?>