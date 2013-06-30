<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$skillId = (isset($_GET['skillId']) && $_GET['skillId'] > 0) ? $_GET['skillId'] : 0;

$skillList = buildSkillOptions($skillId);

?> 
<p>&nbsp;</p>
<form action="processQuestion.php?action=addQuestion" method="post" enctype="multipart/form-data" name="frmAddQuestion" id="frmAddQuestion">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr><td colspan="2" id="entryTableHeader">Add Question</td></tr>
  <tr> 
   <td width="150" class="label">Skill</td>
   <td class="content"> <select name="cboSkill" id="cboSkill" class="box">
     <option value="" selected>-- Choose Skill --</option>
   <?php
	 echo $skillList;
   ?>	 
    </select></td><tr>
   <td width="150" class="label">Question</td>
   <td class="content"> <textarea name="mtxQuestion" cols="65" rows="5" class="box" id="mtxQuestion"></textarea></td>
  </tr>
  <tr><td width="130" class="label">Choices</td>
  <td><table class="choices"><tr><td align="center">Correct</td><td align="center">Points</td><td align="center">Answers</td>
  <?php
  		for($i =0;$i<5;$i++){
			echo "<tr><td class=\"content\"><input type=\"radio\" name=\"choice\" value=\"" .
			 $i . "\" id=\"choice\" checked=\"checked\"></td>";
			echo "<td class=\"content\"><input name=\"txtPoints" . $i . "\" type=\"text\" class=\"box\" id=\"txtPoints"
			. $i . "\" size=\"10\" maxlength=\"15\"onKeyUp=\"checkNumber(this);\"> </td>";
			echo "<td class=\"content\"> <textarea name=\"mtxAnswer" . $i . "\" cols=\"40\" rows=\"3\" class=\"box\" 
			 id=\"mtxQuestion". $i . "\"></textarea></td></tr>";
		}
  ?>
  </table>
  </td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnAddQuestion" type="button" id="btnAddQuestion" value="Add Question" onClick="checkAddQuestionForm();" class="box">
  &nbsp;&nbsp;
  <input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>
