<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if(!isset($_SESSION['rid'])){
	header("Location: index.php");
	exit;
}else if((!isset($_GET['view'])) && ($_GET['view'] != "view") && (!isset($_GET['id'])) && ($_SESSION['rid']!=$_GET['id'])){
	header("Location: index.php?view=detail&id=".$_SESSION['rid']);
	exit;
}else{
	$record_id = $_SESSION['rid'];
}

$errorMessage = '&nbsp;';

	$getProfile = "SELECT * FROM examinee e, exam_record r WHERE r.record_id = $record_id AND r.examinee_id = e.examinee_id ";
	$res = dbQuery($getProfile);
	extract(dbFetchAssoc($res));

?>
<br/>
<table class="orangeBackground" ><tr><td align="center">
CONFIRMATION : Congratualtions! You are now ready to take the test.
You can choose what category above you want to take first.
</td></tr></table>
<p id="errorMessage"><?php echo $errorMessage; ?></p>
<table width="600" class="division" align="center" cellpadding="5"><tr><td width="100%" align="center" class="subhead">
      PERSONAL PROFILE 
</td></tr><tr><td>
	<table width="570" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
    <tr> <td align="center" width="150" class="entryTableHeader"> PERSONAL </td>
	</tr>
	<tr>
    <td width="150" class="label">Last Name</td>
    <td class="content"><?php echo $examinee_last ?></td>
    </tr>
	<tr>
    <td width="150" class="label">First Name</td>
    <td class="content"> <?php echo $examinee_first ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Middle Name</td>
    <td class="content"><?php echo $examinee_middle ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Age</td>
    <td class="content"><?php echo $examinee_age ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Gender</td>
    <td class="content"> <?php echo $examinee_gender ?> </td>
    </tr>
	<tr>
    <td width="150" class="label">Address</td>
    <td class="content"><?php echo $examinee_address ?></td>
    </tr>
	<tr> <td align="center" width="150" class="entryTableHeader"> EDUCATIONAL  </td></tr>
	<tr>
    <td width="150" class="label">High School</td>
    <td class="content"><?php echo $examinee_high ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Address</td>
    <td class="content"><?php echo $examinee_high_address ?></td>
    </tr>
	<tr>
	<td width="150" class="label">Awards</td>
    <td class="content"><?php echo $examinee_high_awards ?></td>
	</tr>
	<tr>
	<td width="150" class="label">College</td>
    <td class="content"><?php echo $examinee_college ?></td>
	</tr>
	<tr>
	<td width="150" class="label">Course</td>
    <td class="content"><?php  echo $examinee_course ?></td>
	</tr>
	<tr>
	<td width="150" class="label">Address</td>
    <td class="content"><?php echo $examinee_college_address ?></td>
	</tr>
	<tr>
	<td width="150" class="label">Awards</td>
    <td class="content"><?php echo $examinee_college_awards ?></td>
	</tr>
	<tr> <td align="center" width="150" class="entryTableHeader"> EMPLOYMENT  </td></tr>
	<tr>
    <td width="150" class="label">Company</td>
    <td class="content"><?php echo $examinee_company_one ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Years in Experience</td>
    <td class="content"><?php echo $examinee_experience_one ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Reference</td>
    <td class="content"><?php echo $examinee_reference_one ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Company</td>
    <td class="content"><?php echo $examinee_company_two ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Years in Experience</td>
    <td class="content"><?php echo $examinee_experience_two ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Reference</td>
    <td class="content"><?php echo $examinee_reference_two ?></td>
    </tr>
	</table></td></tr></table>
	<p>&nbsp;</p>

