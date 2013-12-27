<?
    require("php/PHPMailerAutoload.php"); 
  
    $file = "";
    $accessKey = "";
    $secretKey = "";
    $signpath = '//'.$file;
    date_default_timezone_set('America/New_York');

    $username = "";
    $password = "";
    $hostname = ""; 

    //connection to the database
    $connection = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
    mysql_select_db("surfing", $connection);

    function el_crypto_hmacSHA1($key, $data, $blocksize = 64) {
        if (strlen($key) > $blocksize) $key = pack('H*', sha1($key));
        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack( 'H*', sha1(
        ($key ^ $opad) . pack( 'H*', sha1(
          ($key ^ $ipad) . $data
        ))
      ));
        return base64_encode($hmac);
    }

    function getSignature($expires) {
      global $signpath, $secretKey, $file;
      $signsz = implode("\n", $pieces = array('GET', null, null, $expires, $signpath));
      $signature = el_crypto_hmacSHA1($secretKey, $signsz);
      return $signature;
    }

    function sendEmail($email,$name,$body,$link){


        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'ssl://smtp.gmail.com:465';
        $mail->SMTPAuth = TRUE;
        $mail->Username = "info@surfingstrange.com"; // Change this to your gmail adress
        $mail->Password = "salinas2013"; // Change this to your gmail password
        $mail->FromName = "Swearin'";
        $mail->Subject    = "Purchase of Surfing Strange";
        $mail->IsHTML(true);

        $today = time();
        $event = mktime(0,0,0,11,4,2013);
        $countdown = round(($event - $today)/86400);

          $mail->Body = "<p><b>Thanks for buying 'Surfing Strange'!</b><br />Download is available for 24 hours after you download it.</p><p><a href='{$link}'>DOWNLOAD SURFING STRANGE</a></p><p>-Swearin'</p>";

        $mail->AddAddress($email, $name);

        if(!$mail->Send())
          error_log("There has been a mail error sending to ".$email); 
        else
          error_log("Yay!");
     

    }

    function redirectLink($expires, $signature){
      global $accessKey, $file;
      $qs = http_build_query($pieces = array(
        'AWSAccessKeyId' => $accessKey,
        'Expires' => $expires,
        'Signature' => $signature,
      ));
      echo $expires ." ".time().$signature;
      if($expires<time()){
        header("Location: http://surfingstrange.com/?expired=".$expires);
      }else{
        mysql_query("UPDATE purchase SET purchase_downloads = purchase_downloads+1 WHERE purchase_signature='{$signature}'");
        header("Location: http://iymistore.s3.amazonaws.com/{$file}?{$qs}");
      }


      return;
    }


?>