<?php


$filename = "pinboard.json";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);

$bookmarks = json_decode($contents,true);

//$bookmarks = array_slice($bookmarks,0,25);

$years = array();
$years_checked = array();
$counter = 0;
print("Found ".$bookmarks.count().' bookmarks to check');
foreach($bookmarks as $b){
	$y = substr($b['time'],0,4);
	if (!array_key_exists($y,$years)){
		$years[$y] = 0;
		$years_checked[$y] = 0;
	}
	$years[$y]++;
	if(http_response($b['href'])){
		$years_checked[$y]+= 1;
		print('✅');
	} else {
		print('❌');
	}
	print(' Checking ('.++$counter.'): '.$b['href'].' from '.$y."\n");

}

$total_checked = 0;
$total_urls = 0;
foreach($years as $k=>$v){
	$total_urls += $v;
	$total_checked += $years_checked[$k];

	print($k."\n----\n");
	print($years_checked[$k].'/'.$v.' = ');

	if ($years_checked[$k] > 0){
		print((($years_checked[$k]/$v)*100).'%');
	} else {
		print('0%');		
	}
	print("\n");
}
print('TOTAL'."\n");
print($total_checked.'/'.$total_urls.' = ');
print((($total_checked/$total_urls)*100).'%');




function http_response($url, $status = null) 
{ 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_HEADER, TRUE); 
    curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch,CURLOPT_TIMEOUT, 10);
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