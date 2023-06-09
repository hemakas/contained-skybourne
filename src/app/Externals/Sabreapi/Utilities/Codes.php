<?php

namespace App\Externals\Sabreapi\Utilities;

use App\Airportcode;

/**
 * Description of Codes
 *
 * @author skaushalye
 */
class Codes {
    
    // IATA Designator", "Airline Name", "3-Digit Code","ICAO Designator","Country
    private $airports = [
        "JP"=>["Adria Airways", "165", "ADR","Slovenia"],
        "A3"=>["Aegean Airlines", "390", "AEE","Greece"],
        "EI"=>["Aer Lingus", "53","EIN","Ireland"],
        "P5"=>["Aero República", "845","RPB","Colombia"],
        "SU"=>["Aeroflot", "555", "AFL","Russian Federation"],
        "AR"=>["Aerolineas Argentinas", "44", "ARG", "Argentina"],
        "2K"=>["Aerolineas Galapagos S.A. Aerogal", "547","GLG","Ecuador"],
        "AM"=>["Aeromexico", "139", "AMX","Mexico"],
        "ZI"=>["Aigle Azur", "439", "AAF","France"],
        "AH"=>["Air Algerie", "124","DAH", "Algeria"],
        "G9"=>["Air Arabia", "514", "ABY","United Arab Emirates"],
        "KC"=>["Air Astana", "465","KZR","Kazakhstan"],
        "UU"=>["Air Austral", "760","REU","Reunion"],
        "BT"=>["Air Baltic", "657","BTI","Latvia"],
        "AB"=>["Air Berlin", "745", "BER","Germany"],
        "BP"=>["Air Botswana", "636", "BOT", "Botswana"],
        "2J"=>["Air Burkina", "226","VBW", "Burkina Faso"],
        "SM"=>["Air Cairo", "381","MSC","Egypt"],
        "TY"=>["Air Caledonie", "190","TPC","New Caledonia"],
        "AC"=>["Air Canada", "14", "ACA","Canada"],
        "TX"=>["Air Caraibes", "427","FWI","Guadeloupe"],
        "CA"=>["Air China", "999","CCA","China"],
        "XK"=>["Air Corsica", "146","CCM","France"],
        "UX"=>["Air Europa", "996", "AEA","Spain"],
        "AF"=>["Air France", "57", "AFR","France"],
        "AI"=>["Air India", "98", "AIC","India"],
        "JS"=>["Air Koryo", "120","KOR","Korea"],
        "NX"=>["Air Macau", "675", "AMU","Macao SAR, China"],
        "MD"=>["Air Madagascar", "258","MDG","Madagascar"],
        "KM"=>["Air Malta", "643", "AMC","Malta"],
        "MK"=>["Air Mauritius", "239","MAU","Mauritius"],
        "9U"=>["Air Moldova", "572","MLD","Moldova"],
        "SW"=>["Air Namibia", "186","NMB","Namibia"],
        "NZ"=>["Air New Zealand,86,ANZ,New Zealand"],
        "PX"=>["Air Niugini", "656", "ANG","Independent State of Papua New Guinea"],
        "YW"=>["Air Nostrum", "694", "ANE","Spain"],
        "P4"=>["Air Peace", "710", "APK","Nigeria"],
        "JU"=>["Air SERBIA a.d. Beograd", "115", "A-SL","Serbia"],
        "HM"=>["Air Seychelles", "61","SEY","Seychelles"],
        "VT"=>["Air Tahiti", "135","VTA","French Polynesia"],
        "TN"=>["Air Tahiti Nui", "244","THT","French Polynesia"],
        "TS"=>["Air Transat", "649","TSC","Canada"],
        "NF"=>["Air Vanuatu", "218", "AVN","Vanuatu"],
        "RU"=>["AirBridgeCargo Airlines", "580","ABW","Russian Federation"],
        "SB"=>["Aircalin", "63","ACI","New Caledonia"],
        "4Z"=>["Airlink", "749","LNK","South Africa"],
        "AS"=>["Alaska Airlines", "27","ASA","United States"],
        "AZ"=>["Alitalia", "55","AZA","Italy"],
        "NH"=>["All Nippon Airways", "205","ANA","Japan"],
        "4W"=>["Allied Air", "574","AJK","Nigeria"],
        "UJ"=>["AlMasria Universal Airlines", "110","LMU","Egypt"],
        "AA"=>["American Airlines", "1","AAL","United States"],
        "W3"=>["Arik Air", "725","ARA","Nigeria"],
        "IZ"=>["Arkia Israeli Airlines", "238","AIZ","Israel"],
        "OZ"=>["Asiana", "988","AAR","Korea"],
        "5Y"=>["Atlas Air", "369","GTI","United States"],
        "KK"=>["AtlasGlobal", "610","KKK","Turkey"],
        "AU"=>["Austral", "143","AUT","Argentina"],
        "OS"=>["Austrian", "257","AUA","Austria"],
        "AV"=>["AVIANCA", "134","AVA","Colombia"],
        "O6"=>["Avianca Brasil", "247","ONE","Brazil"],
        "J2"=>["Azerbaijan Airlines", "771","AHY","Azerbaijan"],
        "AD"=>["Azul Brazilian Airlines", "577","AZU","Brazil"],
        "UP"=>["Bahamasair", "111", "BHS", "Bahamas"],
        "PG"=>["Bangkok Air", "829", "BKP","Thailand"],
        "B2"=>["Belavia - Belarusian Airlines", "628", "BRU", "Belarus"],
        "8H"=>["BH AIR", "366", "BGH", "Bulgaria"],
        "BG"=>["Biman", "997", "BBC", "Bangladesh"],
        "NT"=>["Binter Canarias", "474","IBB","Spain"],
        "0B"=>["Blue Air", "475", "BMS","Romania"],
        "BV"=>["Blue Panorama", "4", "BPA","Italy"],
        "BM"=>["bmi Regional", "480", "BMR","United Kingdom"],
        "OB"=>["Boliviana de Aviación - BoA", "930", "BOV", "Bolivia"],
        "TF"=>["Braathens Regional Aviation AB", "276","SCW","Sweden"],
        "BA"=>["British Airways", "125", "BAW","United Kingdom"],
        "SN"=>["Brussels Airlines", "82", "BEL","Belgium"],
        "FB"=>["Bulgaria air", "623","LZB", "Bulgaria"],
        "5C"=>["C.A.L. Cargo Airlines", "700","ICL","Israel"],
        "QC"=>["Camair-Co", "40","CRC","Cameroon"],
        "K6"=>["Cambodia Angkor Air", "188","KHV","Cambodia"],
        "JD"=>["Capital Airlines", "898","CBJ","China"],
        "W8"=>["Cargojet Airways", "489","CJT","Canada"],
        "CV"=>["Cargolux S.A.", "172","CLX","Luxembourg"],
        "BW"=>["Caribbean Airlines", "106", "BWA","Trinidad and Tobago"],
        "V3"=>["Carpatair", "21","KRP","Romania"],
        "KA"=>["Cathay Dragon", "43","HDA","Hong Kong SAR China"],
        "CX"=>["Cathay Pacific", "160","CPA","Hong Kong SAR China"],
        "5Z"=>["Cemair", "225","KEM","South Africa"],
        "CI"=>["China Airlines", "297","CAL","Chinese Taipei"],
        "CK"=>["China Cargo Airlines", "112","CKK","China"],
        "MU"=>["China Eastern", "781","CES","China"],
        "G5"=>["China Express Airlines", "987","HXA","China"],
        "CF"=>["China Postal Airlines", "804","CYZ","China"],
        "CZ"=>["China Southern Airlines", "784","CSN","China"],
        "WX"=>["CityJet", "689", "BCY","Ireland"],
        "MN"=>["Comair", "161","CAW","South Africa"],
        "DE"=>["Condor", "881","CFG","Germany"],
        "CM"=>["COPA Airlines", "230","CMP","Panama"],
        "XC"=>["Corendon Airlines", "395","CAI","Turkey"],
        "SS"=>["Corsair International", "923","CRL","France"],
        "OU"=>["Croatia Airlines", "831","CTN","Croatia"],
        "CU"=>["Cubana", "136","CUB","Cuba"],
        "OK"=>["Czech Airlines j.s.c", "64","CSA","Czech Republic"],
        "9J"=>["Dana Air", "234","DAN","Nigeria"],
        "DL"=>["Delta Air Lines", "6","DAL","United States"],
        "D0"=>["DHL Air", "936","DHK","United Kingdom"],
        "ES*"=>["DHL Aviation EEMEA B.S.C.(c)", "155","DHX","Bahrain"],
        "Z6*"=>["Dniproavia", "181","UDN","Ukraine"],
        "ZE"=>["Eastar Jet", "839","ESR","Korea"],
        "MS"=>["Egyptair", "77","MSR","Egypt"],
        "LY"=>["EL AL", "114","ELY","Israel"],
        "EK"=>["Emirates", "176","UAE","United Arab Emirates"],
        "ET"=>["Ethiopian Airlines", "71","ETH","Ethiopia"],
        "EY"=>["Etihad Airways", "607","ETD","United Arab Emirates"],
        "YU"=>["Euroatlantic Airways", "551","MMZ","Portugal"],
        "QY"=>["European Air Transport", "615","BCS","Germany"],
        "EW"=>["Eurowings", "104","EWG","Germany"],
        "BR"=>["EVA Air", "695","EVA","Chinese Taipei"],
        "FX"=>["Federal Express", "23","FDX","United States"],
        "FJ"=>["Fiji Airways", "260","FJI","Fiji"],
        "AY"=>["Finnair", "105","FIN","Finland"],
        "BE"=>["Flybe", "267","BEE","United Kingdom"],
        "FZ"=>["Flydubai", "141","FDB","United Arab Emirates"],
        "FT"=>["FlyEgypt", "","FEG","Egypt"],
        "FH"=>["Freebird Airlines","None","FHY","Turkey"],
        "GA"=>["Garuda", "126","GIA","Indonesia"],
        "A9"=>["Georgian Airways", "606","TGZ","Georgia"],
        "ST"=>["Germania", "246","GMI","Germany"],
        "GX"=>["Guangxi Beibu Gulf Airlines", "872","CBG","China"],
        "GF"=>["Gulf Air", "72","GFA","Bahrain"],
        "HR*"=>["Hahn Air", "169","HHN","Germany"],
        "HU"=>["Hainan Airlines", "880","CHH","China"],
        "HA"=>["Hawaiian Airlines", "173","HAL","United States"],
        "5K"=>["Hi Fly", "","HFY","Portugal"],
        "HX"=>["Hong Kong Airlines", "851","CRK","Hong Kong SAR China"],
        "UO"=>["Hong Kong Express Airways", "128","HKE","Hong Kong SAR China"],
        "IB"=>["IBERIA", "75","IBE","Spain"],
        "FI"=>["Icelandair", "108","ICE","Iceland"],
        "7i"=>["InselAir", "958","INC","Curaçao"],
        "4O"=>["Interjet", "837","AIJ","Mexico"],
        "IR"=>["Iran Air", "96","IRA","Iran"],
        "B9"=>["Iran Airtour Airline", "491","IRB","Iran"],
        "EP"=>["Iran Aseman Airlines", "815","IRC","Iran"],
        "6H"=>["Israir", "818","ISR","Israel"],
        "JL"=>["Japan Airlines", "131","JAL","Japan"],
        "J9"=>["Jazeera Airways", "486","JZR","Kuwait"],
        "9W"=>["Jet Airways", "589","JAI","India"],
        "S2"=>["Jet Lite (India)", "705","JLL","India"],
        "B6"=>["JetBlue", "279","JBU","United States"],
        "R5"=>["Jordan Aviation", "151","JAV","Jordan"],
        "5N"=>["JSC Nordavia-RA", "316","AUL","Russian Federation"],
        "HO"=>["Juneyao Airlines", "18","DKH","China"],
        "KQ"=>["Kenya Airways", "706","KQA","Kenya"],
        "Y9"=>["Kish Air", "780","IRK","Iran"],
        "KL"=>["KLM", "74","KLM","Netherlands"],
        "KE"=>["Korean Air", "180","KAL","Korea"],
        "KU"=>["Kuwait Airways", "229","KAC","Kuwait"],
        "LR"=>["LACSA", "133","LRC","Costa Rica"],
        "TM"=>["LAM", "68","LAM","Mozambique"],
        "QV"=>["Lao Airlines", "627","LAO","Lao"],
        "4M"=>["LATAM Airlines Argentina", "469","DSM","Argentina"],
        "JJ"=>["LATAM Airlines Brasil", "957","TAM","Brazil"],
        "4C"=>["LATAM Airlines Colombia", "35","ARE","Colombia"],
        "XL"=>["LATAM Airlines Ecuador", "462","LNE","Ecuador"],
        "LA"=>["LATAM Airlines Group", "45","LAN","Chile"],
        "PZ"=>["LATAM Airlines Paraguay", "692","LAP","Paraguay"],
        "LP"=>["LATAM Airlines Peru", "544","LPE","Peru"],
        "M3"=>["LATAM Cargo Brasil", "549","TUS","Brazil"],
        "UC"=>["LATAM Cargo Chile", "145","LCO","Chile"],
        "M7"=>["LATAM Cargo Mexico", "865","MAA","Mexico"],
        "LI"=>["LIAT Airlines", "140","LIA","Antigua and Barbuda"],
        "N4"=>["LLC NORD WIND", "216","NWS","Russian Federation"],
        "GJ"=>["Loong Air", "891","CDC","China"],
        "LO"=>["LOT Polish Airlines", "80","LOT","Poland"],
        "8L"=>["Lucky Air", "859","LKE","China"],
        "LH"=>["Lufthansa", "220","DLH","Germany"],
        "LH"=>["Lufthansa Cargo", "20","GEC","Germany"],
        "CL"=>["Lufthansa CityLine", "683","CLH","Germany"],
        "LG"=>["Luxair", "149","LGL","Luxembourg"],
        "W5"=>["Mahan Air", "537","IRM","Iran"],
        "MH"=>["Malaysia Airlines", "232","MAS","Malaysia"],
        "OD"=>["Malindo Air", "816","MXD","Malaysia"],
        "AE"=>["Mandarin Airlines", "803","MDA","Chinese Taipei"],
        "MP"=>["Martinair Cargo", "129","MPH","Netherlands"],
        "L6"=>["Mauritania Airlines International", "495","MAI","Mauritania"],
        "ME"=>["MEA", "76","MEA","Lebanon"],
        "IG"=>["Meridiana fly", "191","ISS","Italy"],
        "OM"=>["MIAT", "289","MGL","Mongolia"],
        "M4"=>["Mistral Air", "408","MSA","Italy"],
        "MB"=>["MNG Airlines", "716","MNB","Turkey"],
        "YM"=>["Montenegro Airlines", "409","MGX","Montenegro"],
        "8M"=>["Myanmar Airways International", "599","MMA","Myanmar"],
        "NO"=>["Neos", "703","NOS","Italy"],
        "NE"=>["Nesma Airlines", "477","NMA","Egypt"],
        "2N"=>["Nextjet", "121","NTJ","Sweden"],
        "HG"=>["NIKI", "","NLY","Austria"],
        "NP"=>["Nile Air", "325","NIA","Egypt"],
        "KZ"=>["Nippon Cargo Airlines (NCA)", "933","NCA","Japan"],
        "BJ"=>["Nouvelair", "796","LBT","Tunisia"],
        "BK"=>["Okay Airways", "866","OKA","China"],
        "OA"=>["Olympic Air", "50","OAL","Greece"],
        "WY"=>["Oman Air", "910","OAS","Oman"],
        "8Q"=>["Onur Air", "66","OHY","Turkey"],
        "OF"=>["Overland Airways", "","OLA","Nigeria"],
        "IK"=>["Pegas Fly", "770","KAR","Russian Federation"],
        "PC"=>["Pegasus Airlines", "624","PGT","Turkey"],
        "NI"=>["PGA-Portugália Airlines", "685","PGA","Portugal"],
        "PR"=>["Philippine Airlines", "79","PAL","Philippines"],
        "PK"=>["PIA", "214","PIA","Pakistan"],
        "PW"=>["Precision Air", "31","PRF","Tanzania"],
        "PV"=>["PrivatAir", "","PTI","Switzerland"],
        "QF"=>["Qantas", "81","QFA","Australia"],
        "QR"=>["Qatar Airways", "157","QTR","Qatar"],
        "FV"=>["Rossiya Airlines", "195","SDM","Russian Federation"],
        "AT"=>["Royal Air Maroc", "147","RAM","Morocco"],
        "BI"=>["Royal Brunei", "672","RBA","Brunei Darussalam"],
        "RJ"=>["Royal Jordanian", "512","RJA","Jordan"],
        "WB"=>["RwandAir", "459","RWD","Rwanda"],
        "S7"=>["S7 Airlines", "421","SBI","Russian Federation"],
        "SA"=>["SAA", "83","SAA","South Africa"],
        "FA*"=>["Safair", "640","SFR","South Africa"],
        "4Q"=>["Safi Airways", "741","SFW","Afghanistan"],
        "S3"=>["Santa Barbara", "249","BBR","Venezuela"],
        "SK"=>["SAS", "117","SAS","Sweden"],
        "SP"=>["SATA Air Açores", "737","SAT","Portugal"],
        "S4"=>["SATA Internacional", "331","RZO","Portugal"],
        "SV"=>["Saudi Arabian Airlines", "65","SVA","Saudi Arabia"],
        "O3"=>["SF Airlines", "921","CSS","China"],
        "SC"=>["Shandong Airlines", "324","CDG","China"],
        "FM"=>["Shanghai Airlines", "774","CSH","China"],
        "ZH"=>["Shenzhen Airlines", "479","CSZ","China"],
        "SQ"=>["SIA", "618","SIA","Singapore"],
        "SQ"=>["SIA Cargo", "","SQC","Singapore"],
        "3U"=>["Sichuan Airlines", "876","CSC","China"],
        "7L"=>["Silk Way West Airlines", "501","AZG","Azerbaijan"],
        "MI"=>["Silkair", "629","SLK","Singapore"],
        "H2"=>["SKY Airline", "605","SKU","Chile"],
        "SZ"=>["Somon Air", "413","SMR","Tajikistan"],
        "XZ"=>["South African Express Airways", "","EXY","South Africa"],
        "UL"=>["SriLankan", "603","ALK","Sri Lanka"],
        "XQ*"=>["SunExpress", "564","SXS","Turkey"],
        "PY"=>["Surinam Airways", "192","SLM","Suriname"],
        "LX"=>["SWISS", "724","SWR","Switzerland"],
        "RB"=>["Syrianair", "70","SYR","Syrian Arab Republic"],
        "DT"=>["Angola Airlines", "118","DTA","Angola"],
        "TA"=>["TACA", "202","TAI","El Salvador"],
        "T0"=>["TACA Peru", "530","TPU","Peru"],
        "VR"=>["TACV Cabo Verde Airlines", "696","TCV","Cape Verde"],
        "EQ"=>["TAME - Linea Aerea del Ecuador", "269","TAE","Ecuador"],
        "TP"=>["TAP Portugal", "47","TAP","Portugal"],
        "RO"=>["TAROM", "281","ROT","Romania"],
        "SF"=>["Tassili Airlines", "515","DTH","Algeria"],
        "TG"=>["Thai Airways International", "217","THA","Thailand"],
        "SL"=>["Thai Lion Air", "310","TLM","Thailand"],
        "TK"=>["Turkish Airlines", "235","THY","Turkey"],
        "GS"=>["Tianjin Airlines", "826","GCR","China"],
        "X3*"=>["TUIfly", "617","TUI","Germany"],
        "TU"=>["Tunisair", "199","TAR","Tunisia"],
        "TW"=>["T'way Air", "722","TWB","Korea"],
        "PS"=>["Ukraine International Airlines", "566","AUI","Ukraine"],
        "UA"=>["United Airlines", "16","UAL","United States"],
        "5X"=>["UPS Airlines", "406","UPS","United States"],
        "U6"=>["Ural Airlines", "262","SVR","Russian Federation"],
        "UT"=>["UTair", "298","UTA","Russian Federation"],
        "HY"=>["Uzbekistan Airways", "250","UZB","Uzbekistan"],
        "VJ"=>["Vietjet", "978","VJC","Vietnam"],
        "VN"=>["Vietnam Airlines", "738","HVN","Vietnam"],
        "NN"=>["VIM Airlines", "823","MOV","Russian Federation"],
        "VS"=>["Virgin Atlantic", "932","VIR","United Kingdom"],
        "VA"=>["Virgin Australia", "795","VOZ","Australia"],
        "Y4*"=>["Volaris", "36","VOI","Mexico"],
        "G3"=>["VRG Linhas Aereas S.A. - Grupo GOL", "127","GLO","Brazil"],
        "VY"=>["Vueling", "30","VLG","Spain"],
        "EB"=>["Wamos Air", "460","PLM","Spain"],
        "WS"=>["WestJet", "838","WJA","Canada"],
        "WI"=>["White coloured by you", "97","WHT","Portugal"],
        "WF"=>["Wideroe", "701","WIF","Norway"],
        "MF"=>["Xiamen Airlines", "731","CXA","China"],
    ];
    
