<?

	include("php/purchasepal.php");
	

	$code = $_GET["code"];
    if(isset($_POST["txn_id"]))
    	$code = $_POST["txt_id"];

	$pp = new PurchasePal($code);
	if($code){
		$pp->redirectLink();
  	}

 ?>
