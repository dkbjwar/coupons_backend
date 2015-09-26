<?php

/**
 * Web Service that response employes in the core.
 *
 */
require_once('lib/nusoap.php'); /* Call soap library */
require_once('coupons.class.php'); /* Call coupons functions */
$server = new soap_server();

/* Configure the WS */
$ns = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$server->configurewsdl('CouponsApplicationServices', $ns);
$server->wsdl->schematargetnamespace = $ns;

/* Register the Web Service Methods */
        $server->register('getCoupons', array(), array('return' => 'xsd:string'), $ns);

$server->register('getCouponById', array('cup_id' => 'xsd:int'), array('return' => 'xsd:string'), $ns);

$server->register('exchangeCoupon', array(
    'cns_cup_id' => 'xs:string',
    'cns_username' => 'xsd:string',
    'cns_ip' => 'xsd:string'), array('return' => 'xsd:boolean'), $ns);

if (isset($HTTP_RAW_POST_DATA)) {
    $input = $HTTP_RAW_POST_DATA;
} else {
    $input = implode("\r\n", file('php://input'));
}
$server->service($input);
exit;
?>