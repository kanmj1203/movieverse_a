<?php
	$member_num = $_REQUEST["member_num"];
		
	
	require("../db_connect.php");
	
	$query = $db->exec("delete from user where member_num=$member_num");

	// echo "
    // <script>
    //     alert(\"해당 계정이 삭제되었습니다.\");
    // </script>
	// ";				

	header("Location:list.php");
	exit();
?>

