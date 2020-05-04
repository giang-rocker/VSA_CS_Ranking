<?php

	if (isset($_GET['rank'])) {

		$rank =  ($_GET['rank']);
		$user = $mappingUser[$rank];
		$i = $rank;
		$count_values = array_count_values($user->listKill);
		$most_frequent_name = array_search(max($count_values), $count_values);
		$count_values_gun = array_count_values($user->listUsed);
		arsort($count_values_gun);
		$most_frequent_gun =array_keys ($count_values_gun)[0];
	}
 ?>
<?php
		$prevRank = $rank -1;
		$nextRank = $rank+1;

		if ($prevRank==-1) $prevRank = 18;
		if ($nextRank==19) $nextRank = 0;


?>
<?php 
		
		echo "<div class='col-md-9 col-xs-9 profileContainer'>" ;
			echo "<div class = 'fontTitle center'>";
			echo "<a class='fontGold paddingLeft25' href='?page=profile&rank=".$prevRank."'' > << PREV </a>";
			echo "<a class='fontNormal paddingLeft25' href='index.php' > HOME </a>";
			echo "<a class='fontBrozen paddingLeft25' href='?page=profile&rank=".$nextRank."'' > NEXT >> </a>";
			echo "</div>";
			
			echo "<div class='row col-md-12 col-xs-12'>" ;//	ROW 1, 2 RROW ONLY
				// PROFILE , STATS, GUN ROW 1 HAS 2 COL. COL 01 PROFILE
				echo "<div class='border_blue col-md-4 col-xs-4'>" ; // cold 1 row 1
					echo "<div class='row'>" ;
						echo "<div class ='divRankth col-md-3 col-xs-3 '>";
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
						echo "<div name='profile_pic' class ='divRankth col-md-9 col-xs-9'>";
							echo "<img class='profileIMG' src='http://graph.facebook.com/".$user->facebookID."/picture?type=large'/>";

						echo "</div>";
					echo "</div>";
					echo "<div class='row paddingTop50'>" ;
						echo "<div class='center'><img class='titleImg ' src='".$user->getTitleImg()."'/></div>";
						echo "<div class=' fontTitle center'><b>".$user->getTitle()."</b></div>";
					echo "</div>";
					echo "<div class='row'>" ;
						echo "<div class='divNameTextLarge fontGold paddingTop10'>".$user->nickname."</div>";
					echo "</div>";	
				echo "</div>"; // end COL 01
				
				//STAT CONTAINER COL 02 STAT SUMARY & GUN
				echo "<div class=' col-md-7 col-xs-7>" ;
					echo "<div class=' '>"; //geenral row
						echo "<div class='row stats_container col-md-12 col-xs-12'>" ;
							echo "<div class ='col-md-5 col-xs-5 right'>";
								echo "<div class='row fontTitleField paddingTop10'>"."KILLS"."</div>";
								echo "<div class='row fontTitle fontSize25'>".  $user->nKill."</div>";
								echo "<div class='row fontTitleField  paddingTop10'>"."DEATHS"."</div>";
								echo "<div class='row fontTitle fontSize25'>".$user->nDeath."</div>";
								echo "<div class='row fontTitleField paddingTop10'>"."HEADSHOTS%"."</div>";
								echo "<div class='row fontTitle fontSize25'>".(round ($user->nHeadShot/($user->nShotNoHead+$user->nHeadShot)*100,0))."%"."</div>";
							echo "</div>";
							echo "<div class ='divRankth col-md-7 col-xs-7'>";
								echo "<div class='circleBorder'>";
									echo "<div class='fontTitleField paddingTop20'>KD Ratio</div>";
									echo "<div class ='row divRatioText fontSize45 paddingTop20'>".$user->KDratio."</div>";
								echo "</div>";
							echo "</div>";
						echo "</div>"; //stats_container
						echo "<div class='row gun_stats_container col-md-12 col-xs-12'>" ;
							echo "<div class ='col-md-5 col-xs-5 right '>";
								echo "<div class='row fontTitleField paddingTop10'>"."MOST USED"."</div>";
								echo "<div class='row left paddingLeft25 '>";
									echo "<img class ='gunIcon ' src='lib/icon_" .$most_frequent_gun. ".png'/>";
								echo "</div>";
								echo "<div class='row fontTitle fontSize25 left paddingLeft10'>".$lookupGun[$most_frequent_gun]."</div>";
							echo "</div>";
							echo "<div class ='divRankth col-md-6 col-xs-6'>";
								echo "<div class='circleBorderSmall'>";
									echo "<div class ='row divRatioText fontSize30 paddingTop20'>".(round(max($count_values_gun)/(count ($user->listUsed))*100,0))."%</div>";
								echo "</div>";
								echo "<div class='fontTitle'>";
									echo (max($count_values_gun))." <img class='xIcon' src='x.png'/>";
										$mostUsedHeadShot = 0;
										
										if ($user->nHeadShot>0){
											$counts = array_count_values($user->listGunHeadShot);
											if (in_array($most_frequent_gun,$user->listGunHeadShot))
												$mostUsedHeadShot = $counts[$most_frequent_gun];
										}
									echo "&#8195;&#8195;".(round($mostUsedHeadShot/($user->nShotNoHead+$user->nHeadShot)*100,0))."% <img class='xIcon' src='head.png'/>";
								echo "</div>";
							echo "</div>";
						echo "</div>"; // gun_stats_container
					echo "</div>"; // general row

				echo "</div";// end col 2
				
			echo "</div>"; // END ROW 1	

			echo "<div class='row'>" ;//	ROW 1, 2 RROW ONLYư
			echo "<div class='col-md-12 col-xs-12'>";
				// PROFILE , STATS, GUN ROW 1 HAS 2 COL. COL 01 PROFILE
				echo "<div class='favoriteWeapon col-md-4 col-xs-4'>" ; // cold 1 row 1
					echo "<table  width='100%'>";
					echo "<tr class = ''>";
								echo "<td colspan='2'>";
								echo "<div class='fontTitleField'>FAVORATE WEAPONS</div>";
								echo "</td>";
						echo "</tr>";
						echo "<tr class = 'backgroundGray'>";
								echo "<td colspan='3'>";
								echo "<img class ='mostUsedGun' src='lib/Weapon_" .array_keys ($count_values_gun)[0]. ".png'/>";
								echo "</td>";
						echo "</tr>";
					echo "<tr class = 'topGun backgroundGray'>";
								echo "<td class= 'fontSize25 ' colspan='2' >";
								echo ($lookupGun[array_keys ($count_values_gun)[0]]);
								echo "</td>";
								echo "<td class= 'fontSize25 right colorBlue' width='70'>";
								echo (array_values ($count_values_gun)[0]). "<img class='xIcon' src='x.png'/>";
								echo "</td>";
						echo "</tr>";
					for ($i=1; $i < 6; $i++){
						echo "<tr class = 'topGun'>";
								echo "<td>";
								echo "<img class ='gunIconSmall' src='lib/icon_" .array_keys ($count_values_gun)[$i]. ".png'/>";
								echo "</td>";
								echo "<td  >";
								echo ($lookupGun[array_keys ($count_values_gun)[$i]]);
								echo "</td>";
								echo "<td class = 'right'  >";
								//$counts = array_count_values($user->listGunHeadShot);
								//if (in_array(array_keys ($count_values_gun)[$i],$user->listGunHeadShot))
								//	$mostUsedHeadShot = $counts[array_keys ($count_values_gun)[$i]];
								echo (array_values ($count_values_gun)[$i]);
								echo "</td>";
						echo "</tr>";
					}
					echo "</table>";
				echo "</div>"; // end COL 01
				
				//STAT CONTAINER COL 02 STAT SUMARY & GUN
				echo "<div class=' col-md-7 col-xs-7>" ;
					echo "<div class=' '>"; //geenral row
						echo "<div class='row  col-md-12 col-xs-12 rankChartSmall'>" ;
						include ('RankChart.html');
					echo "</div";// end col 2
				echo "</div>";
			echo "</div>"; // END ROW 2	
		echo "</div>"; // END ROW 2	
		
		echo "<div class='col-md-11 col-xs-11 awardContainer'>";
				echo "<div class='fontTitleField'>AWARDS:</div>";
				for ($i=0; $i<2;$i++)
					echo "<div class='fontNormal fontSize15 paddingTopBottom5' >- Expert ".($lookupGun[array_keys ($count_values_gun)[$i]])." </div>";
		echo "</div>";
					
		echo "</div>"; // end of bouder
		// ROW AWARD
		

	?>
