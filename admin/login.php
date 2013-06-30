<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once '../library/config.php';
require_once './library/functions.php';

$errorMessage = '&nbsp;';

if (isset($_POST['txtUserName'])) {
	$result = doLogin();
	
	if ($result != '') {
		$errorMessage = $result;
	}
}

?>
<html>
<head>
<title>Applicant Assessment System - Administrator</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="include/admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="backgroundUp">
&nbsp;
</div>
<div id="backgroundDown">
&nbsp;
</div>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="mainBody" height="800">
  <tr>
    <td  background="/Applicant_Assessment_System/images/map.png" align="center" height="40" width="600"> <?php require_once './include/header.php'; ?> </td>
  </tr>
  <tr>
  			
			<td width="590" valign="top" class="navArea" height="40" align="center">
			<form method="post" name="frmLogin" id="frmLogin" enctype="multipart/form-data">
			<table width="150" valign="top" height="40pt"  cellpadding="2px" align="center"><tr>
			  <td align="center" style="font:Calibri; font-size:14pt; font-weight:bold; color:#FF6600;"><b> USERNAME</b></td>
			  <td align="center"><input name="txtUserName" type="text" class="box" id="txtUserName" size="10" maxlength="20"></td> 
			  </td><td align="center" style="font:Calibri; font-size:14pt; font-weight:bold; color:#FF6600;"><b>PASSWORD</b></td>
			  <td align="center"><input name="txtPassword" type="password" class="box" id="txtPassword" size="10"></td>  
			  <td align="center">
			  <input name="btnLogin" type="submit" class="box" id="btnLogin" value="Login"> 
			 </td></tr></table> 
			 </form> 
			 </td>
	</tr><tr><td width="590" valign="top" class="contentArea">
	 <table width="590" border="0" cellspacing="0" cellpadding="20">	
        <tr>
          <td align="center" width="100%">
 <div class="errorMessage" align="center"><?php echo $errorMessage; ?></div>		  
<?php
require_once './include/home.php';	 
?>
          </td>
        </tr>
      </table></td>
  </tr><tr><td background="/Taurent_Travel/images/div.png" align="center" width="100%" height="40pt"> <p>&nbsp;</p>
<p align="center" class="copy" >Copyright &copy 1987 &minus; <?php echo date('Y'); ?> Applicant Assessment System,Ltd. , Powered by mrmlanime<br/> Email at yanixmrml@gmail.com</p>
 <p>&nbsp;</p>
  </td></tr>
</table>
</body>
</html>