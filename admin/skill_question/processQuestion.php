<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
	
	case 'addQuestion' :
		addQuestion();
		break;
		
	case 'modifyQuestion' :
		modifyQuestion();
		break;
		
	case 'deleteQuestion' :
		deleteQuestion();
		break;
    

	default :
	    // if action is not defined or unknown
		// move to main question page
		header('Location: index.php');
}


function addQuestion()
{
    
	$skillId     = $_POST['cboSkill'];
	$question    = $_POST['mtxQuestion'];
	$answer      = $_POST['mtxAnswer0'];
	$choice      = $_POST['choice'];
	$correct	 = 0;
	
	$sql   = "INSERT INTO skill_question (skill_id, question, question_date)
				  VALUES ($skillId, '$question', NOW())";
	$result = dbQuery($sql);
	
	$sql1 = "SELECT * FROM skill_question WHERE question = '$question'";
	$result1  = dbQuery($sql1);
	$row = dbFetchAssoc($result1);
	extract($row);
	$i=0;
	for(;($i<5)&&($answer!="");$i++){
			
		$answer   = $_POST['mtxAnswer' . $i];
		if($answer==""){
			break;
		}
		$points   = (int)$_POST['txtPoints'.$i];
		
		$sql2     = "SELECT * FROM answer WHERE answer = '$answer'"  ;
		$result2  = dbQuery($sql2);
		$row1 = dbFetchAssoc($result2);
		extract($row1);
		$answerId = 0;
		
		if(dbNumRows($result2) == 0){
			$sql3 = "INSERT INTO answer(answer,answer_date) VALUES('$answer',NOW())";
			$result3 = dbQuery($sql3);
			$sql4 = "SELECT * FROM answer WHERE answer = '$answer'"  ;
		    $result4 = dbQuery($sql4);
		    $row2 = dbFetchAssoc($result4);
		    extract($row2);
			$answerId = $answer_id;
		}else{
			$answerId = $answer_id;
		}
		
		
		$sql5	= "INSERT INTO question_answer(question_id, answer_id, points, question_answer_date)
				  VALUES ($question_id, $answerId, $points, NOW())"; 
		$result5  = dbQuery($sql5);	
		
		if($choice==$i){
			$correct = $answerId;
		}
	
	}	
		
	$sql6 = "UPDATE skill_question SET question_choices = $i, question_correct_ans = $correct WHERE question_id = $question_id";
	$result6  = dbQuery($sql6);		
	
	header("Location: index.php?skillId=$skillId");	
}


/*
	Modify a question
*/
function modifyQuestion()
{
	$questionId   = (int)$_GET['questionId'];	
    $skillId     = $_POST['cboSkill'];
	$question    = $_POST['mtxQuestion'];
	$answer      = $_POST['mtxAnswer0'];
	$choice      = $_POST['choice'];
	$correct	 = 0;
	
	$sql1 = "SELECT q.question_id, q.answer_id
	 FROM question_answer q, answer a WHERE q.question_id = $questionId AND q.answer_id = a.answer_id";
	$orig_answerId = 0;
	$result1  = dbQuery($sql1);
	$i=0;
	while(($row = dbFetchArray($result1))||(($i<5)&&($answer!=""))) {
		
		
		//get the next answer to check if it is space or not  
		
		if(dbNumRows($result1) >$i){
			list($questionId, $orig_answerId) = $row;
		}
		
		$answer   = $_POST['mtxAnswer' . $i];
		// delete the remaining answers
		if($answer==""){
			$result = dbQuery($sql1);
			if(dbNumRows($result) > $i){
				$j = 0;
				while($temp = dbFetchArray($result)){
					list($questionId, $orig_answerId) = $temp;
					if($j>=$i){
						$sqlTemp = "DELETE FROM question_answer  WHERE	question_id = $questionId AND answer_id = $orig_answerId";
						$resultTemp = dbQuery($sqlTemp);
					}
					$j++;	
				}	
			}
			break;
		}
		$input_points   = (int)$_POST['txtPoints'.$i];
		
		$sql2     = "SELECT * FROM answer WHERE answer = '$answer'"  ;
		$result2  = dbQuery($sql2);
		$row1 = dbFetchAssoc($result2);
		extract($row1);
		$answerId = 0;
		
		if(dbNumRows($result2) == 0){
			$sql3 = "INSERT INTO answer(answer,answer_date) VALUES('$answer',NOW())";
			$result3 = dbQuery($sql3);
			$sql4 = "SELECT * FROM answer WHERE answer = '$answer'"  ;
		    $result4 = dbQuery($sql4);
		    $row2 = dbFetchAssoc($result4);
		    extract($row2);
			$answerId = $answer_id;
		}else{
			$answerId = $answer_id;
		}
		
		if(dbNumRows($result1) > $i){
			$sql5	= "UPDATE question_answer SET answer_id = $answerId, points = $input_points
					  WHERE question_id = $questionId AND answer_id = $orig_answerId"; 
		}else{
			$sql5	= "INSERT INTO question_answer(question_id, answer_id, points, question_answer_date)
				     VALUES ($questionId, $answerId, $input_points, NOW())"; 
		}			  
		
		$result5  = dbQuery($sql5);	
		
		if($choice==$i){
			$correct = $answerId;
		}
		$i++;
	}
	
	$sql6 = "UPDATE skill_question SET question = '$question', question_choices = $i, question_correct_ans = $correct, 
	question_last_update = NOW() WHERE question_id = $questionId";
	$result6  = dbQuery($sql6);		
	
	header("Location: index.php?skillId=$skillId");		  
}

/*
	Remove a question
*/
function deleteQuestion()
{
	if (isset($_GET['questionId']) && (int)$_GET['questionId'] > 0) {
		$questionId = (int)$_GET['questionId'];
	} else {
		header('Location: index.php');
	}
	
	// remove any references to this question from
	// tbl_order_item and tbl_cart
	$sql = "DELETE FROM question_answer
	        WHERE question_id = $questionId";
	dbQuery($sql);
			
	
	// remove the question from database;
	$sql = "DELETE FROM skill_question 
	        WHERE question_id = $questionId";
	dbQuery($sql);
	
	header('Location: index.php?skillId=' . $_GET['skillId']);
}

?>