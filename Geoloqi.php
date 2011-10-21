<?php

class Geoloqi {
	const VERSION = '1.0.0';
	const API_URL = 'https://api.geoloqi.com/1/';

	private $clientID;
	private $clientSecret;
	private $accessToken;
	private $auth;

	public static function createWithAccessToken($accessToken) {
		return new self(null, null, array('access_token' => $accessToken));
	}

	public function __construct($clientID, $clientSecret, $auth=null) {
		$this->clientID = $clientID;
		$this->clientSecret = $clientSecret;
		$this->auth = $auth;
	}

	public function get($path, $args=null, $headers=null) {
		return $this->execute('GET', $path, $args, $headers);
	}

	public function post($path, $args=null, $headers=null) {
		return $this->execute('POST', $path, $args, $headers);
	}

	public function execute($method, $path, $args=null, $headers=null) {
		$response = $this->executeLowLevel($method, $path, $args, $headers);
		return json_decode($response);
	}

	/* This is abstracted from execute so you can get the raw return if you need to. */
	public function executeLowLevel($method, $path, $args=null, $headers=null) {
		$ch = curl_init();
		$defaultHeaders = array('Accept: application/json', 'Content-Type: application/json', 'User-Agent' => 'geoloqi-sdk-php '.self::VERSION);

		if($headers !== null) {
			$headers = array_merge($defaultHeaders, $headers);
		} else {
			$headers = $defaultHeaders;
		}

    curl_setopt($ch, CURLOPT_URL, self::API_URL.$path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		if($method === 'POST') {
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
		}

		if($this->accessToken() !== null) {
			$headers[] = 'Authorization: OAuth '.$this->auth['access_token'];
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);
		return $response;
	}

	public function accessToken() {
		return $this->auth['access_token'];
	}

	public function auth() {
		return $this->auth;
	}

	public function setAuth($auth) {
		$this->auth = $auth;
	}
}

?>