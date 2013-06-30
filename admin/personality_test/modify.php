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

// get test info
$sql = "SELECT q.personality_id, test_item,  test_factor
        FROM personality_test q, personality s
		WHERE q.test_id = $testId AND q.personality_id = s.personality_id";
		
$result = mysql_query($sql) or die('Cannot get test. ' . mysql_error());

$row    = mysql_fetch_assoc($result);

extract($row);

$personalityList = buildPersonalityOptions($personality_id);

?> 

<form action="processTest.php?action=modifyTest&testId=<?php echo $testId; ?>" method="post" enctype="multipart/form-data" name="frmAddTest" id="frmAddTest">
 <p align="center" class="formTitle">Modify Test</p>
 
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Personality</td>
   <td class="content"> <select name="cboPersonality" id="cboPersonality" class="box">
     <option value="" selected>-- Choose Personality --</option>
<?php
	echo $personalityList;
?>	 
    </select></td>
  </tr>
  <tr> 
   <td width="150" class="label">Test Item</td>
   <td class="content"> <textarea name="mtxTest" cols="65" rows="5" class="box" id="mtxTest">
   <?php echo   $test_item; ?></textarea></td>
  </tr>
   <tr><td width="130" class="label">Factor</td>
   <td>
   <?php
  		if($test_factor=='Positive'){
			echo " <input type=\"radio\" name=\"factor\" value=\"Positive\" id=\"factor\" checked=\"checked\"> Positive
  			<br>
  			<input type=\"radio\" name=\"factor\" value=\"Negative\" id=\"factor\"> Negative ";
		}else{
			echo " <input type=\"radio\" name=\"factor\" value=\"Positive\" id=\"factor\"> Positive
  			<br>
  			<input type=\"radio\" name=\"factor\" value=\"Negative\" id=\"factor\" checked=\"checked\"> Negative ";
		}
  ?>
   
    </td>
  </tr>
  </table>
 <p align="center"> 
  <input name="btnModifyTest" type="button" id="btnModifyTest" value="Modify Test" onClick="checkAddTestForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>