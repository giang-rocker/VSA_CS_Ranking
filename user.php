<?php
//include_once("./database.php");


class User {
    public $userId;
    public $username;
    public $nickname;
    public $lvl; // rank
    public $title; // rank
    public $exp; // = nKill
    public $KDratio;
    public $nKill;
    public $nDeath;
    public $mostUsed; // most used weapon
    public $mostKilled; // user that this user kill the most
    public $rankingScore;  // score = KDRatio*EXP/maxEXP
    public function __construct() {
        $this->username = "";
        $this->nickname = "";
    }
    public function setInfo($userId, $userName, $nickname, $nKill, $nDie) {
         $listGun = ["knife","glock","usp","p228","deagle","fn57","elites","m3","xm1014","tmp","mac10","mp5","ump45",
                                "p90","galil","famas","ak47","m4a1","sg552","aug","scout","sg550","awp","g3sg1","m249"];
        $lookupGun = [
            "knife"=>"KINFE",
            "glock"=>"Glock18",
            "usp"=>" USP .45",
            "p228"=>"SIG P228",
            "deagle"=>"Desert Eagle",
            "fn57"=>"FN Five-Seven",
            "elites"=>"Dual Beretta",
            "m3"=>"Benelli M3",
            "xm1014" => "Benelli XM1014",
            "tmp"=>"Tactical Machine Pistol",
            "mac10"=>"Ingram MAC-10",
            "mp5"=>"MP5-Navy",
            "ump45"=>" UMP45",
            "p90"=>"FN P90",
            "galil"=>"IMI Galil",
            "famas"=>"FAMAS",
            "ak47"=>"AK=47",
            "m4a1"=>"M4a1",
            "sg552"=>"Sig SG-552",
            "aug"=>"Steyr Aug",
            "scout"=>"Steyr Scout",
            "sg550"=>"Sig SG-550 Sniper",
            "awp"=>"AWP Magnum",
            "g3sg1"=>"G3SG1",
            "m249"=>"M249 "
        ];
        
        $nGun = count ($listGun);

        $this->userId = $userId;
        $this->username = $userName;
        $this->nickname = $nickname;
        $this->mostUsed =  $listGun[rand(0,$nGun-1)];
        $this->mostKilled = "Nobita";  // random at the moment
        $this->nKill = $nKill;
        $this->nDeath = $nDie;
        $this->exp = $nKill;
    }
    public function setKDRatio() {
      # also update EXP
       $this->exp = $this->nKill;

        if ($this->nDeath == 0) return 0;
        $this->KDratio = round($this->nKill / $this->nDeath, 2);
        return $this->KDratio;
    }
    public function calculateLvl() {
        $listTitle = ["Silver I", "Silver II", "Silver III", "Silver IV", "Silver Elite", "Silver Elite Master", "Gold Nova I", "Gold Nova II", "Gold Nova III", "Gold Nova Master", "Master Guardian I", "Master Guardian II", "Master Guardian Elite", "Distinguished Master Guardian", "Legendary Eagle", "Legendary Eagle Master", "Supreme Master First Class", "The Global Elite", ];
        $lookupEXP = [0, 5, 15, 30, 50, 75, 105, 140, 180, 225, 275, 330, 390, 455, 525, 600, 680, 765]; // generated by rankingSample()  wwith step   = 7
        $lvl = 0;
        $nLevel = 17;
        if ($this->exp > $lookupEXP[$nLevel]) {
            $this->lvl = $nLevel;
        } else {
            for ($lvl = 0;$lvl < $nLevel;$lvl++) if ($this->exp < $lookupEXP[$lvl]) break;
        }
        $this->title = $listTitle[$lvl];
        $this->lvl = $lvl;
    }

    
    public function getTitle() {
        return $this->title;
    }
    public function getTitleImg() {
        $urlIMG = "lib/";
        $urlIMG.= $this->lvl;
        return $urlIMG . ".jpg";
    }

    public function getWeaponImg() {
    
        $urlIMG = "lib/Weapon_";
        $urlIMG.= $lookupGun[$this->mostUsed];
        return $urlIMG . ".jpg";
    }
    public function print () {
        echo "ID: " . $this->userId . "</br>";
        echo "username: " . $this->username . "</br>";
        echo "nickName: " . $this->nickname . "</br>";
        echo "nKill: " . $this->nKill . "</br>";
        echo "nDeath: " . $this->nDeath . "</br>";
        if ($this->nDeath != 0) echo "KDratio: " . round($this->nKill / $this->nDeath, 2) . "</br>";
    }
}
?>

