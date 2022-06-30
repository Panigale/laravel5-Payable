<?php
namespace Panigale\Payment\Sdk\Sonet;

class Somp {
	/**
	* @param string "post"或是"soap"，決定與API的溝通方式採用HttpPost或是Soap協定
	* @param string 傳輸到API的資料內容，必須要有doAction欄位決定要執行的Function
	* @param string API的路徑
	* @return Array
	*/
	function doRequest($method,$data,$apiUrl){
		switch($method) {
			case "post" :
				/**
				* 用php_curl模組送出Post資料，需要在php.ini中啟用php_curl模組
				*/
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $apiUrl);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch, CURLOPT_POST, 1);
				$postfield = "";
				foreach ($data as $k=>$v) {
					$postfield .= "$k=".urlencode($v)."&";
				}
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
                curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
				$strReturn = curl_exec($ch);
				curl_close($ch);
				
				/**
				* 將回傳的結果處理後以Association Array的方式傳回
				*/
                try{
                    $finalAry = $this->getResult($strReturn);
                }catch (\Exception $e){
                    throw new \Exception([
                        'status' => 'error',
                        'message' => $strReturn,
                    ]);
                }
				break;
			default :
				$finalAry = "";
				break;
		}
		return $finalAry;
	}

	function getResult($result,$method = "post"){
		switch ($method){
			case "post" :
				$rtAry = explode("\t",$result);
				$keyAry = explode("|",$rtAry[0]);
				$valueAry = explode("|",$rtAry[1]);
				$finalAry = array();
				for ($i=0; $i<count($keyAry); $i++) {
					$finalAry[$keyAry[$i]] = $valueAry[$i];
				}
				break;
			default :
				$finalAry = null;
				break;
		}
		return $finalAry;
	}

}

?>