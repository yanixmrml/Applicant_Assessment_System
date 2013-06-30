<?php

if (!defined('WEB_ROOT')) {
	exit;
}
	checkUser();
	$numParent = countAllParentPersonality();
	if(isset($_GET['action'])&& $_GET['action']=='customize'){
		$marker = 0;
		$condition = "SELECT p.record_id FROM personality_record p";
		for($i=0;$i<$numParent;$i++){
			$attitude = $_POST['factor'.$i];
			$_SESSION['factor'.$i] = $attitude;
			$personality = $_POST['cboPersonality'.$i];
			$_SESSION['cboPersonality'.$i] = $personality;
			
			if($personality != ''){
				if($i==0){
					$condition .= " WHERE ";
				}
				if($i!=0){
					$condition .= " OR ";
				}
				$condition .= "(p.attitude = '$attitude' AND p.personality_id = $personality)";
			}
			
		}
			
		$getAllApplicants = "SELECT r.record_id, e.examinee_id, e.examinee_last, e.examinee_first, examinee_middle, r.total_exam_record FROM 
		exam_record r, examinee e  WHERE  e.examinee_id = r.examinee_id AND r.status = 'New'
		AND r.record_id IN (" . $condition . ") ORDER BY r.total_exam_record DESC";
		 
	}else{
	
		$getAllApplicants = "SELECT r.record_id, e.examinee_id, e.examinee_last, e.examinee_first, examinee_middle, r.total_exam_record FROM exam_record r, examinee e  WHERE  e.examinee_id = r.examinee_id AND r.status = 'New'
		ORDER BY r.total_exam_record DESC";
	
	}
	
	$result = dbQuery($getAllApplicants)or die("Wrong Configuration of Personality");	
	 
?> 
<p>&nbsp;</p>
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1"><tr><td width="250">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=customize" method="post" enctype="multipart/form-data" name="frmView" id="frmAddView">
  <table align="center" width="100%"> <tr><td align="center" colspan="2">Choose a personality configuration</td></tr>
  <tr><td align="center">APPROACH</td><td align="center">PERSONALITY</td></tr>
 <?php 
 	
 	for($i=0;$i<$numParent;$i++){
	
			$selParent = isset($_SESSION['cboPersonality'.$i])? $_SESSION['cboPersonality'.$i]:0; 
 			$allParent = buildPersonalityOptions($selParent);
			$factor = 	isset($_SESSION['factor'.$i])?$_SESSION['factor'.$i]:'Positive';	
			if($factor=='Positive'){
			
 ?>
		   <tr><td><input type="radio" name="<?php echo "factor".$i; ?>" value="Positive" id="factor.<?php echo $i; ?>" checked="checked"> Positive
		   <br>
		   <input type="radio" name="<?php echo "factor".$i; ?>" value="Negative" id="factor.<?php echo $i; ?>"> Negative </td><td>
		    <select name="<?php echo "cboPersonality".$i; ?>" id="cboPersonality.<?php echo $i; ?>" class="box"><option value="" selected>
			-- Choose Personality --</option>
			<?php echo $allParent; ?>	</select></td></tr>
<?php
		    }else{
?>		   
			 <tr><td><input type="radio" name="<?php echo "factor".$i; ?>" value="Positive" id="factor.<?php echo $i; ?>"> Positive
		   <br>
		   <input type="radio" name="<?php echo "factor".$i; ?>" value="Negative" id="factor.<?php echo $i; ?>" checked="checked"> Negative </td><td>
		   <select name="<?php echo "cboPersonality".$i; ?>" id="cboPersonality.<?php echo $i; ?>" class="box"><option value="" selected>
			-- Choose Personality --</option>
			<?php echo $allParent; ?>	</select></td></tr>
<?php
			}
	} 
 ?>
 <tr><td colspan="2"><p align="center"> 
  <input name="btnSearch" type="button" id="btnSearch" value="Search" onClick="submit()" class="box"> 
 </p> </td></tr>
 </table>
 </form> 
 </td><td align="center" valign="top"> <table width="100%" align="center" class="orangeBackground"><tr><td align="center" colspan="2">
 :: NOTICE:: <br/>
 Please indicate appropriately your configuration
 The left side indicates the approach of the general
 personality you want to sort.
 </tr></td><tr><td>
 
 </td></tr></table>
 </td></tr><tr><td width="500" colspan="2">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr><td colspan="4" id="entryTableHeader">RESULTS</td></tr>
  <tr id="listTableHeader" align="center"><td width="150" >View</td><td width="150" >Name</td><td width="150" >Dominant Personality</td><td width="150" >Total Score</td></tr>
  
 <?php  
  $i = 0;
  $class = "";	
  while($row = dbFetchAssoc($result)){
 	   extract($row);
	   if($i%2){
	   		$class = "row1";
	   }else{
	   		$class = "row2";
	   } 
	   echo "<tr class=\"$class\"><td width=\"150\" align=\"center\">";
	   $i++;
?>
         <a href= "index.php?view=individual&rid=<?php  echo $record_id; ?> &eid=<?php echo $examinee_id; ?>">   
		 <img src="/Taurent_Travel/images/ed.gif"></a>
		 </td>
<?php
	   echo "<td>" . $examinee_last . ", " . $examinee_first . " " . $examinee_middle . "</td>";
?>

		<td><?php 
		
			$getResult = "SELECT  p.personality_parent_id, p.personality_name, p.personality_career, p.personality_description, r.rank, r.attitude FROM personality_record r, personality p WHERE r.record_id = $record_id AND r.personality_id = p.personality_parent_id AND r.attitude = p.attitude";
	
		$res = dbQuery($getResult);		
			
		$strongPersonality = array();
		$mildPersonality = array();
		while($row = dbFetchAssoc($res)){
			extract($row);
					
			if($rank=='Strongly'){
				$strongPersonality[] = $row;
			}else if($rank=='Mildly'){
				$mildPersonality[] = $row;
			}
			
		}
		
		$i = 0;
		foreach($strongPersonality as $per){
			echo $per['personality_name'] . " : ";
			$i++;	
		}
		
		if($i==0){
			foreach($mildPersonality as $per){
				echo $per['personality_name'] . " : ";
				$i++;	
			}
		}
		
		 ?></td><td><?php echo $total_exam_record; ?></td></tr>

<?php

  }	  
 ?>
 
</table>
</td></tr></table>