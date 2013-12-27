<?

	include("php/functions.php");
	
	$code = $_GET["code"];
	if($_POST["txn_id"])
		$code = $_POST["txt_id"];

	if($code){
  		$sql = "SELECT * FROM purchase WHERE purchase_txn='{$code}'";
  		$result = mysql_query($sql);
	  	$myrow = mysql_fetch_array($result);
	  	
	  	if($myrow["purchase_expire"]=="1" ){
	  		$expiration = time() + intval(60 * 60 * 24);
	  		$signature = getSignature($expiration);
	  		$myrow["purchase_expire"]=$expiration;
	  		$myrow["purchase_signature"]=$signature;
	  		mysql_query("UPDATE purchase SET purchase_expire=
	  			'{$expiration}' , purchase_signature='{$signature}' WHERE purchase_txn='{$code}'");
	  		
  		}
  		redirectLink($myrow["purchase_expire"],$myrow["purchase_signature"]);
  	}

 ?>
