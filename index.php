<?php

if(!extension_loaded('curl')){echo 'CURL PHP LIBRARY IS NOT INSTALLED (A BIBLIOTECA PHP CURL NÃO ESTÁ INSTALADA)';}
$url = 'https://api.icloaker.com/?ip='.$_SERVER['REMOTE_ADDR'].'&domain='.preg_replace('#^(https?://)?(wwwd?.)?([^/?]+)(.*)#', '$3', $_SERVER['SERVER_NAME']).'&campaign=ef132ab7-da48-404b-9175-ed512c8709bc&apiKey=d71c8ef32a45a1512581f4a0e7e7852e&userAgent='.urlencode($_SERVER['HTTP_USER_AGENT']).'&page='.urlencode(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])).'&referer='.@$_SERVER['HTTP_REFERER'];
$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Content-Type: application/json';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$response = json_decode(curl_exec($curl), true);
if (curl_errno($curl)) {echo 'Error:'.curl_error($curl);}
curl_close ($curl);
function clearURL($url){if (parse_url($url, PHP_URL_QUERY)){$url_components = parse_url($url); parse_str(@$url_components['query'], $params);$_GET = $params;$path = parse_url($url, PHP_URL_PATH);return basename($path);}else{return $url;}}
$response['offerpage'] = clearURL($response['offerpage']);
$response['whitepage'] = clearURL($response['whitepage']);
if( $response['goToOffer'] === 1 ) {if(substr($response['offerpage'],-1)==='/'){if(file_exists($response['offerpage'].'index.php')){require($response['offerpage'].'index.php');}else{if(file_exists($response['offerpage'].'index.html')){require($response['offerpage'].'index.html');}else{echo 'BLACK PAGE NOT FOUND (PÁGINA BLACK NÃO ENCONTRADA)';}}}else{if(file_exists($response['offerpage'])){require($response['offerpage']);}else{echo 'BLACK PAGE NOT FOUND (PÁGINA BLACK NÃO ENCONTRADA)';}}}else{if( !empty($response['error']) ) {echo $response['error'];}else{if(substr($response['whitepage'],-1)==='/'){if(file_exists($response['whitepage'].'index.php')){require($response['whitepage'].'index.php');}else{if(file_exists($response['whitepage'].'index.html')){require($response['whitepage'].'index.html');}else{echo 'WHITE PAGE NOT FOUND (PÁGINA WHITE NÃO ENCONTRADA)';}}}else{if(file_exists($response['whitepage'])){require($response['whitepage']);}else{echo 'WHITE PAGE NOT FOUND (PÁGINA WHITE NÃO ENCONTRADA)';}}}}
?>