<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if((isset($_SESSION['rid']))&&(isset($_SESSION['rid']))&&(isset($_GET['t']))&&(isset($_GET['c']))&&(isset($_GET['id']))&&($_GET['id']==$_SESSION['rid'])){
	$t = $_GET['t'];
	$c = $_GET['c'];
	$id = $_GET['id'];
}else if(isset($_SESSION['rid'])){
	header("Location: index.php?view=detail");
	exit;
}else{
	header("Location: index.php?view=add");
	exit;
}

$sql = "";

if($t=='personality'){

	$sql = "SELECT t.test_id, t.test_item FROM personality_exam p, personality_test t
				WHERE p.record_id = $id AND p.test_id = t.test_id";

}else{

	$sql = "SELECT se.question_id, q.question FROM skill_exam se, skill_question q
				WHERE se.record_id = $id AND se.skill_id = $c AND se.question_id = q.question_id 
				ORDER BY se.skill_exam_id";

}

$result     = dbQuery($sql);
$numQuestions = dbNumRows($result);

if ($numQuestions > 0 ) {
	
	if($t!='personality'){
	
?>			
			<br/>
			<table class="orangeBackground"><tr><td align="center">
			INSTRUCTION : Please answer genuinely and appropriately the questions below. 
			You need to choose the right answer of the question. If you leave a question
			an answered, it will be automatically interpreted as incorrect answer.
			</td></tr></table>
			<br/>		
			<form action="library/processSkillResult.php" method="post" enctype="multipart/form-data" name="frmSkill" id="frmSkill">
			<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
			<input name = "hidSkillId" type="hidden" value="<?php echo $c ?>"  id="hidSkillId" >

<?php	

			while($row = dbFetchAssoc($result)){
			
				extract($row);
				echo "<tr><td> &nbsp; </td></tr>";
				echo  "<tr> <td class=\"entryTableHeader\"></td></tr>";
				echo  "<tr><td class=\"content\"> " . $question  ." </td></tr>";
				$answer = "SELECT a.answer_id, a.answer FROM answer a, question_answer q WHERE question_id = $question_id AND a.answer_id = q.answer_id";
				$ansRes = dbQuery($answer);
				echo "<tr><td class=\"content\"><table><tr>"; 
				while($ansRow = dbFetchAssoc($ansRes)){
					extract($ansRow);
					echo "<td><input type=\"radio\" name=\"question" . $question_id ."\" id=\"question" . $question_id .  "\" value=\"" . $answer_id ."\">" . $answer . 
					"</td>";
				}
				echo "</tr></table>";
				
			}
?>
			</table>
			<div align="center">
			<p><input name="btnSubmitTest" type="button" id="btnAddTest" value="Submit Test" onClick="submit();" class="box"></p></div>
			</form>	
			
<?php 		
		
	}else{
?>
			<br/>
			<table class="orangeBackground"><tr><td align="center">
			INSTRUCTION : Please answer genuinely and appropriately the questions below. 
			The questions are descriptions or situation of certain personality.
			Very accurate means you are most likely related to this personality.
			Mildly accurate means you may be related to this personality.
			Niether means you are not sure.
			Mildly inaaccurate means you may not be related to this personality.
			Very inaaccurate means you are not related to this personality.
			</td></tr></table>
			<br/>	

			<form action="library/processPersonalityResult.php" method="post" enctype="multipart/form-data" name="frmPersonality" id="frmPersonality">
			<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">

<?php	
			//shuffle all the test items
			$shuffleList = array();
			while($row = dbFetchAssoc($result)){
				$shuffleList[] = $row;
			}
			
			shuffle($shuffleList);
			foreach($shuffleList as $row){
				extract($row);
				echo "<tr><td> &nbsp; </td></tr>";
				echo  "<tr> <td class=\"entryTableHeader\"></td></tr>";
				echo  "<tr><td class=\"content\"> " . $test_item  ." </td></tr>";
				$answer = "SELECT t.value, c.choice FROM choice c, test_choices t WHERE test_id = $test_id AND t.choice_id = c.choice_id";
				$ansRes = dbQuery($answer);
				echo "<tr><td class=\"content\"><table><tr>"; 
				while($ansRow = dbFetchAssoc($ansRes)){
					extract($ansRow);
					echo "<td class =\"choices\"> <input type=\"radio\" name=\"test" . $test_id ."\" id=\"test" . $test_id . "\" value=\"" . $value ."\">" 
					. $choice . "</td>";
				}
				echo "</tr></table>";
			}
	
?>
	</table>
	<div align="center">
	<p><input name="btnSubmitTest" type="button" id="btnAddTest" value="Submit Test" onClick="submit();" class="box"></p></div>
	</form>	

	
<?php	
	}
	
	
} else {
?>	
	<div align="center">
	<table>
	<tr><td width="100%" align="center" valign="center">No questions in this category</td></tr>
	</table>
	</div>
<?php	
}	
?>
