<?php // Whistle BOX // ?>
<?php echo " <?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>D&eacute;pot R&eacute;ussi!</title>
<link rel="shortcut icon" href="img/favicon3.png">
<link href="css/text.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="Txt">
     <p><img src="img/WBoxLogo.png" width="230" height="203" /></p>
     <h1>
<?php 
error_reporting(E_ALL | E_STRICT);

$dossier = './depot/Documents/';
$ip = $_SERVER['REMOTE_ADDR'];
$time = $_SERVER['REQUEST_TIME'];
$prefix = md5($ip.$time);
$my_file = 'Counter.txt';
$name = $time."-".$prefix;
if(is_file($my_file)){
$handle = fopen($my_file, 'r');
$num = fread($handle,filesize($my_file));
if($num > "5")	
	{
		Die('Trop de téléchargement de fichier, réessayez dans quelques minutes');
	}
	else
	{
		$num++;
		fwrite($handle,$num);
		fclose($handle);
	}
		
}
else
{
	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
	fwrite($handle,"1");
	fclose($handle);
}
if(is_dir($dossier))
{
//echo "Le dossier est reconnu<br>";
} 
else
{
//echo "Le dossier n'est pas recnnu<br>";
}
$extensions = array('.ppt','.txt','.xlsx','.xls','.docx','.doc','.pdf','.png', '.gif', '.jpg','.pptx','.jpeg');
$extension = strrchr($_FILES['filename']['name'], '.'); 
	if (isset($_POST['filename']))
		$fichier= $_POST['filename'];
	else
		$fichier = basename($_FILES['filename']['name']);
//$taille_maxi = $_POST['MAX_FILE_SIZE'];
$taille = filesize($_FILES['filename']['tmp_name']); 
$taille_maxi =100000000;
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
    $erreur = 'Vous devez envoyer un fichier de type png, gif, jpg, jpeg, txt, docx, xlsx, xls, ppt, pptx, pdf ou doc. <br><a href="https://depot.enqueteouverte.info/index.html">Ajoutez un autre fichier</a>';
}
if($taille>$taille_maxi)
{
    $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
    //On formate le nom du fichier ici...
    $fichier = strtr($fichier, 
 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
/*    foreach ($_FILES["filename"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["filename"]["tmp_name"][$key];
        $name = $_FILES["filename"]["name"][$key];
        move_uploaded_file($tmp_name, "$dossier$name");
    	echo "Fichier chargé";
	}
	else
	{
	echo "Erreur : ".$error;
	}
}*/
	if(move_uploaded_file($_FILES['filename']['tmp_name'], $dossier.$fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
    {
	
 	$my_file = $name;
        $handle = fopen($dossier.$my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates filsier .
	$data = "Adresse IP: ".$ip."\nDate et heure de dépot :".$time."\nNom du fichier : ".$_FILES['filename']['name']."\n";
	//$data .= "MD5 du fichier :". md5_file($_FILES['filename']['tmp_name'])."\n";
	$data .= $_POST['description'];

	fwrite($handle, $data);
	fclose($handle);?>
	<h1> L'envoi du fichier <?=$fichier?> a &eacute;t&eacute; effectu&eacute; <span style="text-decoration: underline;">avec succ&egrave;s</span>.</h1><br> 
     <p>La r&eacute;daction y travaille tr&egrave;s vite!</p><br>
     <h6> &nbsp; </h6>
     <p><a href="http://5yxwhqy452sppfun.onion/http/">D&eacute;posez un autre fichier</a></p>
    <?php }
    else //Sinon (la fonction renvoie FALSE).
    {
 	echo 'Echec de l\'upload ! : '.$fichier;
	$fsize = $_FILES["filename"]["size"];
	if ($fsize == 0) echo '<br>Le fichier a une taille trop importantee.<br> <a href="https://depot.enqueteouverte.info/index.html">Ajoutez un autre fichier</a>';
	echo '\n<br>File size : '.$fsize;
	/*
	  echo "<br>Message pour le traitement de l\'erreur (_POST): <pre>";
          var_dump($_POST);
          echo "<hr><br>Extension : <br>";
          //var_dump($extension);
          echo "<hr>";
          //var_dump($_FILES);
          echo "<hr>";
          echo "Nom de fichier : ". $_FILES['filename']['name'] ."<br>";
         echo "Extension : ". strchr($_FILES['filename']['name'],".") ."<br> Extensions : <br>";
         var_dump($extensions);
          echo "</pre>";
         */
          //echo $erreur;
	}
}
else
{
    	//echo "<pre>";
	//var_dump($_POST);
	echo "<hr><br>Extension : <br>";
	//var_dump($extension);
	//echo "<hr>";
	//var_dump($_FILES);
	//echo "<hr>";
	echo "Nom de fichier : ". $_FILES['filename']['name'] ."<br>";
	echo "Extension : ". strchr($_FILES['filename']['name'],".") ."<br>";
	//var_dump($extensions);
	//echo "</pre>";
	
	echo $erreur;
}

 ?>
<h3>&nbsp;</h3>
     <h1>> Envoyez un <span style="text-decoration: underline;">message encrypt&eacute;</span> &agrave; nos journalistes :</h1><br>
     <h6> &nbsp; </h6>
     <h3><a href="message.php?dest=anne@enqueteouverte.info">Anne De Malleray</a></h3>
     <p> &nbsp; </p>
     <h3><a href="message.php?dest=sylvain@enqueteouverte.info">Sylvain Lapoix</a></h3>
</div>
</body>
</html>
