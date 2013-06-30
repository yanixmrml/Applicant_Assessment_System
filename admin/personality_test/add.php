<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$personalityId = (isset($_GET['personalityId']) && $_GET['personalityId'] > 0)?$_GET['personalityId'] : 0;

$personalityList = buildPersonalityOptions($personalityId);

?> 
<p>&nbsp;</p>
<form action="processTest.php?action=addTest" method="post" enctype="multipart/form-data" name="frmAddTest" id="frmAddTest">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr><td colspan="2" id="entryTableHeader">Add Test</td></tr>
  <tr> 
   <td width="150" class="label">Personality</td>
   <td class="content"> <select name="cboPersonality" id="cboPersonality" class="box">
     <option value="" selected>-- Choose Personality --</option>
   <?php
	 echo $personalityList;
   ?>	 
    </select></td><tr>
   <td width="150" class="label">Test Item</td>
   <td class="content"> <textarea name="mtxTest" cols="65" rows="5" class="box" id="mtxTest"></textarea></td>
  </tr>
  <tr>
  <td width="150" class="label">Factor</td>
  <td class="content"> <input type="radio" name="factor" value="Positive" id="factor" checked="checked"> Positive
  <br>
  <input type="radio" name="factor" value="Negative" id="factor"> Negative  </td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnAddTest" type="button" id="btnAddTest" value="Add Test" onClick="checkAddTestForm();" class="box">
  &nbsp;&nbsp;
  <input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>
