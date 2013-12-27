<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

require("php/ipnlistener.php");
require("php/functions.php");


$listener = new IpnListener();
$listener->use_sandbox = false;

try {
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}

 $errmsg = '';

if ($verified) {
 	     
        extract($_POST);

        if($item_name1 == "Swearin' - Surfing Strange 320 MP3"){
            $timestamp = time();
            $expiration = time() + intval(60 * 60 * 24);
            $signature = getSignature($expiration);
            sendEmail($payer_email,$first_name." ".$last_name,"hey!","http://www.surfingstrange.com/get/{$txn_id}");
        

            $sql = "INSERT INTO purchase VALUES (null,'{$first_name} {$last_name}', '', '{$payer_email}', '{$timestamp}', 1,'{$txn_id}',0)";
            $result = mysql_query($sql);
            error_log($sql);
        } else {

            error_log($item_name1." ERROR!");
        }
    

} else {
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        error_log($body);
}

?>
!