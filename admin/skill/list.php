<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (isset($_GET['skillId']) && (int)$_GET['skillId'] >= 0) {
	$skillId = (int)$_GET['skillId'];
	$queryString = "&skillId=$skillId";
} else {
	$skillId = 0;
	$queryString = '';
}
	
// for paging
// how many rows to show per page
$rowsPerPage = 5;

$sql = "SELECT skill_id, skill_parent_id, skill_name, skill_description, skill_status, skill_items
        FROM skill
		WHERE skill_parent_id = $skillId
		ORDER BY skill_name";
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage);
?>
<p>&nbsp;</p>
<form action="processSkill.php?action=addSkill" method="post"  name="frmListSkill" id="frmListSkill">
<p align="center" class="formTitle">Categories of Skills Test</p>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader">
    <td width="75">View</td>
   <td width="75">Edit</td>
   <td width="75">Delete</td>
   <td>Skill Name</td>
   <td>Description</td>
   <td width="75">Status</td>
   <td width="75">Items</td>
  </tr>
  <?php
$skill_parent_id = 0;
$url = "";
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
		
		if ($skill_parent_id == 0) {
			$skill_name = "$skill_name";
			$url = "<a href=\"index.php?skillId=$skill_id\">";
		}
			
?>
  <tr class="<?php echo $class; ?>">
   	 <td width="75" align="center"><?php echo $url; ?><img src="/Applicant_Assessment_System/images/view.gif"></a></td>
   <td width="75" align="center"><a href="javascript:modifySkill(<?php echo $skill_id; ?>);"><img src="/Applicant_Assessment_System/images/ed.gif"></a></td>
   <td width="75" align="center"><a href="javascript:deleteSkill(<?php echo $skill_id; ?>);"><img src="/Applicant_Assessment_System/images/del.gif"></a></td> 
   <td><?php echo $skill_name; ?></td>
   <td><?php echo nl2br($skill_description); ?></td>
   <td><?php echo $skill_status; ?></td>
   <td><?php echo $skill_items ?></td>
 
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
   <td colspan="5" align="center">No Skills Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"> <input name="btnAddSkill" type="button" id="btnAddSkill" value="Add Skill" class="box" 
   onClick="addSkill(<?php echo $skillId; ?>)"> 
   </td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>