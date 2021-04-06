<?php
include '../../controller/vote.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
    header("Location: ../../index.php");
  }
if(!(isset($_POST["reponse"]))) header("Location: ../../index.php");
$vote = getVote($_POST['id']);
$isVotant = $result2 = array_search(
    $_SESSION["mail"]
    ,array_column($vote["votants"],'votant')
);
if($isVotant === false) header("Location: ../../index.php");
$result = setVote($_POST['id'],$_SESSION["mail"],$_POST["reponse"]);
?>

<form id="myForm" action="./vote.php" method="post">
<?php

    echo '<input type="hidden" name="result" value="'.$result.'">';
    echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';

?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>