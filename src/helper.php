<?php
function curl_array($url) {
    $status = true;
    while ($status) {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    	$output = curl_exec($ch);
    	$curl_errno = curl_errno($ch);
    	$curl_error = curl_error($ch);
    	curl_close($ch);
    	if ($curl_errno == 0) {
    		$status = false;
    	} else {
    	    echo $curl_error;
    	}
    }
    return json_decode($output, true);
}
function curl_json($url) {
    $status = true;
    while ($status) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	    $output = curl_exec($ch);
	    $curl_errno = curl_errno($ch);
	    $curl_error = curl_error($ch);
	    curl_close($ch);
	    if ($curl_errno == 0) {
	    	$status = false;
	    } else {
	    	echo $curl_error;
	    }
    }
    return $output;
}

function curl_array_post($url, $post_data) {
    $status = true;
    while ($status) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	    $output = curl_exec($ch);
	    $curl_errno = curl_errno($ch);
	    $curl_error = curl_error($ch);
	    curl_close($ch);
	    if ($curl_errno == 0) {
	    	$data = json_decode($output, true);
	    	if(isset($data['data'][0]['create'])){
	    			if($data['data'][0]['create']>1000){
	    					$status = false;
	    			}
	    	}	    	
	    } else {
	    	echo $curl_error;
	    }
    }
    return $data;
}



