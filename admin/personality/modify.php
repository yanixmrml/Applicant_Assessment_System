<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// make sure a personality id exists
if (isset($_GET['personalityId']) && (int)$_GET['personalityId'] > 0) {
	$personalityId = (int)$_GET['personalityId'];
} else {
	header('Location:index.php');
}	
	
$sql = "SELECT personality_id, personality_parent_id, personality_name, personality_description, personality_status, personality_item_positive, attitude,
    	personality_item_negative, personality_career 
		FROM personality
		WHERE personality_id = $personalityId";
$result = dbQuery($sql);
$row = dbFetchAssoc($result);
extract($row);
?>
<p>&nbsp;</p>
<form action="processPersonality.php?action=modify&personalityId=<?php echo $personalityId; ?>" method="post" enctype="multipart/form-data" name="frmPersonality" id="frmPersonality">
<p align="center" class="formTitle">Modify Personality</p>
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Personality Name</td>
   <td class="content"><input name="txtName" type="text" class="box" id="txtName" value="<?php echo $personality_name; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"> <textarea name="mtxDescription" cols="50" rows="4" class="box" id="mtxDescription"><?php echo 
   $personality_description; ?></textarea></td>
  	</tr>
  <tr> 
  <td width="150" class="label">Status</td>
  <td class="content"> 
  <?php
  		if($personality_status=="Activate"){
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
   <input name="hidParentId" 	
		   type="hidden" id="hidParentId" value="<?php echo $personality_parent_id; ?>">
  <?php if($personality_parent_id==0) { ?>
   <tr> 
   <td width="150" class="label">Items for Positive Factor</td>
   <td class="content"> <input name="txtPositive" type="text" class="box" id="txtPositive" size="15" maxlength="25" value="<?php  echo number_format($personality_item_positive )?>" onKeyUp="checkNumber(this);">
   </td>
   </tr>
   <tr> 
   <td width="150" class="label">Items for Negative Factor</td>
   <td class="content"> <input name="txtNegative" type="text" class="box" id="txtNegative" size="15" maxlength="25" value="<?php  echo number_format($personality_item_positive )?>" onKeyUp="checkNumber(this);">
   </td>
  </tr>
 
  <?php
  	}else{
	
	?>
	 <tr> 
  	 <td width="150" class="label">Attitude Approach </td><td class="content"> 
	
	<?php
  
  		if($attitude=='Positive'){
			echo " <input type=\"radio\" name=\"factor\" value=\"Positive\" id=\"factor\" checked=\"checked\"> Positive
  			<br>
  			<input type=\"radio\" name=\"factor\" value=\"Negative\" id=\"factor\"> Negative ";
		}else{
			echo " <input type=\"radio\" name=\"factor\" value=\"Positive\" id=\"factor\"> Positive
  			<br>
  			<input type=\"radio\" name=\"factor\" value=\"Negative\" id=\"factor\" checked=\"checked\"> Negative ";
		}
  ?>
  			</td></tr>
			<tr> 
		   <td width="150" class="label">Career</td>
		   <td class="content"> <textarea name="mtxCareer" cols="45" rows="3" class="box" id="mtxCareer"><?php echo $personality_career; ?></textarea>
		   </td></tr>
		
  <?php } ?>
 </table>
 <p align="center"> 
  <input name="btnModify" type="button" id="btnModify" value="Save Modication" onClick="checkPersonalityForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">
 </p>
</form>