<div align="center"><br />
<?php 
	if(isset($_SESSION['complete'])){
?>
<p align="center" class="mainText"> <?php echo "- - - <b>Welcome " . $_SESSION['complete'] . " - - - </b><br/>" . $_SESSION['type'] ; ?></p>
<?php
	}else{
	
?>
<p align="center" class="mainText"> <?php echo " - - - <b>Welcome Guest </b> - - - "; ?></p>
<?php
	}
?>
<img src="/Taurent_Travel/images/world2png.png" align="middle" />
<p align="center" class="mainText"><a href="/Taurent_Travel/index.php" class="mainText" ><b>Applicant Assessment System's Homepage</b></a></p>
</div>
