<?php
require_once 'common.php';

	$first = $_POST['txtFirst']; 
	$last  = $_POST['txtLast']; 
	$middle = $_POST['txtMiddle']; 
	$age = $_POST['txtAge']; 
	$gender = $_POST['gender']; 
	$address = $_POST['txtAddress']; 
	$high = $_POST['txtHigh']; 
	$highAddress = $_POST['txtHighAddress']; 
	$highAwards = $_POST['txtHighAwards']; 
	$college = $_POST['txtCollege']; 
	$course = $_POST['txtCourse']; 
	$collegeAddress = $_POST['txtCollegeAddress'];  
	$collegeAwards = $_POST['txtCollegeAwards'];  
	$company1 = $_POST['txtCompany1']; 
	$numberEx1 = $_POST['txtExperience1']; 
	$ref1 = $_POST['txtReference1']; 
	$company2 = $_POST['txtCompany2']; 
	$numberEx2 = $_POST['txtExperience2']; 
	$ref2 = $_POST['txtReference2']; 
	
	if($company1==''){
		$company1 = " ";
	}
	if($numberEx1 ==''){
		$numberEx1 =0;
	}
	if($ref1==''){
		$ref1= " ";
	}
	if($company2==''){
		$company2=" ";
	}
	if($numberEx2==''){
		$numberEx2=0;
	}
	if($ref2=='' ){
		$ref2=" ";
	}
	
	
	$search = "SELECT examinee_id FROM examinee WHERE examinee_first = '$first' AND examinee_last = '$last' AND examinee_middle = '$middle'";
	$searchResult = dbQuery($search);
	
	
	if(dbNumRows($searchResult)==0){
		
		$sql1 = "INSERT INTO examinee (examinee_first,examinee_last, examinee_middle, examinee_age,
	    examinee_gender, examinee_address, examinee_high, examinee_high_address, examinee_high_awards,
		examinee_college, examinee_course ,examinee_college_address, examinee_college_awards, examinee_company_one,
		examinee_experience_one, examinee_reference_one, examinee_company_two,
		examinee_experience_two, examinee_reference_two) 
		VALUES ('$first','$last','$middle',$age,'$gender','$address','$high' ,'$highAddress','$highAwards', '$college', '$course','$collegeAddress', '$collegeAwards', 
		     '$company1', $numberEx1 , '$ref1' ,'$company2' , $numberEx2 , '$ref2')"; 
		$result1 = 	dbQuery($sql1);
	
		$searchResult= dbQuery($search);
	
	}
	
	$tempRow = dbFetchAssoc($searchResult);
	$examinee_id = $tempRow['examinee_id'];
		
	$insertNewRecord = "INSERT INTO exam_record(status, examinee_id,record_date) VALUES('New',$examinee_id,NOW())";
	$insertResult = dbQuery($insertNewRecord);	
		
	$findNewRecordId = "SELECT record_id FROM exam_record WHERE examinee_id = $examinee_id ORDER BY record_id DESC";
	$findResult = dbQuery($findNewRecordId);
	$fetch = dbFetchAssoc($findResult);
	$record_id = $fetch['record_id'];	
	
	//*********************************************************************************************************************************
	//get all the categories for skill_questions
	$sql3 = "SELECT skill_id, skill_items 
	         FROM skill WHERE skill_status = 'Activate' AND skill_parent_id = 0";
	
	$result3 = 	dbQuery($sql3);
	
	while($row2 = dbFetchAssoc($result3)){
	
		extract($row2);
		
		// collect all questions in this category
		$sql4 = "SELECT question_id FROM  skill s , skill_question q
		WHERE s.skill_parent_id = $skill_id AND s.skill_id = q.skill_id AND q.question_choices > 0";
		$result4 = 	dbQuery($sql4);
		
		$i=0;
		$list = array();
		while(($row3 = dbFetchAssoc($result4))){
			extract($row3);
			$list[] = $question_id;
			$i++;
		}
		
		//shuffle the generated questions...
		shuffle($list);
		$j=0;
		
		foreach($list as $ques){
		
			if($j>=$skill_items){
				break;
			}
			
			$sqlInsert = "INSERT INTO skill_exam(record_id, skill_id, question_id) VALUES($record_id,$skill_id,$ques)";
			$resultInsert =  dbQuery($sqlInsert);
			$j++;
		}
		
		$sqlInsertRecord = "INSERT INTO skill_record(record_id, skill_id,record_items) VALUES($record_id,$skill_id,$skill_items)";
		$resultInsertRecord =  dbQuery($sqlInsertRecord);
		
	}
	
	
	//*********************************************************************************************************************************
	//get all the categories for personality tests
	
	$sql3 = "SELECT personality_id, personality_item_positive, personality_item_negative 
	         FROM personality WHERE personality_status = 'Activate' AND personality_parent_id = 0";
	
	$result3 = 	dbQuery($sql3);
	
	while($row2 = dbFetchAssoc($result3)){
	
		extract($row2);
		
		// collect all positive factor tests items in this type of personality
		$pos = "SELECT test_id FROM  personality p , personality_test t
		WHERE p.personality_id = $personality_id AND p.personality_id = t.personality_id AND t.test_factor='Positive'";
		$result4 = 	dbQuery($pos);
		
		$i=0;
		
		while(($row3 = dbFetchAssoc($result4))&&($i<$skill_items)){
			extract($row3); 
			$sqlInsert = "INSERT INTO personality_exam(record_id, personality_id, test_id) VALUES($record_id,$personality_id,$test_id)";
			$resultInsert =  dbQuery($sqlInsert);
		}
		
		// collect all negative factor tests items in this type of personality
		$pos = "SELECT test_id FROM  personality p , personality_test t
		WHERE p.personality_id = $personality_id AND p.personality_id = t.personality_id AND t.test_factor='Negative'";
		$result4 = 	dbQuery($pos);
		
		$i=0;
		while(($row3 = dbFetchAssoc($result4))&&($i<$skill_items)){
			extract($row3); 
			$sqlInsert = "INSERT INTO personality_exam(record_id, personality_id, test_id) VALUES($record_id,$personality_id,$test_id)";
			$resultInsert =  dbQuery($sqlInsert);
		}
		
		$insertPersonalityRecord = "INSERT INTO personality_record(record_id,personality_id) VALUES($record_id,$personality_id)";
		dbQuery($insertPersonalityRecord);
		
	}
	
	//***********************************************************************************************************************************
	
	//store the ids
	$_SESSION['rid'] = $record_id;
	$_SESSION['eid'] = $examinee_id;  	
		
	header("Location: /" . WEB_ROOT ."/index.php?view=detail&id=". $record_id );	

?>