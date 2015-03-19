<?php

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
    $key_id = $_POST['key_id'];
    $keyserver = "hkps.pool.sks-keyservers.net";
    $req = "http://$keyserver/pks/lookup?search=".$key_id."&fingerprint=on&op=get";
       
$result = get_web_page( $req );

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
//echo "\ngnupg_init RTV = <br/><pre>\n";
//var_dump($res);
//echo "</pre>\n";
$rtv = gnupg_import($res, $pubkey);
//echo "gnupg_import RTV = <br/><pre>\n";
//var_dump($rtv);
//echo "</pre>\n";
$fingerprint =  $rtv['fingerprint'];
if (gnupg_addencryptkey($res,$fingerprint))
$enc = gnupg_encrypt($res, "just a test to see if anything works");

//echo "Encrypted Data: " . $enc . "<br/>";
echo "\n<br>File name : ".$_FILES["file"]["name"];
//echo "\n<br>Type du fichier : ".$_FILES["file"]["type"];
//echo "\n<br>Taille du fichier :".$_FILES["file"]["size"];
$allowedExts = array("csv","txt","xlsx","xls","docx","doc","pdf","gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
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
&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    //echo "Type: " . $_FILES["file"]["type"] . "<br>";
    //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    $src = file_get_contents($_FILES["file"]["tmp_name"]);
    $dest = gnupg_encrypt($res,$src);
    file_put_contents("fichiers/Documents/".$_FILES["file"]["name"].".pgp",$dest);
    echo '<br>MD5 file hash of encrypted file ' . $file . ': ' . md5_file("fichiers/Documents/".$_FILES["file"]["name"].".pgp");
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    if (file_exists("fichiers/Documents/" . $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
      //move_uploaded_file($_FILES["file"]["tmp_name"],"fichiers/Documents/" . $_FILES["file"]["name"]);
      echo "\n<br>File stored successfully.";
	//echo "File stored in: " . "fichiers/Documents/" . $_FILES["file"]["name"];
    }
  }
} else {
echo "<br> Sadly the file could ot be uploaded. Please retry.";
echo "\n<br>File name : ".$_FILES["file"]["name"];
echo "\n<br>Type du fichier : ".$_FILES["file"]["type"];
echo "\n<br>Taille du fichier :".$_FILES["file"]["size"];
echo "\n<br>Invalid file : ".$_FILES["file"]["name"];
}
?>
