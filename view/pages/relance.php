<?php
include  dirname(__FILE__).'/../../controller/account.php';
include  dirname(__FILE__).'/../../controller/vote.php';
    ob_start();
    session_start();
    $str = "";
    if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]) && isLog($_SESSION["mail"],$_SESSION["mdp"])&& isLog($_SESSION["mail"],$_SESSION["mdp"]))) {
        $str .= "403 FORBIDDEN";
        ob_end_clean();
        echo json_encode(["string"=>$str,"data"=>null]);
    } else {
        $vote = getVote($_GET['id']);
        if ($vote['owner'] != $_SESSION["mail"]) {
            $str .= "403 FORBIDDEN";
            ob_end_clean();
            echo json_encode(["string"=>$str,"data"=>null]);
        }else{
            $retour = [];
            $actual_link = "http://$_SERVER[HTTP_HOST]/web/Projetweb/#";
            foreach ($vote["votants"] as $votant) {
                $data = sendMail($votant["votant"], "Vous pouvez aller voter pour la question : ".preg_replace('/u([\da-fA-F]{4})/', '&#x\1;',html_entity_decode($vote["question"])). " ".$actual_link );
                array_push($retour,["mail"=>$votant["votant"],"data"=>$data]);
            }
            ob_end_clean();
            echo json_encode(["string"=>"done","data"=>$retour]);

        }
    }
