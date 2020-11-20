<?php
include ("smsactivateAPI.php");

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
$API_KEY='e958b8A042626A69bbdA629be622ff8d';
$request_get_number= new SMSActivate($API_KEY);
$result=$request_get_number->getBalance();
//$parsedResponse1 = explode(':', $result);
print_r($result);
print $result;
$guid=GUID();
$telefone='0687874578';

$request_sweet1= new request_sweet();
 $url = 'https://api.sweet.tv/SignupService/SetPhone.json';
$data="{\"phone\":\"$telefone\",\"device\":{\"type\":\"DT_Web_Browser\",\"application\":{\"type\":\"AT_SWEET_TV_Player\"},\"model\":\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36\",\"firmware\":{\"versionCode\":1,\"versionString\":\"2.2.4\"},\"uuid\":\"$guid\",\"supported_drm\":{\"widevine_modular\":true}},\"locale\":\"uk\"}";
//print $data;
//var_dump ($request_sweet1->request($url,$data,'POST',1,1));

class request_sweet
{
    //private $url = 'https://api.sweet.tv/SignupService/SetPhone.json';

    public function request($url,$data, $method, $parseAsJSON = null, $getNumber = null) {
        $method = strtoupper($method);

        if (!in_array($method, array('GET', 'POST')))
            throw new InvalidArgumentException('Method can only be GET or POST');

        //$serializedData = http_build_query($data);
        $serializedData = $data;
        if ($method === 'GET') {
            $result = file_get_contents("$url?$serializedData");
        } else {
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/json\r\n",
                    'method' => 'POST',
                    'content' => $serializedData
                )
            );

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
        }

        //$responsError = new ErrorCodes($result);
        //$check = $responsError->checkExist($result);
        //if ($check) {
        //    throw new RequestError($result);
        //}


        if ($parseAsJSON)
            return json_decode($result,true);


        $parsedResponse = explode(':', $result);

        if ($getNumber == 1) {
            $returnNumber = array('status' => $parsedResponse[1], 'code' => $parsedResponse[2]);
            return $returnNumber;
        }
//print $returnNumber;
        return $parsedResponse[1];
    }

}

$color = 'зеленое';