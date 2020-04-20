<?php 
include('lookUpValue.php');
include ('user.php');

// init
$listUserName = array();
$mappingUser = readListUser($listUserName);

// will be optimized later
processLogFiles();
processRankingFromSingleMatch ($mappingUser,$listUserName);
//rankingSample();
ranking($mappingUser);

 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  background-image: url(bg.jpg);
  color: white;
 
}
.banner{
	text-align: center;
}


.itemBlankCover{
	width: 100%;
}

.itemBlankContent{
	background-image: url("blankTag.png");
	background-repeat: all ;
	
	height: 100px;
	border: solid #b1d9e9 1px;
	margin: 10px;
 	box-shadow: 10px 10px 5px black;
 	padding-top:5px;
	}
.divRankth{
	font-family: 'Raleway',sans-serif;
	font-size: 60px;
	font-weight: 700;
	text-transform: uppercase;
	height: 100%;
	text-align: center;
	padding-top:5px;
	
}
.divKDratio{
	color: #ffffff;
	font-family: 'Raleway',sans-serif;
	font-size: 40px;
	font-weight: 700;
	line-height: 72px; margin: 0 0 24px;
	text-transform: uppercase;
	text-align: center;
 	height: 100%;
	padding-top:3px;
}
.divName{
	color: #ffffff;
	font-family: 'Raleway',sans-serif;
	font-size: 20px;
	font-weight: 700;
	height: 100%;
	padding-top:3px;
}
.divDetail{
	color: #ffffff;
	font-family: 'Raleway',sans-serif;
	font-size: 15px;
	font-weight: 700;
	text-align: center;
	
	height: 100%;
}
.divEXP{
	color: #ffffff;
	font-family: 'Raleway',sans-serif;
	font-size: 15px;
	font-weight: 700;
	text-align: center;
	
	height: 100%;
	text-align: center;
}

.divNameText{
	font-family: 'Raleway',sans-serif;
	font-size: 25px;
	font-weight: 700;
	height: 100%;	
}
.divEXPText{
	padding-top: 5px;
	color: #2ade2a;
	font-family: 'Raleway',sans-serif;
	font-size: 30px;
	font-weight: 700;
	text-align: center;
	height: 100%;
	text-align: center;
}
.divRatioText{

	color: #ffffff;
	font-family: 'Raleway',sans-serif;
	font-size: 30px;
	font-weight: 700;
	text-align: center;
}
.fontGold {
color: #ffd355;
}
.fontSilver{
	color: #5ac1f7;
}
.fontBrozen{
	color: #f19218;
}

.fontNormal{
	color: #e5e5e5;
}
.fontTitleField{
	color:  #5ac1f7;
	margin-bottom: 3px;
}
.fontTitle{
	color: #e5e5e5;
	font-family: 'Raleway',sans-serif;
	font-size: 20px;
	font-weight: 200;	
}
.fontSimple{
	
}
.center{
	text-align: center;
	
}

.weaponIcon{
	height: 50px;
}

.table_row{
	color: #ffffff;
	font-family: 'Raleway',sans-serif;
	font-size: 15px;
	font-weight: 700;
}
</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<title>VSA@NCTU CS Đại Chiến tối thứ 7</title>
 <link rel = "icon" href =  "icon.png"   type = "image/x-icon"> 
<div class="container">
<div class='row center'>
<div class='col-md-9'>
<div ><img src="banner.png" ></div>
</div>
</div>


<?php 
$listColor =["fontGold","fontSilver","fontBrozen","fontNormal"];
$i = 0;
	foreach ($mappingUser as $user) {
		echo "<div class='row'>" ;
		echo "<div class='itemBlankContent col-md-9'>" ;
			// div name
			echo "<div class ='divRankth col-md-2'>";
				if ($i<3)	
					echo "<div class='".$listColor[$i]."'>";
				else 
					echo "<div class='".$listColor[3]."'>";
				echo "#".($i+1);
				echo "</div>";
			echo "</div>";
			echo "<div class ='divName col-md-4'>";
				if ($i<3)	
					echo "<div class='".$listColor[$i]."'>";
				else 
					echo "<div class='".$listColor[3]."'>";

				echo "<div class='row divNameText'>".$user->nickname."</div>";
				echo "<div class='row'><img class='titleImg' src='".$user->getTitleImg()."'/></div>";
				echo "<div class='row fontTitle'>".$user->getTitle()."</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class ='divDetail col-md-2'>";
				echo "<div class='row fontTitleField'>"."Most Used"."</div>";
				echo "<div class='row'>".  $lookupGun[$user->mostUsed]."</div>";
				echo "<div class='row fontTitleField'>"."Most Killed"."</div>";
				echo "<div class='row'>".$user->mostKilled."</div>";
			echo "</div>";
			echo "<div class ='col-md-2 divEXP'>";
				echo "<div class='row fontTitleField'>"."EXP"."</div>";
				echo "<div class='row divEXPText'>".$user->exp."</div>";
			echo "</div>";
			echo "<div class ='col-md-2 divEXP'>";
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
		echo "<div class='col-md-7'>";
			echo "<div class='col-md-2'>";
			echo "";
			echo "</div>";
			echo "<div class='col-md-5'>";
			echo "Title";
			echo "</div>";
			echo "<div class='col-md-2'>";
			echo "EXP";
			echo "</div>";
			echo "<div class='col-md-1'>";
			echo "DIFF";
			echo "</div>";
		echo "</div>";

			$nLevel = count ($listTitle);
			$step = 5;
			for ($i = 0;  $i < $nLevel ; $i++) {
				echo "<div class='col-md-7 table_row'>";
					echo "<div class='col-md-2'>";
					echo "<img  src='lib/".$i.".jpg'/>";
					echo "</div>";
					echo "<div class='col-md-5'>";
					echo $listTitle[$i]."  ";
					echo "</div>";
					echo "<div class='col-md-2'>";
					echo $lookupEXP[$i];
					echo "</div>";
					echo "<div class='col-md-1'>";
					echo  "+".$i*$step;
					echo "</div>";
				echo "</div>";
			}
		?>
	
</div>

</div> <!-- end div CONTAINER -->
<b><center>VSA@NCTU 2020</center></b>
</body>
</html>