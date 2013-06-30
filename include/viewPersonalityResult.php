<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if(!isset($_SESSION['rid'])){
	header("Location: /" . WEB_ROOT . "index.php");
	exit;
}else if((isset($_GET['view'])) && ($_GET['view'] != "personalityResult") && (!isset($_GET['id'])) && ($_SESSION['rid']!=$_GET['id'])){
	header("Location: /" . WEB_ROOT . "index.php?view=detail&id=".$_SESSION['rid']);
	exit;
}else{
	$record_id = $_SESSION['rid'];
}


    $errorMessage = '&nbsp;';

	$getResult = "SELECT  p.personality_parent_id, p.personality_name, p.personality_career, p.personality_description, r.rank, r.attitude FROM personality_record r, personality p WHERE r.record_id = $record_id AND r.personality_id = p.personality_parent_id AND r.attitude = p.attitude"; 
	
	$res = dbQuery($getResult);

    $errorMessage = '&nbsp;';
	$colors = array("#0000FF","#FFFF00","#FF0000","#00FF00","#00FFFF","#FF00FF","#C0C0C0","#000000");

?>
<br/>
<table class="orangeBackground" ><tr><td align="center">
			CONFIRMATION : Congratualtions! You finished take the test.
			The information below are your results from the test.
</td></tr></table>
<p id="errorMessage"><?php echo $errorMessage; ?></p>			
<table width="600" class="division" align="center" cellpadding="5"><tr><td width="100%" align="center" class="subhead">
      PERSONALITY TEST RESULT
</td></tr>
<tr><td>

	<table width="570" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
    <tr> <td align="center" width="150" class="entryTableHeader"> Results </td>
	</tr>
	<tr>
    <td width="150" class="label">Personality Type</td>
    <td class="content"><?php  
		$strongPersonality = array();
		$mildPersonality = array();
		$desc = "";
		
		$getAllNither = "SELECT * FROM personality_record r, personality p WHERE r.record_id = $id AND r.rank = 'Niether' AND p.personality_parent_id = r.personality_id";
				
		$s = dbQuery($getAllNither);
		
		while($row = dbFetchAssoc($res)){
			extract($row);
					
			if($rank=='Strongly'){
				$strongPersonality[] = $row;
			}else if($rank=='Mildly'){
				$mildPersonality[] = $row;
			}
			
			echo $rank . " " . $personality_name . ", ";
		}
		
		while($row = dbFetchAssoc($s)){
			extract($row);
			if(dbNumRows($res)<=0){
				$desc = $desc . $row['personality_description'] . "<br/>";
			}
			echo "Not likely" . " " . $personality_name . ", ";	
		}
	?>
	</td>
    </tr>
	<tr>
    <td width="150" class="label">Dominant Personality</td>
    <td class="content"> 
	<?php 
		$i = 0;
		foreach($strongPersonality as $per){
			echo $per['personality_name'] . " : ";
			$desc .= $per['personality_description'] . "<br/>";
			$i++;	
		}
		
		if($i==0){
			foreach($mildPersonality as $per){
				echo $per['personality_name'] . " : ";
				$desc .= $per['personality_description'] . "<br/>";
				$i++;	
			}
		}
	?>
	</td>
    </tr>
	<tr>
    <td width="150" class="label">Careers</td>
    <td class="content"><?php 
	     $i = 0;
		foreach($strongPersonality as $per){
			echo $per['personality_career'] . " : ";
			$i++;	
		}
		
		if($i==0){
			foreach($mildPersonality as $per){
				echo $per['personality_career'] . " : ";
				$i++;	
			}
		}
		
	//record the personality tests.....
	$_SESSION['personality'] = 1;	
	
	?><tr>
	<td width="150" class="label">Explanation</td>
    <td class="content">
	<?php echo $desc; ?>
	</td>
    </tr>
	</table>
	<table width="570" class="graph">
	<tr><td colspan="1" width="300">
<?php
	$p1 = (int)(.25 * 300);
	$p2 = (int)(.50 * 300);
	$p3 = (int)(.75 * 300);
	$p4 =  1 * 300;
?>
	<div style="width:<?php echo $p1; ?>px; height:25px; float:left; text-align:right;">
	25
	</div>
	<div style="width:<?php echo $p1; ?>px; height:25px; float:left; text-align:right;">
	50
	</div>
	<div style="width:<?php echo $p1; ?>px; height:25px; float:left; text-align:right;">
	75
	</div>
	<div style="width:<?php echo $p1; ?>px; height:25px; float:left; text-align:right;">
	100
	</div>
	</td></tr>
	<?php
	
		$getAverage = "SELECT pr.average,p.personality_name FROM personality_record pr, personality p WHERE pr.record_id = $record_id AND pr.personality_id = p.personality_id";
		$aveResult = dbQuery($getAverage);
		$i = 0;
		
		while($r1 = dbFetchAssoc($aveResult)){
			extract($r1);
			if($i>=8){
				$i = 0;
			}
			$color = $colors[$i];
			$i++;
?>
			<tr><td width="300">
<?php
			createGraph($average,300,$color);
?>
			</td><td ><?php echo number_format($average * 100) . "% " . $personality_name; ?></td></tr>
<?php
		}
	?>
	</table>
	</td>
    </tr>
	</table>
