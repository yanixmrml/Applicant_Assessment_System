<?php
if (!defined('WEB_ROOT')) {
	exit;
}


$parentId = (isset($_GET['parentId']) && $_GET['parentId'] > 0) ? $_GET['parentId'] : 0;

?> 

<form action="processPersonality.php?action=add" method="post" enctype="multipart/form-data" name="frmPersonality" id="frmPersonality">
 <p align="center" class="formTitle">Add Personality</p>
 
   <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
   <tr> 
   <td width="150" class="label">Personality Name</td>
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
  <input name="hidParentId" 	
		   type="hidden" id="hidParentId" value="<?php echo $parentId; ?>">
  <?php if($parentId==0){ ?>
   <tr> 
   <td width="150" class="label">Items for Positive Factor</td>
   <td class="content"> <input name="txtPositive" type="text" class="box" id="txtPositive" size="15" maxlength="25" onKeyUp="checkNumber(this);">
   </td>
   </tr>
   <tr> 
   <td width="150" class="label">Items for Negative Factor</td>
   <td class="content"> <input name="txtNegative" type="text" class="box" id="txtNegative" size="15" maxlength="25" onKeyUp="checkNumber(this);">
   </td>
  </tr>
  <?php
  	}else{
	?>
			<tr> 
		   <td width="150" class="label">Attitude Approach <td class="content"> 
		   <input type="radio" name="factor" value="Positive" id="factor" checked="checked"> Positive
		   <br>
		   <input type="radio" name="factor" value="Negative" id="factor"> Negative  </td>
		   </tr>

		   <tr> 
		   <td width="150" class="label">Career</td>
		   <td class="content"> <textarea name="mtxCareer" cols="45" rows="3" class="box" id="mtxCareer"></textarea>
		   </td></tr>
 <?php	   
	}
  ?>
 </table>
 <p align="center"> 
  <input name="btnAddPersonality" type="button" id="btnAddPersonality" value="Add Personality" onClick="checkPersonalityForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?personalityId=<?php echo $parentId; ?>';" class="box">  
 </p>
</form>