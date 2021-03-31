<?php
include '../../controller/vote.php';
session_start();

if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
    header("Location: ../../index.php");
  }
$vote = getVote($_POST['id']);
if($vote['owner'] != $_SESSION["mail"]) header("Location: ../../index.php");
closeVote($_POST['id']);
?>

<form id="myForm" action="./manage.php" method="post">
<?php
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    }
?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>