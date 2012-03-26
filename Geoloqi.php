<?php

class Geoloqi {
	const VERSION = '1.0.0';
	const API_URL = 'https://api.geoloqi.com/1/';
	const OAUTH_URL = 'https://geoloqi.com/oauth/authorize';

	private $clientID;
	private $clientSecret;
	private $redirectURI;
	private $accessToken;
	private $auth;

	public static function createWithAccessToken($accessToken) {
                $auth = new StdClass;
                $auth->access_token = $accessToken;
                return new self(null, null, null, $auth);
	}

	public function __construct($clientID, $clientSecret, $redirectURI, $auth=null) {
		$this->clientID = $clientID;
		$this->clientSecret = $clientSecret;
		$this->redirectURI = $redirectURI;
		$this->auth = $auth;
	}

	public function get($path, $args=null, $headers=array()) {
		return $this->execute('GET', $path, $args, $headers);
	}

	public function post($path, $args=null, $headers=array()) {
		return $this->execute('POST', $path, $args, $headers);
	}

	public function execute($method, $path, $args=null, $headers=array()) {
		if($this->accessToken() !== null) {
			$headers[] = 'Authorization: OAuth '.$this->auth->access_token;
		}

		$response = $this->executeLowLevel($method, $path, $args, $headers);

		return json_decode($response);
	}

	/* This is abstracted from execute so you can get the raw return if you need to. */
	public function executeLowLevel($method, $path, $args=null, $headers=array()) {
		$ch = curl_init();
		$defaultHeaders = array('Accept: application/json',
		                        'Content-Type: application/json',
		                        'User-Agent: geoloqi-sdk-php '.self::VERSION);

		$headers = array_merge($defaultHeaders, $headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		if($method === 'POST') {
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, ($args ? json_encode($args) : ''));
		} else if ($method === 'GET') {
            if (is_array($args)
            &&  count($args) > 0) {
                $path .= '?' . http_build_query($args);
            }
        }

        curl_setopt($ch, CURLOPT_URL, self::API_URL.$path);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);
		return $response;
	}

  public function isLoggedIn() {
    return(isset($this->auth->access_token));
  }

	public function accessToken() {
	  if(isset($this->auth->access_token)) {
		  return $this->auth->access_token;
	  } else {
		  return null;
		}
	}

	public function login($args=array()) {
		$defaultArgs = array('response_type' => 'code',
												 'client_id'     => $this->clientID,
												 'redirect_uri'  => $this->redirectURI);

		$args = array_merge($defaultArgs, $args);

		$oauthUrl = self::OAUTH_URL.'?'.http_build_query($args);

		header('Location: '.$oauthUrl);
		exit;
	}

	public function establish($opts=array()) {
		return $this->post('oauth/token', $opts);
	}

	public function getAuthWithCode($code) {
		$auth = $this->establish(array('grant_type' => 'authorization_code',
		                               'client_id' => $this->clientID,
		                               'client_secret' => $this->clientSecret,
		                               'code' => $code,
		                               'redirect_uri' => $this->redirectURI));
		$this->auth = $auth;
		return $this->auth;
	}

	public function auth() {
		return $this->auth;
	}

	public function setAuth($auth) {
		$this->auth = $auth;
	}
	
	public function logout() {
	  $this->auth = null;
	}
}

?>