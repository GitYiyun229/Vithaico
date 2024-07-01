<?php
/*
 * Huy write
 */

class FSGetImages
{
    function __construct(){

    }

    /**
     * Lấy file và lưu vào nơi được chỉ định
     *
     * @param string $url Địa chỉ file nguồn
     * @param string $local Địa chỉ file đích
     *
     * @return Bool
     */
    function curlSaveToFile($url, $local){
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $result = parse_url($url);
            curl_setopt($ch, CURLOPT_REFERER, $result['scheme'] . '://' . $result['host']);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');
            $raw = curl_exec($ch);
            curl_close($ch);
            $fp = fopen($local, 'x');
            fwrite($fp, $raw);
            if (filesize($local) > 10) {
                return true;
            } else {
                @unlink($local);
            }
            fclose($fp);
        }catch (Exception $e) {
            trigger_error(sprintf('Curl failed with error #%d: %s', $e->getCode(), $e->getMessage()), E_USER_ERROR);
        }
        return false;
    }

    function removeSign($str) {
        $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
            "ằ","ắ","ặ","ẳ","ẵ",
            "è","é","ẹ","ẻ","ẽ","ê","ề" ,"ế","ệ","ể","ễ",
            "ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ","ê","ù","à");
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D","e","u","a");
        return str_replace($coDau, $khongDau, $str);
    }

    function createAlias($string){
        $string = FSGetImages::removeSign($string);
        $string = trim(preg_replace("/[^A-Za-z0-9]/i", " ", $string));
        $string = str_replace(" ","-",$string);
        $string	= str_replace("-----","-",$string);
        $string	= str_replace("----","-",$string);
        $string	= str_replace("---","-",$string);
        $string	= str_replace("--","-",$string);
        $string = strtolower($string);
        return $string;
    }

    /**
     * Lấy tât cả ảnh trong nội dung
     *
     * @param String $html
     *
     * @return Array
     */
    function getImagesSrc($html = 0){
        $return = array();
        preg_match_all('#src="https://(.*?)"#is', $html, $images);
        if(isset($images[1]))
            foreach($images[1] as $img)
                if(preg_match('"', $img))
                    $return[] = $img;
        //echo $img;die;
        return $return;
    }


    function getAllImagesContent($html = '', $baseUrl = ''){
        $file = FSFactory::getClass('FsFiles','');
        $arrSearch = FSGetImages::getImagesSrc($html);
        $arrReplace = array();
        foreach($arrSearch as $image_url){
            $path_original = PATH_BASE.'upload_images/images/'.date('Y/m/');
            $file->create_folder ($path_original);
            preg_match("#http#is", $image_url, $matches);
            preg_match("#bizweb#is", $image_url, $matches);
            preg_match("#https#is", $image_url, $matches);
            if(empty($matches)) {
                $image_url = $baseUrl.$image_url;
                echo $image_url;die;
            }
            $fileinfo = pathinfo($image_url);

            $local = $path_original.FSGetImages::createAlias($fileinfo['filename']).'.'.$fileinfo['extension'];
            $i = 1;
            while (file_exists($local)){
                $local = $path_original.FSGetImages::createAlias($fileinfo['filename']).'-'.$i.'.'.$fileinfo['extension']; $i ++;
            }
            if(FSGetImages::curlSaveToFile($image_url, $local))
                $arrReplace[] = str_replace(PATH_BASE, '/', $local);
            else
                $arrReplace[] = $image_url;
        }
        return str_replace($arrSearch, $arrReplace, $html);
    }
}