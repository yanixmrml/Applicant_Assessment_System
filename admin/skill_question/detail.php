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

$sql1 = "SELECT skill_name, question, question_choices, question_correct_ans
        FROM skill_question q, skill s
		WHERE q.question_id = $questionId AND q.skill_id = s.skill_id";
		
$result1 = mysql_query($sql1) or die('Cannot get question. ' . mysql_error());

$row1 = mysql_fetch_assoc($result1);
extract($row1);

$sql2 = "SELECT a.answer_id, a.answer, qs.points
        FROM question_answer qs, answer a
		WHERE qs.question_id = $questionId AND qs.answer_id = a.answer_id";
		
$result2 = mysql_query($sql2) or die('Cannot get answers. ' . mysql_error());


?>
<p>&nbsp;</p>
<form action="processQuestion.php?action=addQuestion" method="post" enctype="multipart/form-data" name="frmAddQuestion" id="frmAddQuestion">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
  <td width="150" class="label">Skill</td>
  <td class="content"><?php echo $skill_name; ?></td>
  </tr>
  <tr> 
  <td width="150" class="label">Question</td>
  <td class="content"><?php echo nl2br($question); ?> </td>
  </tr>
  <tr> <td width="150" class="label">Choices</td>
  <td  class="content" > <table class="choices" width="100%"><tr>
  <td align = "center">Points</td><td align = "center">Answers</td>
  <?php 
   		$correct_ans = "";
		while($row2 = dbFetchArray($result2)) {
			list($answer_id, $answer, $points) = $row2;
			echo "<tr><td align = \"center\"> "     . $points  . "</td>";
			echo "<td align = \"center\">"      . $answer  . "</td></tr>";
			
			if($question_correct_ans == $answer_id){
				$correct_ans = $answer;
			}	 
  		}
		echo "<tr><td size = \"100%\">" . "Correct Answer : " . $correct_ans . " </td></tr>";
   ?>
     </table> 
   </td>
  </tr> 
 </table>
 <p align="center"> 
  <input name="btnModifyQuestion" type="button" id="btnModifyQuestion" value="Modify Question" onClick="window.location.href='index.php?view=modify&questionId=<?php echo $questionId; ?>';" class="box">
  &nbsp;&nbsp;
  <input name="btnBack" type="button" id="btnBack" value=" Back " onClick="window.history.back();" class="box">
 </p>
</form>
