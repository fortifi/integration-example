<?php
namespace FortifiIntegration;

use Fortifi\Ui\Ui;
use Packaged\Dispatch\AssetManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

abstract class AbstractForifiHandler implements HttpKernelInterface
{
  private $_base;
  private $_request;

  public function __construct()
  {
    Ui::boot(null, false, false, false);
  }

  public function getBaseUrl()
  {
    return $this->_base;
  }

  /**
   * @return Request
   */
  protected function _getRequest()
  {
    return $this->_request;
  }

  abstract public function getNav();

  abstract public function getContent();

  public function path($depth = null)
  {
    if($depth !== null)
    {
      $depth++;
      $parts = explode("/", $this->_getRequest()->getPathInfo(), $depth + 1);
      if(count($parts) > $depth)
      {
        array_pop($parts);
        return implode('/', $parts);
      }
    }
    return $this->_getRequest()->getPathInfo();
  }

  public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
  {
    $this->_request = $request;
    if(!$request->query->has('fortifiurl'))
    {
      throw new \Exception("Invalid Request");
    }
    $this->_base = urldecode($request->query->get('fortifiurl'));

    $additional = [];
    $additional['pageTitle'] = 'Page Title';

    $content = PageElement::make($this->getNav(), $this->getContent())->render();
    if($request->query->has('_asHtml'))
    {
      return Response::create($content);
    }

    return JsonResponse::create(
      array_merge(
        $additional,
        [
          'markup'    => $content,
          'resources' =>
            [
              'css' => AssetManager::getUrisByType(AssetManager::TYPE_CSS),
              'js'  => AssetManager::getUrisByType(AssetManager::TYPE_JS),
            ],
        ]
      )
    );
  }
}
