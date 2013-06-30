<?php
if (!defined('WEB_ROOT')) {
	exit;
}


if (isset($_GET['skillId']) && (int)$_GET['skillId'] > 0) {
	$skillId = (int)$_GET['skillId'];
	$sql2 = " AND q.skill_id = $skillId";
	$queryString = "skillId=$skillId";
} else {
	$skillId = 0;
	$sql2  = '';
	$queryString = '';
}

// for paging
// how many rows to show per page
$rowsPerPage = 5;

$sql = "SELECT question_id, s.skill_id, skill_name, question, question_choices
        FROM skill_question q, skill s
		WHERE q.skill_id = s.skill_id $sql2
		ORDER BY question";
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$skillList = buildSkillOptions($skillId);

?> 
<p>&nbsp;</p>
<form action="processQuestion.php?action=addQuestion" method="post"  name="frmListQuestion" id="frmListQuestion">
 <table width="100%" border="0" cellspacing="0" cellpadding="2" class="text">
  <tr>
   <td align="right">View questions in : 
    <select name="cboSkill" class="box" id="cboSkill" onChange="viewQuestion();">
     <option selected>All Skill</option>
	<?php echo $skillList; ?>
   </select>
 </td>
 </tr>
</table>
<br>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader">
   <td width="70">View</td> 
    <td width="70">Edit</td>
   <td width="70">Delete</td>
   <td>Question</td>
   <td width="75">Number of Choices</td>
   <td width="75">Skill</td>
  </tr>
  <?php
$parentId = 0;
if (dbNumRows($result) > 0) {
	$i = 0;
	
	while($row = dbFetchAssoc($result)) {
		extract($row);
				
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
		
		$i += 1;
?>
  <tr class="<?php echo $class; ?>"> 
   <td width="70" align="center"><a href="index.php?view=detail&questionId=<?php echo $question_id; ?>"><img src="/Applicant_Assessment_System/images/view.gif"></a></td>
   <td width="70" align="center"><a href="javascript:modifyQuestion(<?php echo $question_id; ?>);"><img src="/Applicant_Assessment_System/images/ed.gif"></a></td>
   <td width="70" align="center"><a href="javascript:deleteQuestion(<?php echo $question_id; ?>, <?php echo $skillId; ?>);"><img src="/Applicant_Assessment_System/images/del.gif"></a></td>
   <td><?php echo $question; ?></td>
   <td width="75" align="center"><?php echo $question_choices; ?></td>
   <td width="75" align="center"><a href="?skillId=<?php echo $skill_id; ?>"><?php echo $skill_name; ?></a></td>
  </tr>
  <?php
	} // end while
?>
  <tr> 
   <td colspan="5" align="center">
   <?php 
echo $pagingLink;
   ?></td>
  </tr>
<?php	
} else {
?>
  <tr> 
   <td colspan="5" align="center">No Questions Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"><input name="btnAddQuestion" type="button" id="btnAddQuestion" value="Add Question" class="box" 
   onClick="addQuestion(<?php echo $skillId; ?>)"></td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>