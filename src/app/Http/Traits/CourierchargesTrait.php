<?php
namespace App\Http\Traits;

use DB;
use App\Couriercharges;

trait CourierchargesTrait {
  
    public function getcharges($weight, $width, $height, $length, $pieces = 1, $is_document = 0, $tocountry_id = '1', $fromcountry_id = '5', $withinsurance = 0, $offset = '0', $limit = '100', $orderby = "priceltoh" ) {
        // Get all the brands from the Brands Table.
        $insvalue = 0;
        if($withinsurance == 1){
            $ins = DB::select("SELECT configvalue FROM sysconfig WHERE configkey = 'insurance' LIMIT 1 ");
            $insvalue = (isset($ins[0]->configvalue)?$ins[0]->configvalue:0);
        }
        
        $totvolumetric = 0;
        if(is_array($weight)){
            for($i = 0;$i<count($weight);$i++){
                $vm = ($width[$i] * $height[$i] * $length[$i])/5000;
                $totvolumetric += ($weight[$i] > $vm?$weight[$i]:$vm);
            }
        } else {       
            $volumetric = ($width * $height * $length)/5000;
            $totvolumetric = ($weight > $volumetric?$weight:$volumetric);
        }
        
        switch($orderby){
            case "priceltoh":
                $order = "T.total ASC ";
                break;
            case "pricehtol":
                $order = "T.total DESC ";
                break;
            case "daysltoh":
                $order = "T.deliverydays DESC ";
                break;
            case "dayshtol":
                $order = "T.deliverydays ASC ";
                break;
            default :
                $order = "T.total ASC ";
        }
	$q = 	"
            SELECT * FROM (
            SELECT CC.id AS ccid, C.id AS courierid, ((CC.charge_fromcountry*:pieces1) + (CC.charge_tocountry*:pieces2) + (CC.charge*:pieces3)) + ($insvalue) AS total, 
            MIN(CC.minweight) AS minallow, C2.name AS fromcountry, C.name AS couriername, CC.deliverydays AS deliverydays, C.logo  
            FROM `couriercharges` CC
            LEFT JOIN countries C1 ON C1.id = CC.fromcountry_id
            LEFT JOIN countries C2 ON C2.id = CC.tocountry_id
            LEFT JOIN couriers C ON C.id = CC.courier_id 
            WHERE CC.fromcountry_id = :fromcountry_id
            AND CC.tocountry_id = :tocountry_id
            AND minweight >= :volumetric
            GROUP BY C.id
            ) AS T 
            ORDER BY $order  
            LIMIT :offset, :limit
            ";
        $aArgs = ['pieces1'=>$pieces, 'pieces2'=>$pieces, 'pieces3'=>$pieces, 'fromcountry_id'=>$fromcountry_id, 'tocountry_id'=>$tocountry_id, 'volumetric'=>$totvolumetric, 'offset'=>$offset, 'limit'=>$limit];
        //echo $q.'<br/>'; print_r($aArgs); dd();
        $data = DB::select($q, $aArgs);
        //dd($data);
	return array('volumetric' => $totvolumetric , 'data' => $data, 
            'weight'=>$weight, 'width'=>$width, 'height'=>$height, 'length'=>$length, 'pieces'=>$pieces, 'is_document'=>$is_document, 'tocountry'=>$tocountry_id);
    }
}

