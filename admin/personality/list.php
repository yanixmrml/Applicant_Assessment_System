<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (isset($_GET['personalityId']) && (int)$_GET['personalityId'] >= 0) {
	$personalityId = (int)$_GET['personalityId'];
	$queryString = "&personalityId=$personalityId";
} else {
	$personality_parent_id = 0;	
	$personalityId = 0;
	$queryString = '';
}

// for paging
// how many rows to show per page
$rowsPerPage = 5;

$sql = "SELECT personality_id, personality_parent_id, personality_name, personality_description, personality_status, personality_item_positive, 
	    personality_item_negative, personality_career
        FROM personality
		WHERE personality_parent_id = $personalityId
		ORDER BY personality_name";
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage);

?>
<p>&nbsp;</p>
<form action="processPersonality.php?action=addPersonality" method="post"  name="frmListPersonality" id="frmListPersonality">
<p align="center" class="formTitle">Categories of Personality Test</p>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader">
   <td width="75">View</td>
   <td width="75">Edit</td>
   <td width="75">Delete</td> 
   <td>Personality Name</td>
   <td width="75">Status</td>
   <td width="75"> Items </td>
  </tr>
  <?php
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
		
		if ($personality_parent_id == 0) {
			$url = "<a href=\"index.php?personalityId=$personality_id&parentId=$personality_parent_id\">";
			$personality_name = "$personality_name";
		}
			
?>
  <tr class="<?php echo $class; ?>">
   <td width="75" align="center"><?php echo $url; ?><img src="/Taurent_Travel/images/view.gif"></a></td>
   <td width="75" align="center"><a href="javascript:modifyPersonality(<?php echo $personality_id; ?>);"><img src="/Taurent_Travel/images/ed.gif"></a></td>
   <td width="75" align="center"><a href="javascript:deletePersonality(<?php echo $personality_id; ?>);"><img src="/Taurent_Travel/images/del.gif"></a></td> 
   <td><?php echo $personality_name; ?></td>
   <td><?php echo $personality_status; ?></td>
   <td width="75"><?php echo $personality_item_positive + $personality_item_negative ?></td>
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
   <td colspan="5" align="center">No Personality Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"> <input name="btnAddPersonality" type="button" id="btnAddPersonality" value="Add Personality" class="box" 
   onClick="addPersonality(<?php echo $personalityId; ?>)"> 
   </td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>