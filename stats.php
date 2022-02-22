<?php


$filename = "pinboard.json";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);

$bookmarks = json_decode($contents,true);
//$bookmarks = array_slice($bookmarks,0,25);
//if(http_response('http://algaelab.org')){
//	print("T");
//} else {
//	print("F");
//}
//return;


$years = array();
$years_checked = array();
$counter = 0;
error_log("Found ".count($bookmarks).' bookmarks to check',0);
foreach($bookmarks as $b){
	$y = substr($b['time'],0,4);
	if (!array_key_exists($y,$years)){
		$years[$y] = 0;
		$years_checked[$y] = 0;
	}
	$years[$y]++;
	error_log('Checking ('.++$counter.')',0);
	if(http_response($b['href'])){
		$years_checked[$y]+= 1;
		print('✅');
	} else {
		print('❌');
	}
	print(','.$y.',"'.$b['href'].'"'."\n");

}

$total_checked = 0;
$total_urls = 0;
foreach($years as $k=>$v){
	$total_urls += $v;
	$total_checked += $years_checked[$k];

	error_log($k."\n".'----',0);
	$line = ($years_checked[$k].'/'.$v.' = ');

	if ($years_checked[$k] > 0){
		$line .= ((($years_checked[$k]/$v)*100).'%');
	} else {
		$line .= ('0%');		
	}
	error_log($line."\n",0);
}
error_log('TOTAL',0);
$line = ($total_checked.'/'.$total_urls.' = ');
$line .= ((($total_checked/$total_urls)*100).'%');
error_log($line,0);



function http_response($url, $status = null) 
{ 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_HEADER, TRUE); 
    curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch,CURLOPT_TIMEOUT, 10);
    curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.3 Safari/605.1.15");
    $head = curl_exec($ch); 
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 

    curl_close($ch); 
    
    if(!$head) 
    { 
        return FALSE; 
    } 
    
    if($status === null) 
    { 
        if($httpCode < 400) 
        { 
            return TRUE; 
        } 
        else 
        { 
            return FALSE; 
        } 
    } 
    elseif($status == $httpCode) 
    { 
        return TRUE; 
    } 
    
    return FALSE; 
} 
?>