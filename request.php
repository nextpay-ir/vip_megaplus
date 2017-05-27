<?php
include("../../../include/connect_api.php");

$root_url 				= "http://$_SERVER[HTTP_HOST]";
$member 				= $_GET['member'];

$nextpay_plugin_db 		= mysql_fetch_array(mysql_query("SELECT * FROM `plugin` where `type`='payment' and `patch`='nextpay'"));
$nextpay_payment_api 	= $nextpay_plugin_db['data_1'];
$nextpay_payment_url 	= $nextpay_plugin_db['data_7'];

$nextpay_member_db 		= mysql_fetch_array(mysql_query("SELECT * FROM `users` where `user`='$member'"));
$nextpay_user_id 		= $nextpay_member_db['id'];
$nextpay_user_cat 		= $nextpay_member_db['cat'];

$nextpay_cat_db 		= mysql_fetch_array(mysql_query("SELECT * FROM `cat` where `id`='$nextpay_user_cat'"));
$nextpay_price 			= $nextpay_cat_db['price'];

$callbackUrl 			= $root_url .'/plugin/payment/nextpay/callback.php?id='. $nextpay_user_id .'';

$MerchantID 			= $nextpay_payment_api;
$Price 					= $nextpay_price;
$InvoiceNumber 			= time();
$CallbackURL 			= $root_url .'/plugin/payment/nextpay/callback.php?id='. $nextpay_user_id .'';

$params = array(
    'api_key' => $MerchantID,
    'amount'       => $Price,
    'order_id'      => $InvoiceNumber,
    'callback_uri'     => $CallbackURL
);
$Server = 'http://api.nextpay.org/gateway/token.wsdl';
$client = new SoapClient( $Server, array('encoding' => 'UTF-8'));
$result = $client->TokenGenerator($params);
$result = $result->TokenGeneratorResult;

if ($result->code == -1){
	header('Location: https://api.nextpay.org/gateway/payment/'. $result->trans_id);
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="3;URL=https://api.nextpay.org/gateway/payment/'. $result->trans_id .'" />   
	<style media="screen" type="text/css">
	body {
		background-color: #161616;
	}
	.wrapper {
		border: 1px solid silver;
		width: 300px;
		background-color: #E8E8E8;
		box-shadow: 0 0 4px 3px #DBDBDB;
		margin: 200px auto;
	}
	</style>
	<div class="wrapper">
	<center>
		<p><img alt="" src="../../../theme/images/loading-arrow.gif" /></p>
		<p style="font-family:tahoma; font-size:11px; direction:rtl;">در حال انتقال به درگاه بانکی, لطفاً کمی صبر کنید ...</p>
		<p><img alt="" src="../../../theme/images/banks.png" /></p>
	</center>
	</div>';
} else {
	echo $result->code;
}
?>