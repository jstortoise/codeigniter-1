<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>orriz.com</title>
<style type="text/css">
body {
	padding-top: 0 !important;
	padding-bottom: 0 !important;
	padding-top: 0 !important;
	padding-bottom: 0 !important;
	margin:0 !important;
	width: 100% !important;
	-webkit-text-size-adjust: 100% !important;
	-ms-text-size-adjust: 100% !important;
	-webkit-font-smoothing: antialiased !important;
}
.tableContent img {
	border: 0 !important;
	display: block !important;
	outline: none !important;
}
a {
	color:#FDCD2D;
}
p, h1 {
	color:#FDCD2D;
	margin:0;
}
p {
	text-align:left;
	color:#999999;
	font-size:14px;
	font-weight:normal;
	line-height:19px;
}
a.link1 {
	color:#FDCD2D;
}
a.link2 {
	font-size:16px;
	text-decoration:none;
	color:#ffffff;
}
h2 {
	text-align:left;
	color:#222222;
	font-size:19px;
	font-weight:normal;
}
div, p, ul, h1 {
	margin:0;
}
.bgBody {
	background: #ffffff;
}
.bgItem {
	background: #ffffff;
}
</style>
<script type="colorScheme" class="swatch active">
{
    "name":"Default",
    "bgBody":"ffffff",
    "link":"FDCD2D",
    "color":"999999",
    "bgItem":"ffffff",
    "title":"222222"
}
</script>
</head>
<body paddingwidth="0" paddingheight="0"   style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center"  style='font-family:Helvetica, Arial,serif;'>
  <tr>
    <td style="text-align: center;" height="10">&nbsp; You have received this e-mail because you have registered on Orriz.com</td>
  </tr>
  <tr>
    <td>&nbsp; &nbsp;<img style="margin: 20px 5px 15px 10px;" src="<?php echo base_url();?>/public/images/logo.png" alt="Orriz.com" /></td>
  </tr>
  <tr>
    <td><p><strong>Date :
        <?= date("d/m/Y"); ?>
        </strong></p>
      <p><?php echo sprintf(lang('email_forgot_password_heading'), "<span style='color:#DC2828;'>".$identity."</span>");?></p>
      <p>You are requested to recover your password on Orriz.com. Please click on the link below to reset your password.</p>
      <p><strong><?php echo sprintf(lang('email_forgot_password_subheading'), anchor(base_url('members/reset_password').'/'. $forgotten_password_code, lang('email_forgot_password_link')));?> </strong></p></td>
  </tr>
  <tr>
    <td><p><a href="{link}">&nbsp;</a></p>
      <p>&nbsp;</p>
      <p>© 2015 Website Name. All rights reserved.</p></td>
  </tr>
    </tbody>
  
</table>
</body>
</html>
