<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
$route['default_controller'] = 'home/index';
$route['404_override'] = '';
$route['privacy'] = 'page/index';
$route['term'] = 'page/index';
$route['help'] = 'page/index';
$route['safety'] = 'page/index';

//$route['add_post/addpostdata/(:any)'] = 'add_post/addpostdata/$1';
//$route['add_post/(:any)'] = 'add_post/index/$1';
//$route['choose_category/choosecatdata/(:any)'] = 'choose_category/choosecatdata/$1';
//$route['choose_category/(:any)'] = 'choose_category/index/$1';

/* admin */
$route['admin'] = 'admin/index';
$route['admin/signup'] = 'admin/signup';
$route['admin/create_member'] = 'admin/create_member';
$route['admin/login'] = 'admin/index';
$route['admin/logout'] = 'admin/logout';
$route['admin/login/validate_credentials'] = 'admin/validate_credentials';

$route['admin/category'] = 'admin_category/index';
$route['admin/category/add'] = 'admin_category/add';
$route['admin/category/update'] = 'admin_category/update';
$route['admin/category/update/(:any)'] = 'admin_category/update/$1';
$route['admin/category/delete/(:any)'] = 'admin_category/delete/$1';
$route['admin/category/(:any)'] = 'admin_category/index/$1'; //$1 = page number

$route['admin/category_price'] = 'admin_category_price/index';
$route['admin/category_price/add'] = 'admin_category_price/add';
$route['admin/category_price/update'] = 'admin_category_price/update';
$route['admin/category_price/update/(:any)'] = 'admin_category_price/update/$1';
$route['admin/category_price/delete/(:any)'] = 'admin_category_price/delete/$1';
$route['admin/category_price/(:any)'] = 'admin_category_price/index/$1';

$route['admin/posts'] = 'admin_posts/index';
$route['admin/posts/add'] = 'admin_posts/add';
$route['admin/posts/update'] = 'admin_posts/update';
$route['admin/posts/update/(:any)'] = 'admin_posts/update/$1';
$route['admin/posts/delete/(:any)'] = 'admin_posts/delete/$1';
$route['admin/posts/delete_image/(:any)/(:any)'] = 'admin_posts/delete_image/$1/$2';
$route['admin/posts/(:any)'] = 'admin_posts/index/$1'; //$1 = page number


$route['admin/user'] = 'admin_user/index';
$route['admin/user/add'] = 'admin_user/add';
$route['admin/user/update'] = 'admin_user/update';
$route['admin/user/exportcsv'] = 'admin_user/exportcsv';
$route['admin/user/update/(:any)'] = 'admin_user/update/$1';
$route['admin/user/delete/(:any)'] = 'admin_user/delete/$1';
$route['admin/user/(:any)'] = 'admin_user/index/$1'; //$1 = page number

$route['admin/cms'] = 'admin_cms/index';
$route['admin/cms/add'] = 'admin_cms/add';
$route['admin/cms/update'] = 'admin_cms/update';
$route['admin/cms/update/(:any)'] = 'admin_cms/update/$1';
$route['admin/cms/delete/(:any)'] = 'admin_cms/delete/$1';
$route['admin/cms/(:any)'] = 'admin_cms/index/$1'; //$1 = page number


$route['admin/advertisement'] = 'admin_advertisement/index';
$route['admin/advertisement/add'] = 'admin_advertisement/add';
$route['admin/advertisement/update'] = 'admin_advertisement/update';
$route['admin/advertisement/update/(:any)'] = 'admin_advertisement/update/$1';
$route['admin/advertisement/delete/(:any)'] = 'admin_advertisement/delete/$1';
$route['admin/advertisement/(:any)'] = 'admin_advertisement/index/$1';
//$route['ajax_call/set_session_language_shortcode/(:any)'] = 'ajax_call/set_session_language_shortcode/$1';


$route['admin/country'] = 'admin_country/index';
$route['admin/country/add'] = 'admin_country/add';
$route['admin/country/update'] = 'admin_country/update';
$route['admin/country/update/(:any)'] = 'admin_country/update/$1';
$route['admin/country/delete/(:any)'] = 'admin_country/delete/$1';
$route['admin/country/(:any)'] = 'admin_country/index/$1';

$route['admin/state'] = 'admin_state/index';
$route['admin/state/add'] = 'admin_state/add';
$route['admin/state/update'] = 'admin_state/update';
$route['admin/state/update/(:any)'] = 'admin_state/update/$1';
$route['admin/state/delete/(:any)'] = 'admin_state/delete/$1';
$route['admin/state/(:any)'] = 'admin_state/index/$1';

$route['admin/city'] = 'admin_city/index';
$route['admin/city/add'] = 'admin_city/add';
$route['admin/city/update'] = 'admin_city/update';
$route['admin/city/update/(:any)'] = 'admin_city/update/$1';
$route['admin/city/delete/(:any)'] = 'admin_city/delete/$1';
$route['admin/city/(:any)'] = 'admin_city/index/$1';

