<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Gshorter{
	/**
	Name: Gshorter
	Author: Scrisoft
	Created: 03/05/2016
	A class which shortes the urls. This class will work only if you will add an api key in the config.php file.
	**/
	protected $apiKey;
	public function __construct()
	{
		$this->CI = & get_instance();
		$this->apiKey = $this->CI->config->item("google_api_key");
	}
	public function short($url)
	{
		if($this->apiKey)
		{
			$post = array('longUrl' => $url);
			$json = json_encode($post);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$this->apiKey);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_REFERER, $this->CI->config->item("domain"));
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
			$response = curl_exec($curl);
			// Change the response json string to object
			$json = json_decode($response);
			curl_close($curl);
			if(property_exists($json,'id'))
			{
				// if $json->id exists will be returned else will be returned the $url
				return $json->id;
			}
			else
			{
				return $url;
			}
		}
		else
		{
			return $url;
		}
	}
}
/* End of file Gshorter.php */