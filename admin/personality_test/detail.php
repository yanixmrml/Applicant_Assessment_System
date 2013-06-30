<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// make sure a test id exists
if (isset($_GET['testId']) && $_GET['testId'] > 0) {
	$testId = $_GET['testId'];
} else {
	// redirect to index.php if test id is not present
	header('Location: index.php');
}

$sql1 = "SELECT personality_name, test_item, test_factor
        FROM personality_test q, personality s
		WHERE q.test_id = $testId AND q.personality_id = s.personality_id";
		
$result1 = mysql_query($sql1) or die('Cannot get test. ' . mysql_error());

$row1 = mysql_fetch_assoc($result1);
extract($row1);

?>
<p>&nbsp;</p>
<form action="processTest.php?action=addTest" method="post" enctype="multipart/form-data" name="frmAddTest" id="frmAddTest">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
  <td width="150" class="label">Personality</td>
  <td class="content"><?php echo $personality_name; ?></td>
  </tr>
  <tr> 
  <td width="150" class="label">Test Item</td>
  <td class="content"><?php echo nl2br($test_item); ?> </td>
  </tr>
  <tr> <td width="150" class="label">Factor</td>
  <td  class="content" > <?php echo nl2br($test_factor); ?>
   </td>
  </tr> 
 </table>
 <p align="center"> 
  <input name="btnModifyTest" type="button" id="btnModifyTest" value="Modify Test" onClick="window.lopersonalityion.href='index.php?view=modify&testId=<?php echo $testId; ?>';" class="box">
  &nbsp;&nbsp;
  <input name="btnBack" type="button" id="btnBack" value=" Back " onClick="window.history.back();" class="box">
 </p>
</form>
