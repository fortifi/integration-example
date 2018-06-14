<?php
namespace FortifiIntegration;

use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\GlobalElements\Panels\ContentPanel;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Text\HeadingOne;

class Handler implements \JsonSerializable
{
  protected $_base;

  public function __construct()
  {
    if(!isset($_GET['fortifiurl']))
    {
      throw new \Exception("Invalid Request");
    }
    $this->_base = urldecode($_GET['fortifiurl']);
  }

  public function jsonSerialize()
  {
    $additional = [];
    $additional['pageTitle'] = 'Page Title';

    return array_merge(
      $additional,
      [
        'appGroup'  => '',
        'markup'    => $this->getContent()->render(),
        'resources' =>
          [
            'css' => AssetManager::getUrisByType(AssetManager::TYPE_CSS),
            'js'  => AssetManager::getUrisByType(AssetManager::TYPE_JS),
          ],
      ]
    );
  }

  public function getContent()
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    return ContentPanel::create(
      [
        HeadingOne::create("Page #" . $page),
        "Content Panel",
        new PageletLink($this->_base . '?page=' . ($page + 1), 'Next Page ', '#integrate-section'),
      ]
    );
  }
}
