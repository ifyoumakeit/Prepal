<?
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('log_errors', true);
    ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');
    date_default_timezone_set('America/New_York');
    
    require("PHPMailerAutoload.php"); 
    require("ipnlistener.php");
    
    //-------------------------------------------------------//


    class PurchasePal extends IpnListener {

        //Download 
        public $dl_site = "http://store.ifyoumakeit.com";
        public $dl_title = "Surfing Strange MP3";
        public $dl_artist = "Swearin'";
        public $dl_paypal = "admin@ifyoumakeit.com";
        public $dl_price = 7;
        public $dl_hours = 24;

        //Amazon S3
        public $S3_access = "AKIAI3CC4FM6WHB2NEUQ";
        public $S3_secret = "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";
        public $S3_path = "/iymistore/swearin-surfing-strange.zip";

        //MYSQL
        public $mysql_user = "strange";
        public $mysql_pass = "salinas2013";
        public $mysql_host = "localhost"; 
        public $mysql_db = "surfing";

        //EMAIL
        public $email_username = "info@surfingstrange.com";
        public $email_password = "salinas2013";

        //COUNTRIES
        public $countries = array("US","MX","CA");
        public $user, $purchase;

        private $error = "I'm sorry there was a problem with your order.";

        public function __construct($txn="")  
        {
          $connection = mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass) or die("Unable to connect to MySQL");
          mysql_select_db($this->mysql_db, $connection);

          $this->user = new User();      
          $this->user->valid_country = $this->user->checkIP($this->countries);

          $this->purchase = new Purchase($txn);
          $this->purchase->txn = $txn;

          if($txn!="")
            $this->purchase->getByCode($txn);       
        }

        public function encrypt($key, $data, $blocksize = 64) 
        {
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

        public function sendEmail(){

          $mail = new PHPMailer;
          $mail->IsSMTP();
          $mail->Host = 'ssl://smtp.gmail.com:465';
          $mail->SMTPAuth = TRUE;
          $mail->Username = $this->email_username; // Change this to your gmail adress
          $mail->Password = $this->email_password; // Change this to your gmail password
          $mail->FromName = $this->dl_artist;
          $mail->Subject   = "Purchase of {$this->dl_title}";
          $mail->IsHTML(true);
          
          if($this->user->success)
            $mail->Body = $this->printDownload();
          else
            $mail->Body = "I'm sorry, there was an error";

          $mail->AddAddress($this->user->email, $this->user->name);

          if(!$mail->Send())
            error_log("There has been a mail error sending to {$this->user->email}"); 
          else
            error_log("Email sent to {$this->user->email}"); 

        }

        public function redirectLink(){
            
            $qs = http_build_query($pieces = array(
              'AWSAccessKeyId' => $this->S3_access,
              'Expires' => $this->purchase->expiration,
              'Signature' => $this->getSignature()
            ));

            if($this->purchase->expiration==1)
                $this->purchase->resetExpiration($this->dl_hours);

            if($this->purchase->expiration<time()){
                echo 'header("Location: {$this->dl_site}?expired={$this->purchase->expiration}")';
            }else{
                
                $this->purchase->incrementDownloads();
                echo 'header("Location: http://s3.amazonaws.com{$this->S3_path}?{$qs}")';
            }
            return;
        }

        public function getSignature() {
          $signsz = implode("\n", $pieces = array('GET', null, null, $this->purchase->expiration, $this->S3_path));
          return $this->encrypt($this->S3_secret, $signsz);
        }

        public function printDownload(){

            return "<p>
              <b>Thanks for buying '{$this->dl_title}'!</b>
              <br />Download is available for 24 hours after you download it.
            </p>
            <p>
              <a href='{$this->dl_site}/get/{$this->purchase->txn}'>DOWNLOAD {$this->dl_title}</a>
            </p>
            <p>-{$this->dl_artist}</p>";
        }

        public function printExpired(){
           return "<h1>Expired</h1><p>Your download expired on ".date('l dS \o\f F Y h:i:s A', $_GET["expired"])."</p>";
        }

        public function createForm(){
             return "<form method='post' action='https://www.sandbox.paypal.com/cgi-bin/webscr' target='_top'>
                                <input type='hidden' name='button' value='cart'>
                                <input type='hidden' name='item_name' value='{$this->dl_artist} - {$this->dl_title}'>
                                <input type='hidden' name='amount' value='{$this->dl_price}'>
                                <input type='hidden' name='shipping' value='0'>
                                <input type='hidden' name='tax' value='0'>
                                <input type='hidden' name='notify_url' value='{$this->dl_site}/paypal/'>
                                <input type='hidden' name='return' value='{$this->dl_site}'>
                                <input type='hidden' name='rm' value='2'>
                                <input type='hidden' name='cmd' value='_cart'>
                                <input type='hidden' name='add' value='true'>
                                <input type='hidden' name='business' value='{$this->dl_paypal}'>
                                <input type='hidden' name='env' value='www'>
                                <button type='submit' class='paypal-button'>BUY FOR  $&#36;{$this->dl_price}</button>
                            </form>";

        }

        public function invalidCountry(){
            return '<blockquote><em>Download not available in your country. Please download from iTunes or visit <a href="http://shop.wichita-recordings.com/DigitalProduct.aspx?rid=682&fid=12&brid=5" target="_blank">Wichita</a> to purchase.</em>
                        <hr />

                    Please email info@surfingstrange.com with your IP : <?=$cip?>, if this is an error.</blockquote>';
        }


        public function logError($error){
          error_log($error);
        }
    }


    Class Purchase {
        public  $id,
                $txn,
                $bought,
                $expiration,
                $downloads,
                $success;

        public function setPublic($arr){

            $nameMap = array(
               'id',
               'txn',
               'bought',
               'expiration',
               'downloads',
               'success'
            );
            foreach( $nameMap as $attributeName ) {
              echo $this->$attributeName ." ".$arr->$attributeName;
              $this->$attributeName  = $arr->$attributeName;
            }
        }

        public function save($arr,$success){

            extract($arr);
            $this->txn = $txn_id;
            $this->success = $success;
            $this->bought = strtotime($payment_date);

            $sql = "INSERT INTO pp_purchase VALUES (null, '{$this->user->name}', '{$this->user->email}', '{$this->user->bought}', 1,'{$this->purchase->txn}',0,'{$this->purchase->success}')";
            $result = mysql_query($sql);

        }

        public function update(){

            $list = "";
            foreach ($this AS $key => $value){
              if($value!="")
                $list .=" {$key} = {$value},";
            }

            $sql = "UPDATE pp_purchase SET {$list} WHERE txn = {$this->txn}";
        }

        public function getByID($id){

              $sql = "SELECT * FROM pp_purchase WHERE id='{$id}'";
              $result = mysql_query($sql);
              $myrow = mysql_fetch_object($result);
              $this->setPublic($myrow);

        }

        public function getByCode($code){

              $sql = "SELECT * FROM pp_purchase WHERE txn='{$code}'";
              $result = mysql_query($sql);
              $myrow = mysql_fetch_object($result);
              $this->setPublic($myrow);
        }     

         public function resetExpiration($hours=24){
                $this->expiration = time()+ intval(60*60*$hours);                
                $this->update();           
        }

        public function incrementDownloads(){
              $this->downloads++;
              $this->update;
        }
    }

     Class User {
        public  $id,
                $name,
                $email,
                $valid_country,
                $cip;

        public function __construct()  
        {
            
        }

        public function setPublic($arr){

            $nameMap = array(
               'id',
               'name',
               'email',
               'valid_country',
               'cip'
            );
            foreach( $nameMap as $attributeName ) {
              $this->$attributeName  = $arr->$attributeName;
            }
        }

        public function save($arr,$success){

            extract($arr);
            $this->user->email = $payer_email;
            $this->user->name = $first_name." ".$last_name;

            $sql = "INSERT INTO pp_user VALUES (null, '{$this->user->name}', '{$this->user->email}', '{$this->user->bought}', 1,'{$this->purchase->txn}',0,'{$this->purchase->success}')";
            $result = mysql_query($sql);

        }

        public function checkIP($countries){

          if (isset($_SERVER['HTTP_CLIENT_IP'])) 
            $this->user->cip=$_SERVER['HTTP_CLIENT_IP']; 
          else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
            $this->user->cip=$_SERVER['HTTP_X_FORWARDED_FOR'];
          else 
            $this->user->cip=$_SERVER['REMOTE_ADDR'];
            
            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$this->user->cip}"));   
            
            if($ip_data && $ip_data->geoplugin_countryName != null){
              if(in_array($ip_data->geoplugin_countryCode,$countries))
                return true;
            }

            return false;
        }
    }
?>