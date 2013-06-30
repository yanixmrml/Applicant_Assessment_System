<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// make sure a skill id exists
if (isset($_GET['skillId']) && (int)$_GET['skillId'] > 0) {
	$skillId = (int)$_GET['skillId'];
} else {
	header('Loskillion:index.php');
}	
	
$sql = "SELECT skill_id, skill_name, skill_description, skill_status, skill_items
		FROM skill
		WHERE skill_id = $skillId";
$result = dbQuery($sql);
$row = dbFetchAssoc($result);
extract($row);

?>
<p>&nbsp;</p>
<form action="processSkill.php?action=modify&skillId=<?php echo $skillId; ?>" method="post" enctype="multipart/form-data" name="frmSkill" id="frmSkill">
<p align="center" class="formTitle">Modify Skill</p>
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Skill Name</td>
   <td class="content"><input name="txtName" type="text" class="box" id="txtName" value="<?php echo $skill_name; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"> <textarea name="mtxDescription" cols="50" rows="4" class="box" id="mtxDescription"><?php echo 
   $skill_description; ?></textarea></td>
  	</tr>
  <tr> 
  <td width="150" class="label">Status</td>
  <td class="content"> 
  <?php
  		if($skill_status=="Activate"){
			echo " <input type=\"radio\" name=\"status\" value=\"Activate\" id=\"status\" checked=\"checked\"> Activate
  			<br>
  			<input type=\"radio\" name=\"status\" value=\"Deactivate\" id=\"status\"> Deactivate ";
		}else{
			echo " <input type=\"radio\" name=\"status\" value=\"Activate\" id=\"status\"> Activate
  			<br>
  			<input type=\"radio\" name=\"status\" value=\"Deactivate\" id=\"status\" checked=\"checked\"> Deactivate ";
		
		}
  ?>
  </td>
  </tr>
   <tr> 
   <td width="150" class="label">Number of Items</td>
   <td class="content"> <input name="txtItem" type="text" class="box" id="txtItem" size="30" maxlength="50" 
   value = "<?php echo number_format($skill_items); ?>" onfocus="checkNumber(this)">
   </td>
   </tr>
 </table>
 <p align="center"> 
  <input name="btnModify" type="button" id="btnModify" value="Save Modication" onClick="checkSkillForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">
 </p>
</form>