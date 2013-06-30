<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// make sure a question id exists
if (isset($_GET['questionId']) && $_GET['questionId'] > 0) {
	$questionId = $_GET['questionId'];
} else {
	// redirect to index.php if question id is not present
	header('Location: index.php');
}

// get question info
$sql = "SELECT q.skill_id, question,  question_choices, question_correct_ans
        FROM skill_question q, skill s
		WHERE q.question_id = $questionId AND q.skill_id = s.skill_id";
		
$result = mysql_query($sql) or die('Cannot get question. ' . mysql_error());

$row    = mysql_fetch_assoc($result);

extract($row);

$sql2 = "SELECT qs.answer_id, a.answer, qs.points
        FROM  question_answer qs, answer a
		WHERE qs.question_id = $questionId AND qs.answer_id = a.answer_id";
		
$result2 = mysql_query($sql2) or die('Cannot get answers. ' . mysql_error());

$skillList = buildSkillOptions($skill_id);

?> 

<form action="processQuestion.php?action=modifyQuestion&questionId=<?php echo $questionId; ?>" method="post" enctype="multipart/form-data" name="frmAddQuestion" id="frmAddQuestion">
 <p align="center" class="formTitle">Modify Question</p>
 
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Skill</td>
   <td class="content"> <select name="cboSkill" id="cboSkill" class="box">
     <option value="" selected>-- Choose Skill --</option>
<?php
	echo $skillList;
?>	 
    </select></td>
  </tr>
  <tr> 
   <td width="150" class="label">Question</td>
   <td class="content"> <textarea name="mtxQuestion" cols="65" rows="5" class="box" id="mtxQuestion">
   <?php echo   $question; ?></textarea></td>
  </tr>
   <tr><td width="130" class="label">Choices</td>
   <td><table class="choices"><tr><td align="center" >Correct</td><td align="center">Points</td><td align="center">Answers</td>
   <?php
		$i=0;
		while($row2 = dbFetchArray($result2)) {
		
			list($answer_id, $answer, $points) = $row2;
			
			if($question_correct_ans==$answer_id){
				
				echo "<tr><td class=\"content\"><input type=\"radio\" name=\"choice\" value=" .
				 $i . " id=\"choice\" checked=\"checked\"></td>";
				 
			}else{
				echo "<tr><td class=\"content\"><input type=\"radio\" name=\"choice\" value=" .
				 $i . " id=\"choice\"></td>";
			
			}
			
			echo "<td class=\"content\"><input name=\"txtPoints" . $i . "\" type=\"text\" class=\"box\" id=\"txtPoints" .
			 $i . "\" size=\"10\" value=\"". $points . "\"maxlength=\"15\" onKeyUp=\"checkNumber(this);\"></td>" ;
			echo "<td class=\"content\"> <textarea name=\"mtxAnswer" . $i . "\" cols=\"40\" rows=\"3\" class=\"box\" 
				 id=\"mtxAnswer". $i . "\"> " . $answer  ."</textarea></td></tr>";
   			$i++;
   		}
		
  		while($i<5){
			echo "<tr><td class=\"content\"><input type=\"radio\" name=\"choice\" value=\"" .
				 $i . "\" id=\"choice\"></td>";
			echo "<td class=\"content\"><input name=\"txtPoints" .  $i . "\" type=\"text\" class=\"box\" id=\"txtPoints" . $i . 
			"\" size=\"10\" maxlength=\"15\" onKeyUp=\"checkNumber(this);\"></td>";
			echo "<td class=\"content\"> <textarea name=\"mtxAnswer" . $i . "\" cols=\"40\" rows=\"3\" class=\"box\" 
			 id=\"mtxQuestion". $i . "\"></textarea></td></tr>";
			$i++;
		}
    ?>
	</table>
    </td>
  </tr>
  </table>
 <p align="center"> 
  <input name="btnModifyQuestion" type="button" id="btnModifyQuestion" value="Modify Question" onClick="checkAddQuestionForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>