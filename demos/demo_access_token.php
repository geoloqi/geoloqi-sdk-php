<html>
  <head>
    <title>Geoloqi PHP SDK Access Token Example</title>
  </head>
  <body>
    <pre><?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        require('../Geoloqi.php');

        $geoloqi = Geoloqi::createWithAccessToken('YOUR ACCESS TOKEN GOES HERE');

        $response = $geoloqi->get('account/profile');

        echo("Response for GET account/profile:\n\n");

        print_r($response);

        echo("\nResponse for POST account/profile:\n\n");

        $response = $geoloqi->post('account/profile', array('website' => 'http://example.org/my_cool_site'));
        print_r($response);
      ?>
    </pre>
  </body>
</html>