<?php
require dirname(__DIR__) . '/vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Headers: Content-Type, X-Page-URL, X-Pagelet-Refresh');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

if($request->isMethod('OPTIONS'))
{
  echo 'OK';
}
else
{
  try
  {
    $app = new \FortifiIntegration\Handler();

    //Create and configure a new dispatcher
    $dispatcher = new \Packaged\Dispatch\Dispatch($app, []);

    //Set the correct working directory for dispatcher
    $dispatcher->setBaseDirectory(dirname(__DIR__));

    $dispatcher->handle($request)->send();
  }
  catch(Exception $e)
  {
    http_response_code(500);
    echo $e->getMessage();
  }
}
