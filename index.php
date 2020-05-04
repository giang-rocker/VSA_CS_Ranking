<?php 
include('lookUpValue.php');
include ('user.php');

// init
$listUserName = array();
$mappingUser = readListUser($listUserName);

// will be optimized later

// WHEN GET NEW LOG ONLY
//processLogFiles();
processRankingFromSingleMatch ($mappingUser,$listUserName);
// manual set before get log
/*
$mappingUser["Ming"]->mostUsed = "m4a1";
$mappingUser["Ming"]->mostKilled = "Hung501";
$mappingUser["Gank by Wife"]->mostUsed = "ak47";
$mappingUser["Gank by Wife"]->mostKilled = "rambo";
$mappingUser["BoiHetVaoDay"]->mostUsed = "deagle";
$mappingUser["BoiHetVaoDay"]->mostKilled ="HUNGLE";
$mappingUser["Rama_MSE"]->mostUsed = "awp";
$mappingUser["Rama_MSE"]->mostKilled ="Nobita";
$mappingUser["Nobita"]->mostUsed = "famas";
$mappingUser["Mr.Donkey"]->mostUsed = "aug";
$mappingUser["TA"]->mostKilled ="Eternity_HUY";
*/
//rankingSample();
getStatHeadShot($mappingUser);
ranking($mappingUser);
$currentWeek = 3; // manuallyChange
$listColor =["fontGold","fontSilver","fontBrozen","fontNormal"];
$listReduce =[0.7,1.0,1.0,1.0];

// WHEN HAVE NEW LOG ONLY

#exportRankEveryWeek($currentWeek,$mappingUser);
#createFinalRankFile($currentWeek,$listUserName);




 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<title>VSA@NCTU CS Đại Chiến tối thứ 7</title>
 <link rel = "icon" href =  "icon.png"   type = "image/x-icon"> 
</head>
<body>




<div class='row center'>
<div class='row col-md-11 col-xs-11'>
<div ><img src="banner.png" ></div>
</div>
</div>

<?php
	if (isset($_GET['page'])){
		echo "<div class='container'>";
		include_once ('profile.php');
		echo "</div>";
	}
	else {	
?>
<div class="container">
<?php 

$i = 0;
	foreach ($mappingUser as $user) {
			$count_values = array_count_values($user->listKill);
			$most_frequent_name = array_search(max($count_values), $count_values);
			$count_values_gun = array_count_values($user->listUsed);
			arsort($count_values_gun);
			$most_frequent_gun =array_keys ($count_values_gun)[0];
			//$second_frequent_gun =array_keys ($count_values_gun)[1];


		echo "<div class='row'>" ;
		echo "<div class='itemBlankContent col-md-9 col-xs-12'>" ;
			// div name
			echo "<div class ='divRankth col-md-2 col-xs-2'>";
				if ($i<3){
					echo "<div class='".$listColor[$i]."'>";
					$user->exp*= ($listReduce[$i]);
					$user->exp = round($user->exp);
				}
				else 
					echo "<div class='".$listColor[3]."'>";
				echo "#".($i+1);
				echo "</div>";
			echo "</div>";
			echo "<div class ='divName col-md-4 col-xs-4'>";
				echo "<div class='row divNameText'><a href='?page=profile&rank=".$i."'>";
				if ($i<3)	
					echo "<div class='".$listColor[$i]."'>";
				else 
					echo "<div class='".$listColor[3]."'>";
				echo $user->nickname;
				echo "</div>";
				echo "</a></div>";
				echo "<div class='row'><img class='titleImg' src='".$user->getTitleImg()."'/></div>";
				echo "<div class='row fontTitle'>".$user->getTitle()."</div>";
			echo "</div>";

			echo "<div class ='divDetail col-md-2 col-xs-2'>";
				echo "<div class='row fontTitleField'>"."Most Used"."</div>";
				echo "<div class='row'>".  $lookupGun[$most_frequent_gun]."</div>";
				echo "<div class='row fontTitleField'>"."Most Killed"."</div>";
				echo "<div class='row'>".$most_frequent_name."</div>";
			echo "</div>";
			echo "<div class ='col-md-2 divEXP col-xs-2'>";
				echo "<div class='row fontTitleField'>"."EXP"."</div>";
				echo "<div class='row divEXPText'>".$user->exp."</div>";
			echo "</div>";
			echo "<div class ='col-md-2 divEXP  col-xs-2'>";
				echo "<div class='row fontTitleField'>"."KD ratio"."</div>";
				echo "<div class ='row divRatioText'>".$user->KDratio."</div>";
				echo "<div class =''>".$user->nKill."/".$user->nDeath."</div>";
				//echo "<div class =''>".$user->rankingScore."</div>";
			echo "</div>";
			

		echo "</div>"; // end of bouder
		echo "</div>"; // row justify-content-md-center
	$i++;
	}
	
?>
<!-- RANKING SYSTEM -->

<div class='row fontNormal'>
	
		<?php
		echo "<div class='col-md-8 col-xs-12'>";
			echo "<div class='col-md-2 col-xs-2'>";
			echo "";
			echo "</div>";
			echo "<div class='col-md-5 col-xs-5'>";
			echo "Title";
			echo "</div>";
			echo "<div class='col-md-2 col-xs-2'>";
			echo "EXP";
			echo "</div>";
			echo "<div class='col-md-1 col-xs-1'>";
			echo "DIFF";
			echo "</div>";
		echo "</div>";

			$nLevel = count ($listTitle);
			$step = 20;
			for ($i = 0;  $i < $nLevel ; $i++) {
				echo "<div class='col-md-8 table_row col-xs-12'>";
					echo "<div class='col-md-2 col-xs-2'>";
					echo "<img  src='lib/".$i.".jpg'/>";
					echo "</div>";
					echo "<div class='col-md-5 col-xs-5'>";
					echo $listTitle[$i]."  ";
					echo "</div>";
					echo "<div class='col-md-2 col-xs-2'>";
					echo $lookupEXP[$i];
					echo "</div>";
					echo "<div class='col-md-1 col-xs-1'>";
					echo  "+".$i*$step;
					echo "</div>";
				echo "</div>";
			}
		?>
	
</div>

<?php 
}
?>
</div> <!-- end div CONTAINER -->
<div class = 'table_row col-md-9 col-xs-12 center'><b>VSA@NCTU 2020</b></div>



</body>
</html>