    public $cabinClasses = [
        'Y' => "Economy",
        'C' => "Business",
        'S' => "Economy Premium",
        'J' => "Business Premium",
        'F' => "First",
        'P' => "First Premium",
    ];
           
    public $multiairportCities = [
        'AUH'=>'Abu Dhabi, United Arab Emirates',
        'DXB'=>'Dubai, United Arab Emirates',
        'BUE'=>'Buenos Aires, Argentina',
        'LNZ'=>'Linz, Austria ',
        'VIE'=>'Vienna, Austria ',
        'MEL'=>'Melbourne, Australia',
        'BAK'=>'Baku, Azerbaijan',
        'BRU'=>'Brussels, Belgium',
        'MES'=>'Medan, Belgium',
        'SRZ'=>'Santa Cruz, Bolivia',
        'BHZ'=>'Belo Horizonte, Brazil',
        'RIO'=>'Rio De Janeiro, Brazil',
        'SAO'=>'Sao Paulo, Brazil',
        'YEA'=>'Edmonton, Canada',
        'YMQ'=>'Montreal, Canada',
        'YOW'=>'Ottawa, Canada',
        'YTO'=>'Toronto, Canada',
        'EAP'=>'Basel, Switzerland',
        'DXB'=>'Dubai, Ivory Coast',
        'WCA'=>'Castro, Chile',
        'BJS'=>'Beijing, China',
        'SHA'=>'Shanghai, China',
        'SIA'=>'Xi An, China',
        'BER'=>'Berlin, Germany',
        'CGN'=>'Cologne, Germany',
        'DUS'=>'Dusseldorf, Germany',
        'STR'=>'Stuttgart, Germany',
        'QUF'=>'Tallinn, Estonia',
        'ALY'=>'Alexandria, Egypt',
        'TCI'=>'Tenerife, Spain',
        'EAP'=>'Basel, France',
        'LIL'=>'Lille, France',
        'LYS'=>'Lyon, France',
        'PAR'=>'Paris, France',
        'SXB'=>'Strasbourg, France',
        'BFS'=>'Belfast, Great Britain',
        'LON'=>'London, Great Britain',
        'NQT'=>'Nottingham, Great Britain',
        'SDZ'=>'Shetland Islands, Great Britain',
        'JKT'=>'Jakarta, Indonesia',
        'MES'=>'Medan, Indonesia',
        'REK'=>'Reykjavik, Iceland',
        'FLR'=>'Florence, Vatican',
        'MIL'=>'Milan, Vatican',
        'ROM'=>'Rome, Vatican',
        'OSA'=>'Osaka, Japan',
        'SPK'=>'Sapporo, Japan',
        'TYO'=>'Tokyo, Japan',
        'SEL'=>'Seoul, South Korea',
        'SLU'=>'St Lucia, St. Lucia',
        'MLW'=>'Monrovia, Liberia',
        'CAS'=>'Casablanca, Morocco',
        'KUL'=>'Kuala Lumpur, Malaysia',
        'ENS'=>'Enschede, Netherlands',
        'OSL'=>'Oslo, Norway',
        'BUH'=>'Bucharest, Romania',
        'MOW'=>'Moscow, Russia',
        'ULY'=>'Ulyanovsk, Russia',
        'MMA'=>'Malmo, Sweden',
        'STO'=>'Stockholm, Sweden',
        'BKK'=>'Bangkok, Thailand',
        'ANK'=>'Ankara, Turkey',
        'BXN'=>'Bodrum, Turkey',
        'IST'=>'Istanbul, Turkey',
        'IZM'=>'Izmir, Turkey',
        'SSX'=>'Samsun, Turkey',
        'TPE'=>'Taipei, Taiwan',
        'IEV'=>'Kiev, Ukraine',
        'LTS'=>'Altus, U.S.A.',
        'AIY'=>'Atlantic City, U.S.A.',
        'CHI'=>'Chicago, U.S.A.',
        'CVG'=>'Cincinnati, U.S.A.',
        'CSM'=>'Clinton, U.S.A.',
        'QDF'=>'Dallas - Fort Worth, U.S.A.',
        'DTT'=>'Detroit, U.S.A.',
        'FYV'=>'Fayetteville, U.S.A.',
        'FMY'=>'Fort Myers, U.S.A.',
        'HAR'=>'Harrisburg, U.S.A.',
        'HFD'=>'Hartford, U.S.A.',
        'QHO'=>'Houston, U.S.A.',
        'MKC'=>'Kansas City, U.S.A.',
        'ILE'=>'Killeen, U.S.A.',
        'NYC'=>'New York, U.S.A.',
        'ORL'=>'Orlando, U.S.A.',
        'PFN'=>'Panama City, U.S.A.',
        'QPH'=>'Philadelphia, U.S.A.',
        'SSM'=>'Sault Ste Marie, U.S.A.',
        'SEA'=>'Seattle, U.S.A.',
        'SFY'=>'Springfield, U.S.A.',
        'SBS'=>'Steamboat Springs, U.S.A.',
        'TPA'=>'Tampa - St Petersburg, U.S.A.',
        'WAS'=>'Washington, U.S.A.',
        'STX'=>'St Croix Island, U.S. Virgin Islands',
        'NHA'=>'Nha Trang, Vietnam',
    ];
    
