<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if(isset($_GET['view']) && $_GET['view'] != "add"){
	header("Location: index.php?view=detail");
	exit;
}

$errorMessage = '&nbsp;';

?>
<p id="errorMessage"><?php echo $errorMessage; ?></p>
<table class="orangeBackground" ><tr><td align="center">
INSTRUCTIONS : You need to fill up first your profile before you can take the test
This profile will certify that you take this test.
Upon submission of the test, you are now ready to take the test.
</td></tr></table>
<br/>

<table width="550" class="division" align="center" cellpadding="5"><tr><td width="100%" align="center" class="subhead">
      PERSONAL PROFILE 
</td></tr><tr><td>
	<form action="library/processProfile.php" method="post" enctype="multipart/form-data" name="frmProfile" 
	id="frmProfile" onSubmit="return checkProfileInfo();">
	<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
    <tr> <td align="center" width="150" class="entryTableHeader"> PERSONAL </td>
	</tr>
	<tr>
    <td width="150" class="label">Last Name</td>
    <td class="content"> <input name="txtLast" type="text" class="box" id="txtLast" size="30" maxlength="50"></td>
    </tr>
	<tr>
    <td width="150" class="label">First Name</td>
    <td class="content"> <input name="txtFirst" type="text" class="box" id="txtFirst" size="30" maxlength="50"></td>
    </tr>
	<tr>
    <td width="150" class="label">Middle Name</td>
    <td class="content"> <input name="txtMiddle" type="text" class="box" id="txtMiddle" size="30" maxlength="50"></td>
    </tr>
	<tr>
    <td width="150" class="label">Age</td>
    <td class="content"> <input name="txtAge" type="text" class="box" id="txtAge" size="30" maxlength="50" onkeyup="checkNumber(this)"></td>
    </tr>
	<tr>
    <td width="150" class="label">Gender</td>
    <td class="content"> <input type="radio" name="gender" value="Male" id="gender" checked="checked"> Male
  	<br>
  	<input type="radio" name="gender" value="Female" id="gender"> Female </td>
    </tr>
	<tr>
    <td width="150" class="label">Address</td>
    <td class="content"> <input name="txtAddress" type="text" class="box" id="txtAddress" size="30" maxlength="50"></td>
    </tr>
	<tr> <td align="center" width="150" class="entryTableHeader"> EDUCATIONAL  </td></tr>
	<tr>
    <td width="150" class="label">High School</td>
    <td class="content"> <input name="txtHigh" type="text" class="box" id="txtHigh" size="30" maxlength="50"></td>
    </tr>
	<tr>
    <td width="150" class="label">Address</td>
    <td class="content"> <input name="txtHighAddress" type="text" class="box" id="txtHighAddress" size="30" maxlength="50"></td>
    </tr>
	<tr>
	<td width="150" class="label">Awards</td>
    <td class="content"> <input name="txtHighAwards" type="text" class="box" id="txtHighAwards" size="30" maxlength="50"></td>
	</tr>
	<tr>
	<td width="150" class="label">College</td>
    <td class="content"> <input name="txtCollege" type="text" class="box" id="txtCollege" size="30" maxlength="50"></td>
	</tr>
	<tr>
	<td width="150" class="label">Course</td>
    <td class="content"> <input name="txtCourse" type="text" class="box" id="txtCourse" size="30" maxlength="50"></td>
	</tr>
	<tr>
	<td width="150" class="label">Address</td>
    <td class="content"> <input name="txtCollegeAddress" type="text" class="box" id="txtCollegeAddress" size="30" maxlength="50"></td>
	</tr>
	<tr>
	<td width="150" class="label">Awards</td>
    <td class="content"> <input name="txtCollegeAwards" type="text" class="box" id="txtCollegeAwards" size="30" maxlength="50"></td>
	</tr>
	<tr> <td align="center" width="150" class="entryTableHeader"> EMPLOYMENT  </td></tr>
	<tr>
    <td width="150" class="label">Company</td>
    <td class="content"> <input name="txtCompany1" type="text" class="box" id="txtCompany1" size="30" maxlength="50"></td>
    </tr>
	<tr>
    <td width="150" class="label">Years in Experience</td>
    <td class="content"> <input name="txtExperience1" type="text" class="box" id="txtExperience1" size="30" maxlength="50" onkeyup="checkNumber(this)"></td>
    </tr>
	<tr>
    <td width="150" class="label">Reference</td>
    <td class="content"> <input name="txtReference1" type="text" class="box" id="txtReference1" size="30" maxlength="50"></td>
    </tr>
	<tr>
    <td width="150" class="label">Company</td>
    <td class="content"> <input name="txtCompany2" type="text" class="box" id="txtCompany2" size="30" maxlength="50"></td>
    </tr>
	<tr>
    <td width="150" class="label">Years in Experience</td>
    <td class="content"> <input name="txtExperience2" type="text" class="box" id="txtExperience2" size="30" maxlength="50" onkeyup="checkNumber(this)"></td>
    </tr>
	<tr>
    <td width="150" class="label">Reference</td>
    <td class="content"> <input name="txtReference2" type="text" class="box" id="txtReference2" size="30" maxlength="50"></td>
    </tr>
	</table>
	<p>&nbsp;</p>
    <p align="center"> 
        <input class="box" name="addProfile" type="submit" id="addProfile" value="SUBMIT">
    </p>	
</form>
</td></tr></table>
