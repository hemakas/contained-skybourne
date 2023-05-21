
<?php

ini_set('display_errors', 1);

$url='https://api.test.sabre.com/v1.9.0/shop/flights?mode=live';

$reffer="https://api.test.sabre.com";
$agent ="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3";


$data_string='{"OTA_AirLowFareSearchRQ":{"OriginDestinationInformation":[{"DepartureDateTime":"2016-01-05T00:00:00","DestinationLocation":{"LocationCode":"LAX"},"OriginLocation":{"LocationCode":"DFW"},"RPH":"1"},{"DepartureDateTime":"2016-01-07T00:00:00","DestinationLocation":{"LocationCode":"DFW"},"OriginLocation":{"LocationCode":"LAX"},"RPH":"2"}],"POS":{"Source":[{"RequestorID":{"CompanyName":{"Code":"TN"},"ID":"REQ.ID","Type":"0.AAA.X"}}]},"TPA_Extensions":{"IntelliSellTransaction":{"RequestType":{"Name":"200ITINS"}}},"TravelerInfoSummary":{"AirTravelerAvail":[{"PassengerTypeQuantity":[{"Code":"ADT","Quantity":1}]}]}}}';

$header[]='Authorization: V1:wxtrph3qykrviuwe:DEVCENTER:EXT';
$header[]='Content-Type: application/json';
$header[]='Content-Length: ' . strlen($data_string);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_ENCODING,'gzip');
curl_setopt($ch, CURLOPT_REFERER, $reffer);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_POST,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$content = curl_exec($ch);
echo "<pre>";
print_r(json_decode($content));

?>
