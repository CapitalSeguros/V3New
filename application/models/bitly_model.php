<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bitly_model extends CI_Model {
	
	public function __Construct(){
		parent::__Construct();
	}
	
	function linkCorto($longUrl){		
		include_once('bitly.php');

			$params = array();
			//$params['access_token'] = '43c5f6b6a2f052bc70d97ce63400ad4c32dd80d0';
			//$params['access_token'] = '692ef80e150aee3e4daf709a68bcc71741c4fa9b';
			$params['access_token'] = '4ffecbdfebe97616c3b8f3428e1505be5d7febfd';
			$params['longUrl'] = (string)$longUrl; //json_decode($longUrl);
			$params['domain'] = 'bit.ly';
			$results = bitly_get('shorten', $params);
		
			return
				//var_dump($results);				
				$results['data']['url'];

	}

}