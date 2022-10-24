<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require_once 'Exception.php';
require_once 'PHPMailer.php';
require_once 'SMTP.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

// Remove $_COOKIE elements from $_REQUEST.
if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}
// Check referrer is from same site.
if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}


// ********************************************** MAIL MESSAGE
function securitise($str)
{ // quick and dirty security measure
return htmlentities(strip_tags($str), ENT_QUOTES, "UTF-8");	
}

$rdsn_name = securitise($_POST['name']);
$rdsn_email = securitise($_POST['email']);
$rdsn_phone = securitise($_POST['phone']);
$rdsn_message = securitise($_POST['message']);
//
$dep_email = get_field('amazonia_contact_email','option');
//
if (isset($_POST['opt_birthdays'])) { $opt_birthdays = securitise($_POST['opt_birthdays']); } else { $opt_birthdays =''; }
if (isset($_POST['opt_groups'])) { $opt_groups = securitise($_POST['opt_groups']); } else { $opt_groups =''; }
if (isset($_POST['opt_animals'])) { $opt_animals = securitise($_POST['opt_animals']); } else { $opt_animals =''; }
if (isset($_POST['opt_passport'])) { $opt_passport = securitise($_POST['opt_passport']); } else { $opt_passport =''; }
//
$rdsn_opt_array = array($opt_birthdays,$opt_groups,$opt_animals,$opt_passport);
$rdsn_opt_array = array_filter($rdsn_opt_array); // remove blank values from array
if (array_count_values($rdsn_opt_array) > 1) {
	$rdsn_opt = implode(", ", $rdsn_opt_array);
} else {
	$rdsn_opt = $rdsn_opt_array;
}
//
$html_message = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Contact</title>
<style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,button,textarea,p,blockquote {margin:0;padding:0;}
table {border-collapse:collapse;border-spacing:0;}
fieldset,img {border:0;}
address,caption,cite,code,dfn,th,var {font-style:normal;font-weight:normal;}
caption,th{text-align:left;}
h1,h2,h3,h4,h5,h6 {font-size:100%;font-weight:normal;}
q:before,q:after {content:"";}
abbr,acronym {border:0;}
form {margin-top:0;margin-bottom:0;}
object {outline:none;}
html {overflow-y:scroll;}
img {max-width:100%;height:auto;}
@media \0screen {img { width:auto;}}
a {outline-style:none;}
textarea {resize:vertical;}
textarea, input {outline:none;}
.clearboth {clear:both;height:0;font-size:1px;line-height:0px;}
body {font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:normal;line-height:normal;margin:0;padding:25px;color:#000000;background:#FFFFFF;overflow-x:hidden;}
table {max-width:600px;border-left:1px solid #000000;border-top:1px solid #000000;}
td {padding:10px 20px;border-bottom:1px solid #000000;border-right:1px solid #000000;}
td.lft {width:150px;font-weight:bold;}
</style>
</head>
<body>
<h2 style="font-size:18px;font-weight:bold;margin:0;padding:10px 0 20px 0;">Contact from '.$rdsn_name.'</h2>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td valign="top" class="lft">Name</td>
    <td valign="top" class="rgt">'.$rdsn_name.'</td>
  </tr>
  <tr>
    <td valign="top" class="lft">Email</td>
    <td valign="top" class="rgt"><a href="mailto:'.$rdsn_email.'">'.$rdsn_email.'</a></td>	
  </tr>
  <tr>
    <td valign="top" class="lft">Phone</td>
    <td valign="top" class="rgt">'.$rdsn_phone.'</td>
  </tr>
  <tr>
    <td valign="top" class="lft">Interests</td>
    <td valign="top" class="rgt">'.$rdsn_opt.'</td>
  </tr>
  <tr>
    <td valign="top" class="lft">Message</td>
    <td valign="top" class="rgt">'.$rdsn_message.'</td>
  </tr>
</table>
<p style="margin:0;padding:20px 0;font-size:11px;">Please do not reply to this message, it is from an unmonitored mailbox.<br />Click the email address in the body of the message to reply to the sender.</p>
</body>
</html>
';

//echo $html_message;

// ********************************************** MAIL SETTINGS
$subject = "Contact from the Amazonia web site"; //Enter e-mail subject
$recipient = $dep_email;
$continue = "/attractions/amazonia/plan-your-visit/contact/#contact-complete"; //redirect page

$mail = new PHPMailer;                              	// Passing `true` enables exceptions
//Server settings - TEST
$mail->SMTPDebug = 0;                                 	// Enable verbose debug output
$mail->isSMTP();                                      	// Set mailer to use SMTP
$mail->Host = 'mail.design-files.co.uk';  				// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               	// Enable SMTP authentication
$mail->Username = 'mailer@design-files.co.uk';			// SMTP username
$mail->Password = 'YCFff!w!B';                          // SMTP password
$mail->SMTPAutoTLS = false;								// Heart was throwing a wobbler
$mail->Port = 587;                                    	// TCP port to connect to

// From
$mail->setFrom("mailer@design-files.co.uk", "Amazonia web mailer");
$mail->addReplyTo('mailer@design-files.co.uk');
$mail->addAddress($recipient); 

//Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $subject;
$mail->Body    = $html_message;
$mail->AltBody = 'Please set your email programme to receive HTML email content.';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    header("Location: $continue");
}

?>