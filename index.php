<?php
require_once 'library/config.php';
require_once 'library/category-functions.php';
require_once 'include/header.php';

$skillId  = (isset($_GET['c'])) ? $_GET['c'] : 0;
//$type   = (isset($_GET['t']) && $_GET['t'] != '') ? $_GET['t'] : 'personality';

?>
<div id="backgroundUp">
&nbsp;
</div>
<div id="backgroundDown">
&nbsp;
</div>
<table width="500" align="center" cellpadding="0" cellspacing="0" class ="mainBody">
 <tr class="bg"> 
  <td width="450" class="leftnav"> 
 <?php
require_once 'include/leftNav.php';
?> 
 </td>
 </tr>
 <tr>
  <td width="100%" align="center">
<?php
if((!isset($_GET['view']))&&(!isset($_SESSION['rid']))){
		$includeFile = 'include/addProfile.php';
		$pageTitle   = 'Create Profile';
} else if ((isset($_GET['view']))&&($_GET['view']=="detail")) {
		$includeFile = 'include/viewProfile.php';
		$pageTitle   = 'View Profile';
} else if(isset($_SESSION['skill'.$skillId])||((isset($_GET['view']))&&($_GET['view']=="skillResult"))){
		$includeFile = 'include/viewSkillResult.php';
		$pageTitle   = 'View Skill Result';
} else if((isset($_GET['view']))&&($_GET['view']=="personalityResult")){
		$includeFile = 'include/viewPersonalityResult.php';
		$pageTitle   = 'View Personality Result';
}else if((isset($_GET['view']))&& ($_GET['view']=='logout')){
		unset($_SESSION['rid']);
		session_unregister('rid');
		unset($_SESSION['eid']);
		session_unregister('eid');
		session_destroy();
		$includeFile = 'include/addProfile.php';
		$pageTitle   = 'Create Profile';
}else{
	    $includeFile = 'include/test.php';
		$pageTitle   = 'Test';
} 

		require_once $includeFile;
?>
<br />  
<p id="footer">&copy; 2010 IT 149 - Decision Support System
  - POWERED BY mrmlanime - 
  Email : mrmlanime: yanix_mrml@gmail.com</p>
</tr></td></td></tr>
</table>
</body>
</html>
