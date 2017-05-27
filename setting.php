<?php
session_start();

include("../../../connect.php");

// Start Security AMDIN Permission Check
$username_check=$_SESSION["megavip_username"];
$password_check=$_SESSION["megavip_password"];
$permission_login_security = mysql_num_rows(mysql_query("SELECT * FROM `users` where `user`='$username_check' AND `pass`='$password_check'"));
$permission_db = mysql_fetch_array(mysql_query("SELECT * FROM `users` where user='$username_check'"));
$admin_permission = $permission_db['permission'];
if(check()!="mega_admin" or $_SESSION["megavip_username"] !="admin" or $admin_permission != 100 or $permission_login_security==0)
{
	echo '<meta http-equiv="refresh" content="0; url= index">';
	header("Location: index");
	exit();
}
// End Security AMDIN Permission Check

if($_POST['submit']=='go')
{
	mysql_query("SET NAMES 'utf8'");
	$payment_nextpay_status 		= $_POST['payment_nextpay_status'];
	$payment_nextpay_name 			= $_POST['payment_nextpay_name'];
	$payment_nextpay_api	 		= $_POST['payment_nextpay_api'];
	$payment_nextpay_url	 		= $_POST['payment_nextpay_url'];
	
	$sqli = mysql_query("UPDATE `plugin` SET `active` = '$payment_nextpay_status', `display_name` = '$payment_nextpay_name', `data_1` = '$payment_nextpay_api' where `type`='payment' and `patch`='nextpay'");
	if($sqli) 
	$sus='اطلاعات با موفقیت ثبت شد';
	else
	$error='ثبت اطلاعات با مشکل روبرو شد!';
}

mysql_query ("set character_set_results='utf8'");
$nextpay_plugin_db 				= mysql_fetch_array(mysql_query("SELECT * FROM `plugin` where `type`='payment' and `patch`='nextpay'"));
$nextpay_payment_sondbox 		= $nextpay_plugin_db['data_1'];

$payment_nextpay_status 		= $nextpay_plugin_db['active'];
$payment_nextpay_name 			= $nextpay_plugin_db['display_name'];
$payment_nextpay_api	 		= $nextpay_plugin_db['data_1'];

if($error)
$status='<div class="error_content" style="margin-top:5px;">'.$error.'</div>';
else if($sus)
$status='<div class="sucs_content" style="margin-top:5px;">'.$sus.'</div>';

$username_check=$_SESSION["megavip_username"];
?>

<?php echo $status;?>
<div class="login_content">
<div class="table_content_title">تنظیمات درگاه پرداخت  درگاه واسط</div>
<form class="uniform" name="news" method="post" action="">
<table style="width: 100%">
	<tr>
		<td style="text-align:right; background:#CBC3BD; width:125px;">وضعیت افزونه</td>
		<td style="background:#CECAC6;">
		<select size="1" name="payment_nextpay_status" class="login_input" style="width:300px;" dir="rtl">
			<option value='1' <?php if ($payment_nextpay_status == 1 ) echo 'selected' ; ?> >فعال</option>
			<option value='0' <?php if ($payment_nextpay_status == 0 ) echo 'selected' ; ?> >غیر فعال</option>
		</select>
		</td>
	</tr>
	<tr>
		<td style="text-align:right; background:#CBC3BD; width:125px;">عنوان نمایشی</td>
		<td style="background:#CECAC6;"><input type="text" class="login_input" style="width:300px;" dir="rtl" value="<?php echo $payment_nextpay_name;?>" id="newstitle" name="payment_nextpay_name"></td>
	</tr>
	<tr>
		<td style="text-align:right; background:#CBC3BD; width:125px;">کلید مجوزدهی API KEY</td>
		<td style="background:#CECAC6;"><input type="text" class="login_input" style="width:300px;" dir="ltr" value="<?php echo $payment_nextpay_api;?>" id="newstitle" name="payment_nextpay_api"></td>
	</tr>
	<tr>
		<td style="text-align:right; width:125px;"> </td>
		<td dir="ltr">
			<button class="button gray" style="margin-left:-8px;" type="submit" value="go" name="submit">ذخیره کردن تغییرات</button>
			<button type="reset" name="reset" class="button cancelb">باز نشانی</button>
		</td>
	</tr>
</table>
</form>
</div>