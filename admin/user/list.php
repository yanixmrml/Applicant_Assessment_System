<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$sql = "SELECT user_id, user_name, user_regdate, user_last_login
        FROM user
		ORDER BY user_name";
$result = dbQuery($sql);

?> 
<p>&nbsp;</p>
<form action="processUser.php?action=addUser" method="post"  name="frmListUser" id="frmListUser">
<p align="center" class="formTitle">List of User Accounts</p>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
  <td width="120">Edit</td>
   <td width="70">Delete</td>
   <td>User Name</td>
   <td width="120">Register Date</td>
   <td width="120">Last login</td>
  </tr>
<?php
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
   <td width="120" align="center"><a href="javascript:changePassword(<?php echo $user_id; ?>);"><img src="/Taurent_Travel/images/ed.gif"></a></td>
   <td width="70" align="center"><a href="javascript:deleteUser(<?php echo $user_id; ?>);"><img src="/Taurent_Travel/images/del.gif"></a></td>
   <td><?php echo $user_name; ?></td>
   <td width="120" align="center"><?php echo $user_regdate; ?></td>
   <td width="120" align="center"><?php echo $user_last_login; ?></td>
  </tr>
<?php
} // end while

?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"><input name="btnAddUser" type="button" id="btnAddUser" value="Add User" class="box" onClick="addUser()"></td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>