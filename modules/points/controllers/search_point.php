<?php class PointsControllersSearch_point extends FSControllers
{
    var $module;
    var $view;
    function __construct()
    {
        parent::__construct ();
    }

    function display() {
//        echo 1;
        $model = $this->model;
        $data = $model->get_data_();
        $phone = FSInput::get('phone');

        $products = $this->getProductsFromHtsoft($phone);

        // var_dump($products);

        include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
    }

    function getProductsFromHtsoft($phone)
    {
        if(!is_null($phone) && isset($phone) && !empty($phone)){

           $dataSend = json_encode( array( "callerid"=>$phone ) );

           $url = 'http://24h.htsoft.vn:9024/ActionService.svc/GetCustomerInfoByCallerID';

            return $this->sendDataBizman($url,$dataSend);
        }
        return array();
    }
    function sendDataBizman($url,$data)
    {
        $ch = curl_init( $url );
        # Setup request to send json via POST.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
//        curl_setopt($ch, CURLOPT_PROXY, "118.69.61.57:8888");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'ClientTag:24h20042017',
            'Content-Length: ' . strlen($data)
        ));

        # Return response instead of printing.

        # Send request.
        $result = curl_exec($ch);
//        var_dump($result);die;
        if($result === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        # Print response.
        return json_decode($result,true);
    }
}

?>

