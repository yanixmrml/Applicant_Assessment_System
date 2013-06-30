<?php
/**
* index.php
*
* Main user page after login
*/

require_once '../library/config.php';
require_once './library/functions.php';

$errorMessage = '';
if (isset($_POST['btnModify'])) {
	$userId      = $_SESSION['userId'];
	$oldPassword = $_POST['txtOldPassword'];
	$newPassword = $_POST['txtNewPassword1'];
	
	$sql = "SELECT user_id FROM user WHERE user_id = $userId AND user_password = PASSWORD('$oldPassword')";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) != 1) {
		$errorMessage = 'Old password is incorrect';
	} else {	
		$sql = "UPDATE user 
				SET user_password = '$newPassword'
				WHERE user_id = $userId";
		mysql_query($sql) or die('Modify failed. ' . mysql_error());
		header('Location: index.php');
		exit;			
	}	
} 

$pageTitle = 'Change Password';
require_once './library/header.php';
?> 
<p align="center"><strong><font color="#660000"><?php echo $errorMessage; ?></font></strong></p>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="frmPassword" id="frmPassword">
<p align="center" class="formTitle">Change Password</p>
 <table width="550" border="0" align="center" cellpadding="2" cellspacing="1" class="whiteTable">
  <tr> 
   <td width="150" align="left" valign="top">Old Password</td>
   <td width="10" align="left" valign="top">:</td>
   <td align="left" valign="top"> 
    <input name="txtOldPassword" type="password" class="box" id="txtOldPassword" size="20" maxlength="20"></td>
 </tr>
 <tr> 
   <td width="150" align="left" valign="top">New Password</td>
   <td width="10" align="left" valign="top">:</td>
   <td align="left" valign="top"><input name="txtNewPassword1" type="password" class="box" id="txtNewPassword1" size="20" maxlength="20"></td>
 </tr>
<tr> 
   <td width="150" align="left" valign="top">Repeat New Password</td>
   <td width="10" align="left" valign="top">:</td>
   <td align="left" valign="top"> 
    <input name="txtNewPassword2" type="password" class="box" id="txtNewPassword2" size="20" maxlength="20">
    <small> </small></td>
 </tr> 
 <tr> 
   <td width="150">&nbsp;</td>
   <td width="10">&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
 <tr> 
  <td colspan="3"><div align="center"> 
    <input name="btnModify" type="submit" class="bluebox" id="btnModify" value="Submit" onClick="return checkPassword();">
    &nbsp;&nbsp; 
    <input name="btnCancel" type="button" class="bluebox" id="btnCancel" onClick="window.location.href='listUser.php';" value="Cancel">
   </div></td>
 </tr>
 <tr>
  <td colspan="3">&nbsp;</td>
 </tr>
</table>
</form>
<script language="JavaScript" type="text/javascript">
function checkPassword()
{
	theForm = window.document.frmPassword;
	
	if (theForm.txtOldPassword.value == '') {
		alert('Enter current password');
		theForm.txtOldPassword.focus();
		return false;
	} else if (theForm.txtNewPassword1.value == '') {
		alert('Enter new password');
		theForm.txtNewPassword1.focus();
		return false;
	} else if (theForm.txtNewPassword2.value == '') {
		alert('Repeat new password');
		theForm.txtNewPassword2.focus();
		return false;
	} else if (theForm.txtNewPassword1.value != theForm.txtNewPassword2.value) {
		alert('New password don\'t match');
		theForm.txtNewPassword2.focus();
		return false;
	} else {
		return true;
	}
}
</script>
<?php
require_once 'lib/footer1.php';
?>
