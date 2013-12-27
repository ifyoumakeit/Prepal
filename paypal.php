<?php
    
    require("php/purchasepal.php");

    $pp = new PurchasePal();
    $pp->use_sandbox = true;

    try {
        $verified = $pp->processIpn();
    } catch (Exception $e) {
        $pp->logError($e->getMessage());
        exit(0);
    }

    $errmsg = '';

    if ($verified) 
        $pp->savePurchase($_POST,1);
    else 
        $pp->savePurchase($_POST,0);



    $pp->logError($pp->getTextReport());
    

?>
