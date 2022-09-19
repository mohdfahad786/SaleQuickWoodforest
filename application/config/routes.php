<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'about/agent';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['confirm/(:any)'] = 'signup/confirm/$1 ';
$route['payment/(:any)/(:any)'] = 'signup/payment/$1//$2 ';
$route['payment_cnp/(:any)/(:any)'] = 'signup/payment_cnp/$1//$2 ';
$route['payment_cnp_invoicing/(:any)/(:any)'] = 'signup/payment_cnp_invoicing/$1//$2 ';
$route['card_payment'] = 'signup/card_payment';

$route['rpayment/(:any)/(:any)'] = 'signup/payment/$1//$2 ';
$route['spayment/(:any)/(:any)'] = 'signup/spayment/$1//$2 ';
//$route['rpayment/(:any)/(:any)'] = 'signup/rpayment/$1//$2 ';

$route['reciept/(:any)/(:any)'] = 'signup/reciept/$1/$2 ';
$route['reciept2/(:any)/(:any)'] = 'signup/reciept2/$1/$2 ';

$route['refund_reciept/(:any)/(:any)/(:any)'] = 'signup/refund_reciept/$1/$2/$3';

$route['pos_reciept/(:any)/(:any)'] = 'signup/pos_reciept/$1/$2 ';
$route['adv_pos_reciept/(:any)/(:any)'] = 'signup/adv_pos_reciept/$1/$2 ';

$route['pos_refund_reciept/(:any)/(:any)'] = 'signup/pos_refund_reciept/$1/$2';
$route['adv_pos_refund_reciept/(:any)/(:any)'] = 'signup/adv_pos_refund_reciept/$1/$2';

$route['adv_pos_reciept_copy/(:any)/(:any)'] = 'signup/adv_pos_reciept_copy/$1//$2 ';

$route['rec_payment/(:any)/(:any)'] = 'signup/rec_payment/$1//$2 ';


$route['payment_error'] = 'signup/payment_error';
$route['payment_error/(:any)'] = 'signup/payment_error/$1 ';
$route['payment_error/(:any)/(:any)'] = 'signup/payment_error/$1/$2';

$route['api_payment/(:any)/(:any)'] = 'sandbox/payment/$1//$2 ';
$route['api_payment_sandbox/(:any)/(:any)'] = 'sandbox/payment_sandbox/$1//$2 ';
$route['api_card_payment'] = 'sandbox/card_payment';

$route['api'] = 'about/api';
$route['invoice'] = 'about/invoice';
$route['pos'] = 'about/pos';
$route['products'] = 'about/products';
$route['pricing1'] = 'about/pricing1';
$route['pricing'] = 'about/pricing';
$route['support'] = 'about/support';
$route['company'] = 'about/company';
$route['login'] = 'about/login';
$route['admin'] = 'about/admin';
$route['subadmin'] = 'about/subadmin';
$route['api_detail'] = 'about/api_detail';
$route['contact_us'] = 'about/contact_us';
$route['terms_and_condition'] = 'about/terms_and_condition';
$route['privacy_policy'] = 'about/privacy_policy';
$route['blog'] = 'about/blog';
$route['five_payment_processing_trends_in_2019'] = 'about/blog_more';
$route['eight_important_questions_all_businesses_should_ask_their_payment_provider'] = 'about/blog_more2';
$route['innovation_of_pay_by_text'] = 'about/blog_more3';
$route['how_credit_card_processing_works'] = 'about/blog_more4';
$route['api_new'] = 'about/api_new';

$route['dailyreport/(:any)/(:any)'] = 'Report/allreportpdf//$1//$2 ';
// $route['monthlyreport/(:any)/(:any)'] = 'Report/allreportpdf//$1//$2 ';
$route['monthlyreport/(:any)/(:any)/(:any)'] = 'Report/allreportpdf/$1/$2/$3';

$route['hitsql'] = 'welcome/hitsqlquery';

//$route['product/(:num)'] = 'catalog/product_lookup_by_id/$1';

/**

API URL's
 **/
//receipt api for app
$route['webservices/pos_reciept_json/(:any)/(:any)'] = 'App/ReceiptApi/pos_reciept_json/$1/$2 ';
$route['webservices/v3.1/pos_reciept_json/(:any)/(:any)'] = 'App/ReceiptApi/pos_reciept_json_v3/$1/$2 ';
$route['webservices/v3.2/pos_reciept_json/(:any)/(:any)'] = 'App/ReceiptApi/pos_reciept_json_v3_2/$1/$2 ';
$route['webservices/v3.2.3/pos_reciept_json/(:any)/(:any)/(:any)'] = 'App/ReceiptApi/pos_reciept_json_v3_2_3/$1/$2/$3 ';
$route['webservices/v3.3/pos_reciept_json/(:any)/(:any)'] = 'App/ReceiptApi/pos_reciept_json_v3_3/$1/$2 ';
$route['webservices/v3.4/pos_reciept_json/(:any)/(:any)'] = 'App/ReceiptApi/pos_reciept_json_v3_4/$1/$2 ';

$route['webservices/v3.4/hello'] = 'Webservice/Merchant_api/hello';





