<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
if (isset($_POST['query'])) {
    include '../connection/config.php';
    include '../repository/MemberService.php';
    $memberService = new MemberService();

    if ($_POST['query'] != null) {
        $result = $memberService->checkMember();
        $count = $result->rowCount();
        if($count>0) {
            foreach ($result as $row) {
                echo'<div style="margin-top: 10px">';
                echo "<span style='color:green'>  ".$row['name']."</span>";
                echo "<script>$('#saveRec').prop('disabled',false);</script>";
                echo'</div>';
            }
        }
        else{
            echo'<div style="margin-top: 10px">';
            echo "<span style='color:red'> Invalid Member</span>";
            echo "<script>$('#saveRec').prop('disabled',true);</script>";
            echo'</div>';
        }
    }
}
?>