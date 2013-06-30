<?php
require_once 'config.php';

if(isset($_SESSION['rid'])){
	$id = $_SESSION['rid'];
}else{
	header("Location: /" . WEB_ROOT ."index.php?view=detail");
	exit;
}

	$skillId = $_POST['hidSkillId'];
	$sql = "SELECT se.question_id FROM skill_exam se, skill_question q
				WHERE se.record_id = $id AND se.question_id = q.question_id 
				ORDER BY se.skill_exam_id";
	
	$result     = dbQuery($sql);
	$numQuestions = dbNumRows($result);	
	
	while($row = dbFetchAssoc($result)){
					extract($row);
					$ans = $_POST['question'. $question_id];
					if($ans!=''){ 
						$saveToDatabase = "UPDATE skill_exam SET answer_id = $ans WHERE question_id = $question_id AND record_id = $id";
						$res = dbQuery($saveToDatabase);
					}	
	}
		
	$count = "SELECT answer_id FROM skill_exam e, skill_question q WHERE record_id = $id AND e.question_id = q.question_id 
	AND e.answer_id = q.question_correct_ans";
	$skillResult = dbQuery($count);
	
	$results = dbNumRows($skillResult);
	$insertToRecord = "UPDATE skill_record SET record_score = $results, record_items = $numQuestions WHERE record_id = $id AND skill_id = $skillId";
	dbQuery($insertToRecord); 
	
	//get all total score
	$get = "SELECT record_score FROM skill_record WHERE record_id = $id";
	$res = dbQuery($get);
	$total = 0; 
	while($rows = dbFetchAssoc($res)){
		$total += (int) $rows['record_score'];
	}
	
	$insertToRecord = "UPDATE exam_record SET total_exam_record = $total WHERE record_id = $id";
	dbQuery($insertToRecord);
	 
	$exId = $_SESSION['eid'];
	$insertToRecord = "UPDATE exam_record SET status = 'Old' WHERE examinee_id = $exId AND record_id != $id";
	dbQuery($insertToRecord); 
	
	// to record the submision of the test.
	$_SESSION['skill' . $skillId] = 1; 

	header("Location: /" . WEB_ROOT ."/index.php?view=skillResult&c=" . $skillId);
	exit;

?>
