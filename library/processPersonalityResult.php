<?php
require_once 'common.php';

if(isset($_SESSION['rid'])){
	$id = $_SESSION['rid'];
}else{
	header("Location:index.php?view=detail");
	exit;
}

	$sql = "SELECT te.test_id FROM personality_exam te, personality_test p
				WHERE te.record_id = $id AND te.test_id = p.test_id";
	
	$result     = dbQuery($sql);
	
	//insert all the answers
	//$ans = 0; 
	while($row = dbFetchAssoc($result)){
						extract($row);			
					    $ans = $_POST['test'. $test_id];
						if($ans!=''){ 
							$saveToDatabase = "UPDATE personality_exam SET choice_id = $ans WHERE test_id = $test_id AND record_id = $id";
							$res = dbQuery($saveToDatabase);
						}	
					
	}
	
	$getAllPersonality = "SELECT personality_id FROM personality_record 
						WHERE record_id = $id"; 
	$results = dbQuery($getAllPersonality);
	
	while($rows = dbFetchAssoc($results)){
	
			extract($rows);
			//Get Positive Answers
			$positive = "SELECT value FROM personality_exam e, personality_test t, test_choices tc, choice c WHERE e.record_id = $id AND 
			t.personality_id = $personality_id AND t.test_factor = 'Positive' AND t.test_id = e.test_id AND e.test_id = tc.test_id AND    
			e.choice_id = tc.choice_id AND tc.choice_id = c.choice_id";
			
			$personalityResult = dbQuery($positive);
			$sumPos = 0;
			while($row=dbFetchAssoc($personalityResult)){
					extract($row);
					$sumPos += $row['value'];
			}
			
			$posAve = $sumPos/(dbNumRows($personalityResult)*5);
			echo "<p>" . $posAve . " - Ave of Pos & items - " .  dbNumRows($personalityResult) . "</p>";
			
			
			$negative = "SELECT value FROM personality_exam e, personality_test t, test_choices tc, choice c WHERE e.record_id = $id AND 
			t.personality_id = $personality_id AND t.test_factor = 'Negative' AND t.test_id = e.test_id AND e.test_id = tc.test_id AND    
			e.choice_id = tc.choice_id AND tc.choice_id = c.choice_id";
			
			$personalityResult = dbQuery($negative);
			$sumNeg = 0;
			while($row=dbFetchAssoc($personalityResult)){
					extract($row);
					$sumNeg += $row['value'];
			}
			$negAve = $sumNeg/(dbNumRows($personalityResult)*5);
			echo "<p>" . $negAve . " - Ave of Neg & items - " .  dbNumRows($personalityResult) . "</p>";
			
			//$finalAve = $negAve < $posAve ? $posAve:$negAve; 
			
			/*
			// Personality Ranking ........	
			$count = "SELECT value FROM personality_exam e, personality_test t, test_choices tc, choice c WHERE e.record_id = $id AND 
			t.personality_id = $personality_id  AND t.test_id = e.test_id AND e.test_id = tc.test_id AND e.choice_id = tc.choice_id 
			AND tc.choice_id = c.choice_id";
			
			
			
			$personalityResult = dbQuery($count);
			$sum = 0;
			while($row=dbFetchAssoc($personalityResult)){
					extract($row);
					$sum += $row['value'];
			}
			*/
			
			/*	
			if(dbNumRows($personalityResult)>0){
				$high =     .78;
				$above = 	.65;
				$average =  .55;
				$below =    .35;
				$low =      .19;
			}
			
			// ranking ....
			if($high<$sum){
				$ranking = "Strongly";
				$attitude = "Positive";
			}else if($high>$sum && $above<$sum){
				$ranking = "Mildly";
				$attitude = "Positive";
			}else if($above>$sum && ($average<=$sum||$average>=$sum )&& $sum>$below){
				$ranking = "Niether";
				$attitude = "Positive and Negative";
			}else if($average>$sum && $sum>$below){
				$ranking = "Mildly";
				$attitude = "Negative";
			}else if($sum<$below){
				$ranking = "Strongly";
				$attitude = "Negative";
			}	
			
		*/
			
			$ranking = "";
			$attitude = "";
			$finalAve = ($posAve + $negAve) / 2.0;
			
		
			$detPos = getDeterminant($posAve);
			$detNeg = getDeterminant($negAve);
		
			echo $detNeg . " - Negative &  " . $detPos . " - Positive Personality ID - " . $personality_id;
			if($detPos<$detNeg){
				$ranking = getRanking($negAve - $posAve, $negAve);
				if($ranking != "Niether"){
					$attitude = "Positive";
				}else{
					$attitude = "Positive and Negative";
				}		
			}else if($detPos == $detNeg){
				$ranking = "Niether";
				$attitude = "Positive and Negative";
			}else{
				$ranking = getRanking($posAve - $negAve, $posAve);
				if($ranking != "Niether"){
					$attitude = "Negative";
				}else{
					$attitude = "Positive and Negative";
				}
			}
			
			$parent_id = $personality_id;			
			$getChildPersonality = "SELECT * FROM personality WHERE personality_parent_id = $parent_id AND attitude = '$attitude'";
			$r = dbQuery($getChildPersonality);
			
			$childPer = 0;
			if($row = dbFetchAssoc($r)){
				extract($row);
				$childPer = (int)$personality_id;
			}
			
			$insertToPersonalityRecord = "UPDATE personality_record SET rank = '$ranking', attitude='$attitude', selected_personality =
			 		$childPer, average = $finalAve WHERE record_id = $id AND personality_id = $parent_id";
			$res = dbQuery($insertToPersonalityRecord); 
			
			$exId = $_SESSION['eid'];
			$insertToRecord = "UPDATE exam_record SET status = 'Old' WHERE examinee_id = $exId AND record_id != $id";
			dbQuery($insertToRecord); 
			
	}
	
	header("Location: /" . WEB_ROOT ."/index.php?view=personalityResult");
	exit;

?>
