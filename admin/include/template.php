<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$self = WEB_ROOT . 'admin/index.php';

?>
<html>
<head>
<title><?php echo $pageTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/<?php echo WEB_ROOT;?>admin/include/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="/<?php echo WEB_ROOT;?>library/common.js"></script>

<?php
$n = count($script);
for ($i = 0; $i < $n; $i++) {
	if ($script[$i] != '') {
		echo '<script language="JavaScript" type="text/javascript" src="/' . WEB_ROOT. 'admin/library/' . $script[$i] .'"> </script>';
	}
}
?>
</head>
<body>
<div id="backgroundUp">
&nbsp;
</div>
<div id="backgroundDown">
&nbsp;
</div>
<table width="650" border="0" align="center" cellpadding="0"  class="mainBody">
    <tr>
    <td background="/Taurent_Travel/images/map.png"align="center" height="40" align="center">
<?php
	require_once "header.php";
?>
	</td></tr><tr><td width ="700">
			  <table width="100%" valign="top" class="navArea"><tr><td width="25%"> 
			  <a href="/<?php echo WEB_ROOT; ?>admin/" class="leftnav">Home</a> 
			  </td><td width="25%"> 
			  <a href="/<?php echo WEB_ROOT; ?>admin/skill/" class="leftnav">Skills Category</a>
			  </td><td width="25%"> 
			  <a href="/<?php echo WEB_ROOT; ?>admin/skill_question/" class="leftnav">Skills Questions</a>
			  </td><td width="25%">  
			  <a href="/<?php echo WEB_ROOT; ?>admin/personality/" class="leftnav">Personality Category</a>
			  </td></tr><tr><td width="25%"> 
			  <a href="/<?php echo WEB_ROOT; ?>admin/personality_test/" class="leftnav">Personality Questions</a> 
			  </td><td width="25%">  
			  <a href="/<?php echo WEB_ROOT; ?>admin/result/" class="leftnav">Results</a> 
			  </td><td width="25%">  
			  <a href="/<?php echo WEB_ROOT; ?>admin/user/" class="leftnav">User</a> 
			  </td><td width="25%">  
			  <a href="/<?php echo $self; ?>?logout" class="leftnav">Logout</a>
			  </td></tr></table></td>
			  
        </tr><tr><td class = "contentArea">
		<?php
		require_once $content;	 
		?>
         </td>
        </tr>
		<tr><td>
		<p align="center" id="footer">Copyright &copy; <?php echo date('Y'); ?>  DSS IT 149 Powered by mrmlanime </p>
		</td>
  </tr>
</table>
</body>
</html>
