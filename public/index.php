<?php
require dirname(__DIR__) . '/vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Page-URL, X-Pagelet-Refresh');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
  echo 'OK';
}
else
{
  \Fortifi\Ui\Ui::boot();
  try
  {
    $handler = new \FortifiIntegration\Handler();
    echo json_encode($handler);
  }
  catch(Exception $e)
  {
    http_response_code(500);
    echo $e->getMessage();
  }
}