$route['admin/city_category_price'] = 'admin_city_category_price/index';
$route['admin/city_category_price/add'] = 'admin_city_category_price/add';
$route['admin/city_category_price/update'] = 'admin_city_category_price/update';
$route['admin/city_category_price/update/(:any)'] = 'admin_city_category_price/update/$1';
$route['admin/city_category_price/delete/(:any)'] = 'admin_city_category_price/delete/$1';
$route['admin/city_category_price/(:any)'] = 'admin_city_category_price/index/$1';

$route['admin/cms'] = 'admin_cms/index';
$route['admin/cms/add'] = 'admin_cms/add';
$route['admin/cms/update'] = 'admin_cms/update';
$route['admin/cms/update/(:any)'] = 'admin_cms/update/$1';
$route['admin/cms/delete/(:any)'] = 'admin_cms/delete/$1';
$route['admin/cms/(:any)'] = 'admin_cms/index/$1'; //$1 = page number
$route['admin/cms/(:any)'] = 'admin_cms/index/$1';

$route['admin/promocode'] = 'admin_promocode/index';
$route['admin/promocode/add'] = 'admin_promocode/add';
$route['admin/promocode/update'] = 'admin_promocode/update';
$route['admin/promocode/exportcsv'] = 'admin_promocode/exportcsv';
$route['admin/promocode/update/(:any)'] = 'admin_promocode/update/$1';
$route['admin/promocode/delete/(:any)'] = 'admin_promocode/delete/$1';
$route['admin/promocode/(:any)'] = 'admin_promocode/index/$1'; //$1 = page number

$route['admin/affiliate'] = 'admin_affiliate/index';
$route['admin/affiliate/add'] = 'admin_affiliate/add';
$route['admin/affiliate/update'] = 'admin_affiliate/update';
$route['admin/affiliate/update/(:any)'] = 'admin_affiliate/update/$1';
$route['admin/affiliate/delete/(:any)'] = 'admin_affiliate/delete/$1';
$route['admin/affiliate/(:any)'] = 'admin_affiliate/index/$1'; //$1 = page number
$route['admin/affiliate/(:any)'] = 'admin_affiliate/index/$1';

$route['admin/sitelanguage'] = 'admin_site_language/index';
$route['admin/sitelanguage/add'] = 'admin_site_language/add';
$route['admin/sitelanguage/update'] = 'admin_site_language/update';
$route['admin/sitelanguage/update/(:any)'] = 'admin_site_language/update/$1';
$route['admin/sitelanguage/delete/(:any)'] = 'admin_site_language/delete/$1';
$route['admin/sitelanguage/(:any)'] = 'admin_site_language/index/$1'; //$1 = page number

$route['admin/languagekeyword'] = 'admin_language_keyword/index';
$route['admin/languagekeyword/add'] = 'admin_language_keyword/add';
$route['admin/languagekeyword/update'] = 'admin_language_keyword/update';
$route['admin/languagekeyword/update/(:any)'] = 'admin_language_keyword/update/$1';
$route['admin/languagekeyword/delete/(:any)'] = 'admin_language_keyword/delete/$1';
$route['admin/languagekeyword/(:any)'] = 'admin_language_keyword/index/$1'; //$1 = page number
$route['admin/languagekeyword/(:any)'] = 'admin_language_keyword/index/$1';

$route['admin/top_ads'] = 'admin_top_ads/index';
$route['admin/top_ads/add'] = 'admin_top_ads/add';
$route['admin/top_ads/update'] = 'admin_top_ads/update';
$route['admin/top_ads/update/(:any)'] = 'admin_top_ads/update/$1';
$route['admin/top_ads/delete/(:any)'] = 'admin_top_ads/delete/$1';
$route['admin/top_ads/(:any)'] = 'admin_top_ads/index/$1'; //$1 = page number
$route['admin/top_ads/(:any)'] = 'admin_top_ads/index/$1';

$route['admin/age_verify'] = 'admin_age_verify/index';
$route['admin/age_verify/add'] = 'admin_age_verify/add';
$route['admin/age_verify/update'] = 'admin_age_verify/update';
$route['admin/age_verify/update/(:any)'] = 'admin_age_verify/update/$1';
$route['admin/age_verify/delete/(:any)'] = 'admin_age_verify/delete/$1';
$route['admin/age_verify/(:any)'] = 'admin_age_verify/index/$1'; //$1 = page number
$route['admin/age_verify/(:any)'] = 'admin_age_verify/index/$1';

$route['admin/featured_price'] = 'admin_featured_price/index';
$route['admin/featured_price/add'] = 'admin_featured_price/add';
$route['admin/featured_price/update'] = 'admin_featured_price/update';
$route['admin/featured_price/update/(:any)'] = 'admin_featured_price/update/$1';
$route['admin/featured_price/delete/(:any)'] = 'admin_featured_price/delete/$1';
$route['admin/featured_price/(:any)'] = 'admin_featured_price/index/$1'; //$1 = page number
$route['admin/featured_price/(:any)'] = 'admin_featured_price/index/$1';

$route['admin/dashboard'] = 'dashboard/index';
/*/
/* End of file routes.php */
/* Location: ./application/config/routes.php */