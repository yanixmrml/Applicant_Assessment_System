<?php
if (!defined('WEB_ROOT')) {
	exit;
}


if (isset($_GET['personalityId']) && (int)$_GET['personalityId'] > 0) {
	$personalityId = (int)$_GET['personalityId'];
	$sql2 = " AND q.personality_id = $personalityId";
	$queryString = "personalityId=$personalityId";
} else {
	$personalityId = 0;
	$sql2  = '';
	$queryString = '';
}

// for paging
// how many rows to show per page
$rowsPerPage = 5;
             
$sql = "SELECT test_id, s.personality_id, personality_name, test_item, test_factor
        FROM personality_test q, personality s
		WHERE q.personality_id = s.personality_id $sql2
		ORDER BY test_item";
		
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$personalityList = buildPersonalityOptions($personalityId);

?> 
<p>&nbsp;</p>
<form action="processTest.php?action=addTest" method="post"  name="frmListTest" id="frmListTest">
 <table width="100%" border="0" cellspacing="0" cellpadding="2" class="text">
  <tr>
   <td align="right">View test items in : 
    <select name="cboPersonality" class="box" id="cboPersonality" onChange= "viewTest();">
     <option selected>All Personality</option>
	<?php echo $personalityList; ?>
   </select>
 </td>
 </tr>
</table>
<br>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader">
   <td width="70">View</td> 
   <td width="70">Edit</td>
   <td width="70">Delete</td>
   <td>Test Item</td>
   <td width="75">Factor</td>
   <td width="75">Personality</td>
  </tr>
  
  <?php
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
?>
  <tr class="<?php echo $class; ?>">
   <td width="70" align="center"><a href="index.php?view=detail&testId=<?php echo $test_id; ?>"><img src="/Taurent_Travel/images/view.gif"></a></td>
   <td width="70" align="center"><a href="javascript:modifyTest(<?php echo $test_id; ?>);"><img src="/Taurent_Travel/images/ed.gif"></a></td>
   <td width="70" align="center"><a href="javascript:deleteTest(<?php echo $test_id; ?>, <?php echo $personalityId; ?>);"><img src="/Taurent_Travel/images/del.gif"></a></td>
   <td><?php echo $test_item; ?></td>
   <td width="75" align="center"><?php echo $test_factor; ?></td>
   <td width="75" align="center"><a href="?personalityId=<?php echo $personality_id; ?>"><?php echo $personality_name; ?></a></td>
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
   <td colspan="5" align="center">No Personality Test Items Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"><input name="btnAddTest" type="button" id="btnAddTest" value="Add Test" class="box" 
   onClick="addTest(<?php echo $personalityId; ?>)"></td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>