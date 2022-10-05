<?php
include('../../../wp-load.php');
global $wp;
global $wp_session;
$payment_id = $_SESSION['payment_id'];
$url = "https://pay.glin.com.br/merchant-api/remittances/'.$payment_id.'";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "Authorization: Bearer YThkMjg2MWEtNTdjMy00ZDBlLTk4ZGQtZmQyOGUyNmIxMjI2OkNBME1iUDd4Nm9KbjBaWW5IenlaNmpzN2hGTzNQVndI",
    "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$data = json_decode($resp);
$order_id = $wp_session['order_id'];
$order = wc_get_order( $order_id );
if ($data->status == 'paid')
{
    $order->set_status('wc-by-customer');
    $url = "https://muneka.us/en/order-updates?success=true";
    wp_redirect($url);
    exit;
}
else
{
    $url = "https://muneka.us/en/you-have-no-order/";
    wp_redirect($url);
    exit;

}

?>