    public function getAirlineName($code){
        if (array_key_exists($code, $this->airports)) {
            return $this->airports[$code][0];
        }
        return "";
    }
    
    public function getCabinClass($code){
        if (array_key_exists($code, $this->cabinClasses)) {
            return $this->cabinClasses[$code];
        }
        return "";
    }
    
    public function getMultiairportCities($string){
        $return = [];
        $strupper = strtoupper($string);
        if (strlen($string) == 3 && array_key_exists($strupper, $this->multiairportCities)) {
            $return[$strupper] = $this->multiairportCities[$strupper];
        }
        
        // filter in values
        $regex = "#^".$string."(.*)$#i";
        $fl_array = preg_grep($regex, $this->multiairportCities);
        return array_merge($return, $fl_array);
    }
    
    
    /**
     * Get full name for given code
     * @param string $code
     * @return json array
     */
    public static function airportNameByCode($code) {
        $aReturn = [];        
            $airport = Airportcode::where('code', '=', $code)->first();
            if($airport){
                $aReturn = $airport->toArray();
                $aReturn = $aReturn['airportname'].', '.$aReturn['cityname'];
            } else {
                $aReturn = "";
            }
        return $aReturn;
    }
    
    
    /**
     * Get city name for given code
     * @param string $code
     * @return json array
     */
    public static function airportCityByCode($code) {
        $aReturn = [];        
            $airport = Airportcode::where('code', '=', $code)->first();
            if($airport){
                $aReturn = $airport->toArray();
                $aReturn = $aReturn['cityname'];
            } else {
                $aReturn = "";
            }
        return $aReturn;
    }
}
