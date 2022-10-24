<!doctype html>
<html lang="en">
<head>
<title>Orders</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<style>
/* ----------reset css-------------- */
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,button,textarea,p,blockquote {margin:0;padding:0;}
table {border-collapse:collapse;border-spacing:0;}
fieldset,img {border:0;}
address,caption,cite,code,dfn,th,var {font-style:normal;font-weight:normal;}
caption,th{text-align:left;}
h1,h2,h3,h4,h5,h6 {font-size:100%;font-weight:normal;}
q:before,q:after {content:'';}
abbr,acronym {border:0;}
form {margin-top:0;margin-bottom:0;}
object {outline:none;}
html {overflow-y:scroll;}
img {max-width:100%;height:auto;}
a {outline-style:none;}
textarea {resize:vertical;}
textarea, input {outline:none;}

/* ----------common styles-------------- */
.group:before, .group:after {content:"";display:table;} 
.group:after {clear: both;}
.group {zoom: 1;}

/* ----------start css-------------- */
body {font-family:'Helvetica Neue',Arial,Helvetica,sans-serif;color:#000;font-size:14px;background:#FFF;overflow-x:hidden;line-height:normal;position:relative;}
.row-mid {padding:80px 0;line-height:150%;}
.container {clear:both;width:960px;margin:0 auto;padding:0;position:relative;}

h1 {font-size:32px;font-weight:bold;padding:0 0 15px 0;}
h2 {font-size:21px;font-weight:bold;padding:0 0 30px 0;}
p {padding:0 0 10px 0;}

.grid-item {padding:15px 0;border-bottom:2px solid #000;}
.grid-item .row {}
.grid-item .grid-meta {padding:10px 0;border-bottom:1px dashed #000;}
.grid-item .grid-meta:nth-of-type(1) {padding-top:0;}
.grid-item .meta-btm {padding-top:10px;}
.grid-item .left {float:left;width:150px;}
.grid-item .right {float:left;width:calc(100% - 150px);}

.btn-line {color:#999;background:none;border:2px solid #999;padding:10px 20px 10px 20px;font-family:'montserratregular',Arial,Helvetica,sans-serif;font-size:14px;text-align:center;text-decoration:none;text-transform:uppercase;margin:20px 0 0 20px;}
.btn-line {display:inline-block;transition:all 0.5s ease-in-out;}
.btn-line:hover {color:#FFF;background:#ECA918;border:2px solid #ECA918;text-decoration:none;/*transform:translateY(-2px);*/}
.btn-line.light {color:#FFF;border:2px solid #FFF;text-shadow:0px 0px 5px rgba(0, 0, 0, 0.5);}
.btn-line.light {-webkit-box-shadow: 0px 0 10px 0px rgba(0,0,0,0.3);-moz-box-shadow: 0px 0 10px 0px rgba(0,0,0,0.3);box-shadow: 0px 0 10px 0px rgba(0,0,0,0.3);}
.btn-line.light:hover {color:#ECA918;background:#FFF;border:2px solid #FFF;text-shadow:none;}

.btn-line.btn-orange {color:#ECA918;border:2px solid #ECA918;}
.btn-line.btn-orange:hover {color:#FFF;}
.btn-line.btn-top {margin-bottom:20px;}

#datepicker {padding:7px 10px;border:2px solid #CCC;}
.rdsn-date {margin-left:10px;}
.rdsn-error {display:none;color:#093;margin-left:10px;}

@media print {  
.row-mid {padding:10px 0;}  
.no-print {display:none;}
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    jQuery(document).ready(function($) {
        $("#datepicker").val('');
		$("#date-field").val('');
		$("#datepicker").datepicker({
			dateFormat: "D d M yy",
			altFormat: "yymdd",
			altField: "#date-field",
			onSelect: function(date) {
				$('.rdsn-error').hide();
			},
		});
		//
		$('#btn-select').on( 'click', function() {
			if($("#date-field").val() == '') {
				$('.rdsn-error').show();
			} else {
				var curr_href = 'https://forgeshopping.com/orders/?bookingdate=';
				var date_select = $('#date-field').val();
				var process_send = curr_href + date_select;
				window.location.replace(process_send);
				//console.log ('Location: ' + process_send);
			}
		});
    });
</script>
</head>

<body <?php body_class(); ?>>
