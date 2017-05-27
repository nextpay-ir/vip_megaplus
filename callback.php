<?php
include("../../../include/connect_api.php");
include("../../../include/function.php");

$root_url 				= "http://$_SERVER[HTTP_HOST]";
$bad_url 				= "http://$_SERVER[HTTP_HOST]/member/notcomplete";
$member_id 				= $_GET['id'];
$ok_url 				= "http://$_SERVER[HTTP_HOST]/member/complete?id=$member_id";

$nextpay_plugin_db 		= mysql_fetch_array(mysql_query("SELECT * FROM `plugin` where `type`='payment' and `patch`='nextpay'"));
$nextpay_payment_api 	= $nextpay_plugin_db['data_1'];
$nextpay_payment_url 	= $nextpay_plugin_db['data_7'];

$nextpay_member_db		 = mysql_fetch_array(mysql_query("SELECT * FROM `users` where `id`='$member_id'"));
$nextpay_user_id 		= $nextpay_member_db['id'];
$nextpay_user_cat 		= $nextpay_member_db['cat'];

$nextpay_cat_db 		= mysql_fetch_array(mysql_query("SELECT * FROM `cat` where `id`='$nextpay_user_cat'"));
$nextpay_price 			= $nextpay_cat_db['price'];
$nextpay_dl	 			= $nextpay_cat_db['dl'];
$nextpay_bw	 			= $nextpay_cat_db['bw'];

$MerchantID 			= $nextpay_payment_api;
$Price 					= $nextpay_price;
$Trans_ID 				= $_POST['trans_id'];
$InvoiceNumber 			= $_POST['order_id'];

$Server = 'http://api.nextpay.org/gateway/verify.wsdl';
$client = new SoapClient( $Server, array('encoding' => 'UTF-8'));
$result = $client->PaymentVerification(
    array(
        'api_key'	 => $MerchantID,
        'trans_id' 	 => $Trans_ID,
        'order_id' 	 => $InvoiceNumber,
        'amount'	 => $Price
    )
);
$result = $result->PaymentVerificationResult;


if(intval($result->code) == 0){
    patment_callback_ok($member_id);
    exit;
} else {
	header("Location: $bad_url");
	exit;
}
?>