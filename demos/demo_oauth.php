<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  session_start();

  require('../Geoloqi.php');

  $geoloqi = new Geoloqi('YOUR APP CLIENT ID GOES HERE', 
                         'YOUR APP CLIENT SECRET GOES HERE', 
                         'YOUR APP REDIRECT URI GOES HERE');

  $name = 'geoloqi_auth';

  if(isset($_SESSION[$name])) {
    $geoloqi->setAuth($_SESSION[$name]);
  }

  $page = (isset($_GET['page']) ? $_GET['page'] : null);

  switch ($page) {
    case 'login':
      $geoloqi->login();
      break;
    case 'logout':
      $geoloqi->logout();
      unset($_SESSION[$name]);
      break;
  }

  if(isset($_GET['code'])) {
    $_SESSION[$name] = $geoloqi->getAuthWithCode($_GET['code']);
  }
?>
<html>
  <head>
    <title>Geoloqi PHP SDK OAuth Example</title>
  </head>
  <body>
    <?php
      if($geoloqi->isLoggedIn()) {
        
        echo 'You are logged in! Your account profile is:';
        echo '<pre>';
        
        $result = $geoloqi->get('account/profile');

        print_r($result);
        echo '</pre>';
        
        echo '<a href="demo_oauth.php?page=logout">Log Out</a>';
      } else {
        echo '<a href="demo_oauth.php?page=login">Log In</a>';
      }
    ?>
  </body>
</html>