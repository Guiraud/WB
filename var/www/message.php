<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" 
if ($_GET['s']=="")
	{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>D&eacute;pot s&eacute;curis&eacute; de Fichier</title>
<link rel="shortcut icon" href="img/favicon3.png">
<link href="css/text.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="Txt">
     <form method="POST" action="Message.php?s=<?=$_GET['dest']?>" enctype="multipart/form-data">
     <label for="description">
     <p><img src="img/WBoxLogo.png" width="230" height="203" /></p>
     <h1>Bonjour, vous &#234;tes maintenant dans une<br> <span style="text-decoration: underline;">zone de communication s&#233;curis&#233;e</span>.</h1><br> 
<p>Votre message  sera encrypt&#233; et envoy&#233;<br> &agrave; l'email du  journaliste : <?=$_GET['dest']?>.<br></p></label><br/>
     <label>
     <h2><span style="font-weight: bold;">Tapez votre message</span> (max. 2000 caract&#232;res):</h2>
     </label>
     <textarea maxlength="2000" style="max-height:480px; min-height:200px;min-width:580px;max-width:580px;" name="description" id="description"></textarea><br />
     <input type="submit" name="submit" value="Envoyer" id="envoi" />
     </form>
</div>
</body>
</html>
<?php 
}
else {
$testemail = $_POST['s'];
$emailsubject = "Encrypted Information";
$emailfrom = "From: mehdi@enqueteouverte.info;
$body = $_POST['description'];

//Tell gnupg where the key ring is. Home dir of user web server is running as.
putenv("GNUPGHOME=/var/www/.gnupg");

//create a unique file name
$infile = tempnam("/tmp", "PGP.asc");
$outfile = $infile.".asc";

//write form variables to email
$fp = fopen($infile, "w");
fwrite($fp, $body);
fclose($fp);

//set up the gnupg command. Note: Remember to put E-mail address on the gpg keyring.
$command = "/usr/bin/gpg -a --recipient 'Mehdi <mehdi@enqueteouverte.info>' \\
--encrypt -o $outfile $infile";

//execute the gnupg command
system($command, $result);

//delete the unencrypted temp file
unlink($infile);

if ($result==0) {
	$fp = fopen($outfile, "r");
	
	if(!$fp||filesize ($outfile)==0) {
	  $result = -1;
	}


else {
	//read the encrypted file
	$contents = fread ($fp, filesize ($outfile));
	//delete the encrypted file
	unlink($outfile);


	//send the email
	mail ($testemail, $emailsubject, $contents, $emailfrom);

	print "<html>Thank you for your information. Your encrypted E-Mail has been sent.</html>";

     } 


}

if($result!=0) {
     print "<html>Their was a problem processing the informaion. Please contact <a href=\"mailto:webmaster@here.com\">webmaster@here.com</a>.";
}
}
?>
