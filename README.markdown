Geoloqi PHP SDK
===
This is an interface library for the Geoloqi platform, written in PHP!

Requirements
---
* PHP 5.2.0 or later (for the embedded JSON)
* cURL bindings (should be compiled with PHP on most installations)

Usage
---
Getting started is really easy. All you need is an application access token, which you can get from the [Geoloqi Developers Site](https://developers.geoloqi.com/account/applications):

    <?php

    include('Geoloqi.php');

    $geoloqi = Geoloqi::createWithAccessToken('YOUR_APPLICATION_ACCESS_TOKEN');

    $response = $geoloqi->post('trigger/create', array(
      'key'        => 'powells_books',
      'type'       => 'message',
      'latitude'   => 45.523334,
      'longitude'  => -122.681612,
      'radius'     => 150,
      'text'       => 'Welcome to Powell\'s Books!',
      'place_name' => 'Powell\'s Books'
    ));

    echo("Response for POST trigger/create:<br>");

    print_r($response);

    ?>

Found a bug?
---
Let us know! Send a pull request or a patch. Questions? Ask! We're here to help. File issues, we'll respond to them!

Authors
---
* Kyle Drake
* Aaron Parecki