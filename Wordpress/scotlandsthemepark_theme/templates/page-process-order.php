<div class="page-process-order">
    <div class="row-mid">
    	<?php if (have_posts()): while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
		<a class="btn-solid btn-logout trans-0-3" href="<?php echo wp_logout_url(); ?>">Log out</a>
    </div>
</div>

<style>
	#header, #nav-mobile, #content-offset, #footer-top, #footer-social, #footer-signup, #footer-contact, #footer-sites, #offset-footer, .rdsn-modal {display:none;}
	.row-mid {padding:30px 30px;}
	.row-mid ul li:before {display:none;}
	#barcode-scan-form {max-width:480px;margin:0 auto 50px;}
	#barcode-scan-form select {background:#FFF8E6;height:36px;padding:0 10px;}
	#barcode-scan-form select, #barcode-scan-form #scan-code {display:block;width:100%;border:none;-webkit-border-radius:0;border-radius:0;}
	#barcode-scan-form #scan-code {height:48px;font-size:16px;margin:20px 0!important;padding:0 10px;-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-appearance:none;}
	#barcode-scan-form input[type="submit"] {color:#FFCA44;background:#4A1260;border:none;width:100px;height:50px;line-height:50px;font-size:20px;font-weight:900;text-align:center;text-transform:uppercase;text-decoration:none;position:relative;}
	#barcode-scan-form input[type="submit"] {display:inline-block;-webkit-appearance:none;-webkit-border-radius:10px;border-radius:10px;-webkit-box-sizing:border-box;box-sizing:border-box;transition:all 0.2s ease-in-out;}
	#barcode-scan-form input[type="submit"]:hover {color:#FFCA44;transform:translateY(-2px);text-decoration:none;-webkit-box-shadow:0 5px 10px 0 rgba(0,0,0,0.3);-moz-box-shadow:0 5px 10px 0 rgba(0,0,0,0.3);box-shadow:0 5px 10px 0 rgba(0,0,0,0.3);cursor:pointer;}
	
	#barcode-scan-result {max-width:960px;margin:0 auto;}
	#barcode-scan-result .woocommerce-notice {font-size:32px;line-height:100%;margin-bottom:20px;color:#CC0000;}
	#barcode-scan-result mark {background:none;}
	#barcode-scan-result .order-again {display:none;}
	.woocommerce .woocommerce-customer-details address {-webkit-box-sizing:border-box;box-sizing:border-box;}
	.btn-logout {font-size:14px;padding:10px 25px;opacity:0.5;}
	.btn-logout:hover {opacity:1;}
</style>