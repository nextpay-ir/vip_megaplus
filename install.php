<?php
include("../../../include/connect_api.php");

$plugin_type 			= "payment";
$plugin_patch 			= "nextpay";
$plugin_active	 		= "0";
$plugin_name 			= "پلاگین پرداخت نکست پی";
$plugin_display 		= "پرداخت از طریق کلیه کارت های عضو شبکه شتاب";
$plugin_data_1	 		= "xxxxxxxxxxxxxx";
$plugin_data_2	 		= "";
$plugin_data_3	 		= "";
$plugin_data_4	 		= "";
$plugin_data_5	 		= "";
$plugin_data_6	 		= "";
$plugin_data_7	 		= "";
$plugin_data_8	 		= "";
$plugin_data_9	 		= "";
$plugin_data_10	 		= "";

$plugin_install_check 	= mysql_num_rows(mysql_query("SELECT * FROM `plugin` where `patch`= '$plugin_patch'"));

if($plugin_install_check > 0) {
	echo "This plugin is already installed";
	exit;
} else {
	$sqli = mysql_query("insert into `plugin` (`type`, `patch`, `active`, `plugin_name`, `display_name`, `data_1`, `data_2`, `data_3`, `data_4`, `data_5`, `data_6`, `data_7`, `data_8`, `data_9`, `data_10`) values('$plugin_type','$plugin_patch','$plugin_active','$plugin_name','$plugin_display','$plugin_data_1','$plugin_data_2','$plugin_data_3','$plugin_data_4','$plugin_data_5','$plugin_data_6','$plugin_data_7','$plugin_data_8','$plugin_data_9','$plugin_data_10');");
	if($sqli) {
		echo 'Installation was successful';
		exit;
	} else {
		echo 'Setup Error';
		exit;
	}
}
?>