<?php
#process database
// also as init for those weeks has no log
function readListUser(&$listUserName, $fileName = "listUser.txt") {
    //$listUser = array();
    $mapping = array();
    if (($handle = fopen($fileName, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $user = new User();
            //$data = str_replace(" ", "",$data);
            $user->setInfo($data[0], $data[1], $data[2], $data[3], $data[4]); // 3 fiels ID, name, nickname
            //$listUser[] = $user;
            $listUserName[] = $user->nickname;
            $mapping[$user->nickname] = $user;
        }
        fclose($handle);
    }
    //var_dump($listUserName);
    //var_dump( $mapping["Minh"]);
    return $mapping;
}
function printListUser($mappingUser, $listUserName) {
    $n = count($mappingUser);
    for ($i = 0;$i < $n;$i++) {
        $user = $mappingUser[$listUserName[$i]];
        $user->print();
        echo "</br>";
    }
}
// processLogfile save to Match File
function convertLogFileToMatchFile($fileLog) {
    $fileName = "log/" . $fileLog . ".log";
    $myfile = fopen($fileName, "r") or die("Unable to open file!");
    $keyword = "killed";
    $outMatchFileName = "log/" . $fileLog . ".match";
    $outMatchFile = fopen($outMatchFileName, "w");
    $i = 0;
    while (!feof($myfile)) {
        $line = fgets($myfile);
        if (strpos($line, $keyword) !== false) {
            // name, killed, name, name
            // process line by replace
            $line = str_replace("<CT>", "", $line);
            $line = str_replace("<TERRORIST>", "", $line);
            $line = str_replace("<STEAM_ID_LAN>", "", $line);
            $line = str_replace("<BOT>", "", $line);
            // test some name
            /*
            $line = str_replace("CSC| Moe","Nobita",$line);
            $line = str_replace("CSC| Kyle","BoiHetVaoDay",$line);
            $line = str_replace("CSC| Pheonix","Vu Vu",$line);
            $line = str_replace("CSC| Stone","CSC | Shinichi",$line);
            */
            for ($id = 0;$id < 30;$id++) $line = str_replace("<" . $id . ">", "", $line);
            // END OF
            list($time, $user, $killedWord, $killedUser, $with, $gun) = explode("\"", $line);
            //echo $i." ". $user.",".$killedWord.",".$killedUser.",".$with.",".$gun."<br>";
            fwrite($outMatchFile, $user . "," . $killedWord . "," . $killedUser . "," . $with . "," . $gun . "\n");
            $i++;
        }
    }
    fclose($myfile);
    fclose($outMatchFile);
}
// process all logFile To Match File
function processLogFiles() {
    $dir = 'log/';
    $listFile = scandir($dir, 1);
    $keyword = ".log";
    foreach ($listFile as $logFile) {
        if (strpos($logFile, $keyword) !== false) {
            //echo $logFile. "<br>";
            // get log name
            $logFile = str_replace(".log", "", $logFile);
            //create match file
            convertLogFileToMatchFile($logFile);
        }
    }
}
function updateRankingFromSingleMatchFile($matchFileName, &$mappingUser, $listUserName) {
    $matchFileName = "log/" . $matchFileName;
    $matchFile = fopen($matchFileName, "r") or die("Unable to open file!");
    while (!feof($matchFile)) {
        $line = fgets($matchFile);
        if (strlen($line) == 0) continue;
        list($user, $killedWord, $killedUser, $with, $gun) = explode(",", $line);
        if (in_array($user, $listUserName))  $mappingUser[$user]->nKill++;
        if (in_array($killedUser, $listUserName)) $mappingUser[$killedUser]->nDeath++;
    }
    fclose($matchFile);
}
function processRankingFromSingleMatch($mappingUser, $listUserName) {
    $dir = 'log/';
    $listFile = scandir($dir, 1);
    $keyword = ".match";
    foreach ($listFile as $matchFile) {
        if (strpos($matchFile, $keyword) !== false) {
            //echo $matchFile. "<br>";
            updateRankingFromSingleMatchFile($matchFile, $mappingUser, $listUserName);
        }
    }
}
function cmp($a, $b) {
    return ($a->rankingScore <= $b->rankingScore);
}
function ranking(&$mappingUser) {
    // update before ranking
    
    $maxEXP = -1;

    foreach ($mappingUser as $user) {
      $user->calculateLvl();
      $user->setKDRatio();

      if ($user->exp > $maxEXP )
        $maxEXP = $user->exp;
    }

     foreach ($mappingUser as $user) {
      $user->calculateLvl();
      $user->setKDRatio();

      if ($user->exp > $maxEXP )
        $maxEXP = $user->exp;
    }

     foreach ($mappingUser as $user) {
       $user->rankingScore = $user->KDratio*($user->exp*100.0/$maxEXP);
    }
   
    usort($mappingUser, "cmp");
}
function rankingSample() {
    $nLevel = 18;
    $stepEXP = 5;
    $total = 0;
    for ($i = 0;$i < $nLevel;$i++) {
        $dif = $i * $stepEXP;
        $total+= $dif;
        echo $total . ",";
    }
}
?>