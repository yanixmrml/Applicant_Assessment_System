<?php

if (!defined('WEB_ROOT')) {
	exit;
}

if((isset($_GET['view'])) && ($_GET['view'] != "individual") && (!isset($_GET['id']))){
	header("Location: /" . WEB_ROOT . "index.php?view=result");
	exit;
}else{
	$record_id = $_GET['rid'];
}

$errorMessage = '&nbsp;';

	$getResult = "SELECT  p.personality_parent_id, p.personality_name, p.personality_career, p.personality_description, r.rank, r.attitude FROM personality_record r, personality p WHERE r.record_id = $record_id AND r.personality_id = p.personality_parent_id AND r.attitude = p.attitude"; 
	
	$res = dbQuery($getResult);

	$getProfile = "SELECT * FROM examinee e, exam_record r WHERE r.record_id = $record_id AND r.examinee_id = e.examinee_id ";
	$res2 = dbQuery($getProfile);
	extract(dbFetchAssoc($res2));

?>
<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
    <tr> 
        <td align="center"> INDIVIDUAL RESULT </td>
    </tr>
</table>
<p id="errorMessage"><?php echo $errorMessage; ?></p>

	<form  id="frmProfile">
	<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
    <tr> <td align="center" width="150" class="entryTableHeader"> PERSONAL </td>
	</tr>
	<tr>
    <td width="150" class="label">Last Name</td>
    <td class="content"><?php echo $examinee_last ?></td>
    </tr>
	<tr>
    <td width="150" class="label">First Name</td>
    <td class="content"> <?php echo $examinee_first ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Middle Name</td>
    <td class="content"><?php echo $examinee_middle ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Age</td>
    <td class="content"><?php echo $examinee_age ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Gender</td>
    <td class="content"> <?php echo $examinee_gender ?> </td>
    </tr>
	<tr>
    <td width="150" class="label">Address</td>
    <td class="content"><?php echo $examinee_address ?></td>
    </tr>
	<tr> <td align="center" width="150" class="entryTableHeader"> EDUCATIONAL  </td></tr>
	<tr>
    <td width="150" class="label">High School</td>
    <td class="content"><?php echo $examinee_high ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Address</td>
    <td class="content"><?php echo $examinee_high_address ?></td>
    </tr>
	<tr>
	<td width="150" class="label">Awards</td>
    <td class="content"><?php echo $examinee_high_awards ?></td>
	</tr>
	<tr>
	<td width="150" class="label">College</td>
    <td class="content"><?php echo $examinee_college ?></td>
	</tr>
	<tr>
	<td width="150" class="label">Course</td>
    <td class="content"><?php  echo $examinee_course ?></td>
	</tr>
	<tr>
	<td width="150" class="label">Address</td>
    <td class="content"><?php echo $examinee_college_address ?></td>
	</tr>
	<tr>
	<td width="150" class="label">Awards</td>
    <td class="content"><?php echo $examinee_college_awards ?></td>
	</tr>
	<tr> <td align="center" width="150" class="entryTableHeader"> EMPLOYMENT  </td></tr>
	<tr>
    <td width="150" class="label">Company</td>
    <td class="content"><?php echo $examinee_company_one ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Years in Experience</td>
    <td class="content"><?php echo $examinee_experience_one ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Reference</td>
    <td class="content"><?php echo $examinee_reference_one ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Company</td>
    <td class="content"><?php echo $examinee_company_two ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Years in Experience</td>
    <td class="content"><?php echo $examinee_experience_two ?></td>
    </tr>
	<tr>
    <td width="150" class="label">Reference</td>
    <td class="content"><?php echo $examinee_reference_two ?></td>
    </tr>
	</table>
	
<p id="errorMessage"><?php echo $errorMessage; ?></p>
	<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
    <tr> <td align="center" width="150" class="entryTableHeader"> Personality </td>
	</tr>
	<tr>
    <td width="150" class="label">Personality Type</td>
    <td class="content"><?php  
		$strongPersonality = array();
		$mildPersonality = array();
		while($row = dbFetchAssoc($res)){
			extract($row);
					
			if($rank=='Strongly'){
				$strongPersonality[] = $row;
			}else if($rank=='Mildly'){
				$mildPersonality[] = $row;
			}
			
			echo $rank . " " . $personality_name . ", ";
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
			$i++;	
		}
		
		if($i==0){
			foreach($mildPersonality as $per){
				echo $per['personality_name'] . " : ";
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
	
	?>
	</td>
    </tr>
	</table>
<?php

	$skill = "SELECT s.skill_name, r.record_score, r.record_items FROM skill_record r, skill s  WHERE r.record_id = $record_id AND s.skill_id = r.skill_id";
	$result = dbQuery($skill);

?>
	<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
    <tr> <td align="center" width="150" class="entryTableHeader">Skill</td>
	</tr>
	<tr>
    <td width="150" class="label">Category</td> <td width="150" class="label">Items</td> <td width="150" class="label">Score</td>
	<td width="150" class="label">Percentage</td></tr>
<?php
	while($row = dbFetchAssoc($result)){
		extract($row);
?>	
	<tr><td class="content"><?php echo $skill_name?></td>
    <td class="content"> <?php echo $record_items ?></td>
    <td class="content"> <?php echo $record_score ?></td>
    <td class="content"><?php echo (($record_score/$record_items)*100) . "%" ?></td>
    </tr>
<?php
	}
?>	
</table>

