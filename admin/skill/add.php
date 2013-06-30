<?php
if (!defined('WEB_ROOT')) {
	exit;
}


$parentId = (isset($_GET['parentId']) && $_GET['parentId'] > 0) ? $_GET['parentId'] : 0;
?> 

<form action="processSkill.php?action=add" method="post" enctype="multipart/form-data" name="frmSkill" id="frmSkill">
 <p align="center" class="formTitle">Add Skill</p>
 
   <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
   <tr> 
   <td width="150" class="label">Skill Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"> <textarea name="mtxDescription" cols="45" rows="3" class="box" id="mtxDescription"></textarea>
   <input name="hidParentId" type="hidden" id="hidParentId" value="<?php echo $parentId; ?>">
   </td>
  </tr>
  <tr> 
  <td width="150" class="label">Status</td>
  <td class="content"> <input type="radio" name="status" value="Activate" id="status" checked="checked"> Activate
  <br>
  <input type="radio" name="status" value="Deactivate" id="status"> Deactivate
  </td>
  </tr>
   <tr> 
   <td width="150" class="label">Number of Items</td>
   <td class="content"> <input name="txtItem" type="text" class="box" id="txtItem" size="15" maxlength="25" onKeyUp="checkNumber(this);">
   </td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnAddSkill" type="button" id="btnAddSkill" value="Add Skill" onClick="checkSkillForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?skillId=<?php echo $parentId; ?>';" class="box">  
 </p>
</form>