<?php

// $allowedOrigins = array(
//     // 'http://192.168.1.23' ,//for Api
//     'http://192.168.1.23/laravel/adminPanelDemo/api/' ,//for Api
//     // 'http://localhost' ,//for Api
// );
// if(isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != ''){
//     foreach($allowedOrigins as $allowedOrigin){
//         if (preg_match('#' . $allowedOrigin. '#', $_SERVER['HTTP_ORIGIN'])){
//             header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']); 
//             header('Access-Control-Allow-Credentials: true');
//             header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//             header('Access-Control-Max-Age: 1728000');
//             header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization,X-Requested-With, Content-Range, Content-Disposition, Content-Description, x-xsrf-token, ip');
//             break;
//         }
//     }
// }

ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
//ini_set('max_execution_time', '0');
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */
$uri = urldecode(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri))
{
    return false;
}

require_once __DIR__ . '/public/index.php';


