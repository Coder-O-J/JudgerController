<?php 
	include "script/script.php";
	$JudgerServer = new JudgerServer();

	if(isset($_GET['judgerList'])){
		$judgerList = $JudgerServer->getJudgerList();
		echo json_encode($judgerList);
	}
	if(isset($_GET['createJudger'])){
		$response = $JudgerServer->createJudger();
		echo json_encode($response);
	}
	else if(isset($_GET['deleteJudger'])){
		$response = $JudgerServer->deleteJudger($_GET['deleteJudger']);
		echo json_encode($response);
	}
	else if(isset($_GET['resetJudger'])){
		$response = $JudgerServer->resetJudger();
		echo json_encode($response);
	}

?>