<?php 
	
	$pontoslatlong = [];
    $address = urlencode(@$_POST['roteiro']);
    $request_url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address."&sensor=false";
    $status = @file_get_contents($request_url);
    $data = json_decode($status,true);
    if ($data){
    	$pontoslatlong[] = [
    		"lat" => $data['results'][0]['geometry']['location']['lat'],
    		"long"=> $data['results'][0]['geometry']['location']['lng']
    	];
    }

    echo json_encode($pontoslatlong);

?>
