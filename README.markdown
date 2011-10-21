Geoloqi PHP SDK
===
This is an interface library for the Geoloqi platform, written in PHP!

Requirements
---
* PHP 5.2.0 or later (for the embedded JSON)
* cURL bindings (should be compiled with PHP on most installations)

Usage
---
Getting started is really easy. All you need is an Access Token, which you can get from the [Geoloqi Developers Site](https://developers.geoloqi.com/getting-started):

    <?php

    include('Geoloqi.php');

    $geoloqi = Geoloqi::createWithAccessToken('YOUR ACCESS TOKEN GOES HERE');

    $response = $geoloqi->get('account/profile');

    echo("Response for GET account/profile:<br>");

    print_r($response);

    echo("<br><br>Response for POST account/profile:<br>");

    $response = $geoloqi->post('account/profile', array('website' => 'http://limpbizkit4lyfe.net'));

    print_r($response);

    ?>

For an OAuth2 application, go to the [Geoloqi Developers Site](https://developers.geoloqi.com/getting-started) and create an application! Then you can use it like this:



Found a bug?
---
Let us know! Send a pull request or a patch. Questions? Ask! We're here to help. File issues, we'll respond to them!

Authors
---
* Kyle Drake
* Aaron Parecki