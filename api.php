<!---
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
     <h1>-->
<?php 
include 'config.php';
$allowedExts = array("csv","txt","xlsx","xls","docx","doc","pdf","gif", "jpeg", "jpg", "png");

/**
     * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
     * array containing the HTTP server response header fields and content.
     */
       function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $keyserver = "hkps.pool.sks-keyservers.net";
       
        

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );
        //print_r($options);
        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );
        //echo "\nContent : \n".$content;
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }


//Read a web page and check for errors:
    //$key_id = $_POST['key_id'];
$keyserver = "hkps.pool.sks-keyservers.net";
$req = "http://$keyserver/pks/lookup?search=".$key_id."&fingerprint=on&op=get";
$result = get_web_page( $req );
$pubkey = "";
putenv("GNUPGHOME=/tmp");
if ( $result['errno'] != 0 )
   echo "00 --> ";

if ( $result['http_code'] != 200 )
  echo "Erreur ... ";

$page = $result['content'];
if (stripos ( $page , "-----BEGIN PGP PUBLIC KEY BLOCK-----"))
	$pubkey = stristr ( $page , "-----BEGIN PGP PUBLIC KEY BLOCK-----");
else
	echo "Encryption : Email or KeyId could not be found. File will not be encrypted.";
$res = gnupg_init();
$rtv = gnupg_import($res, $pubkey);
$fingerprint =  $rtv['fingerprint'];
if (gnupg_addencryptkey($res,$fingerprint))
    $enc = gnupg_encrypt($res, "just a test to see if anything works");


if ($_FILES["file"]["size"]!=0)
    {
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        if (((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "text/plain")
        || ($_FILES["file"]["type"] == "application/pdf")
        || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
        || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
        || ($_FILES["file"]["type"] == "application/vnd.ms-excel")
        || ($_FILES["file"]["type"] == "application/vnd.ms-word")
        || ($_FILES["file"]["type"] == "application/msword")
        || ($_FILES["file"]["type"] == "text/csv")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/x-png")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 50000000)
        && in_array($extension, $allowedExts)) 
        OR ($_POST['description']!=""))
    	   { 
            //Le Fichier est dans le bon format
            if ($_FILES["file"]["error"] > 0) 
                {
                    echo "Erreur N° " . $_FILES["file"]["error"] . "<br>";
                    echo "setted file : ".isset($_FILES);
                    echo "\n<br>Type du fichier : ".$_FILES["file"]["type"];
                    echo "\n<br>Taille du fichier :".$_FILES["file"]["size"];
                    echo "\n<br>Fichier invalide : ".$_FILES["file"]["name"];
                } 
            else 
                {  //Fichier correct
        		$name = $_FILES["file"]["tmp_name"];
        		$src = file_get_contents($_FILES["file"]["tmp_name"]); 
         		$dest = gnupg_encrypt($res,$src);
        		file_put_contents("Documents/".$_FILES["file"]["name"].".pgp",$dest); 	
        		$dest = gnupg_encrypt($res,$_POST['description']);
        		file_put_contents("Documents/Message-".$_FILES["file"]["name"].".txt.pgp",$dest);
        		echo '<br>MD5 file hash of encrypted file ' . $file . ': ' . md5_file("Documents/".$_FILES["file"]["name"].".pgp");
                if (file_exists("Documents/" . $_FILES["file"]["name"])) 
                    {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } 
                else 
                    {
                		echo '<?xml version="1.0" encoding="UTF-8"?>';
                		?>
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
                       			<h1> L'envoi du fichier a &eacute;t&eacute; effectu&eacute; <span style="text-decoration: underline;">avec succ&egrave;s</span>.</h1><br> 
                		<?php
                     			echo '<p>Hashage MD5 de ' . $file . ': ' . md5_file("Documents/".$_FILES["file"]["name"].".pgp").'</p>';
                		?>
                				<p>La r&eacute;daction y travaille tr&egrave;s vite!</p><br>
                     			<h6> &nbsp; </h6>
                     			<p><a href="/depotAL.html">D&eacute;posez un autre fichier</a></p>
                     			<h3>&nbsp;</h3>
                     			<h1> Envoyez un <span style="text-decoration: underline;">message encrypt&eacute;</span> &agrave; nos journalistes :</h1><br>
                				</div>
                				</body>
                				</html>
                		<?php    
                    }
                }
            }
            else 
            {
                echo "<br> Attention votre fichier n'a pas pu chargé.";
                echo "\n<br>Fichier : ".$_FILES["file"]["name"];
                echo "\n<br>Type du fichier : ".$_FILES["file"]["type"];
                echo "\n<br>Taille du fichier :".$_FILES["file"]["size"];
                echo "\n<br>Fichier invalide : ".$_FILES["file"]["name"];
            }
        }
    else
    {
		//Pas de fichiers
		$dest = gnupg_encrypt($res,$_POST['description']);
		file_put_contents("Documents/Message.".date('Y-m-d-h-i-s').".txt.pgp",$dest);
        echo '<?xml version="1.0" encoding="UTF-8"?>';
                        ?>
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
                                <h1> L'envoi du Message a &eacute;t&eacute; effectu&eacute; <span style="text-decoration: underline;">avec succ&egrave;s</span>.</h1><br> 
                    
                                <p>La r&eacute;daction y travaille tr&egrave;s vite!</p><br>
                                <h6> &nbsp; </h6>
                                <p><a href="/depotAL.html">D&eacute;posez un autre fichier</a></p>
                                <h3>&nbsp;</h3>
                                </div>
                                </body>
                                </html>
                        <?php   
    }
   


?>
