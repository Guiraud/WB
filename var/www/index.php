<?php 
$redirect = 'OnionWebsite/redirectAL.html';
$file = "iplist.txt";
$searchfor = $_SERVER["REMOTE_ADDR"];;

$contents = file_get_contents($file);
$pattern = preg_quote($searchfor, '/');
$pattern = "/^.*$pattern.*\$/m";
//echo $_SERVER["REMOTE_ADDR"];
if(preg_match_all($pattern, $contents, $matches)){
	echo "<br>trouvé";
//echo $_SERVER["REMOTE_ADDR"];
header("Location: ".$redirect);
}
else{
 echo "pas trouvé"; 
//echo $_SERVER["REMOTE_ADDR"];
header("Location: InstallAL.html");
}
?>
