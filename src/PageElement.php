<?php
namespace FortifiIntegration;

use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;

class PageElement extends UiElement
{
  protected $_nav;
  protected $_content;

  public static function make($nav = null, $content = null)
  {
    $page = static::i();
    $page->setNav($nav);
    $page->setContent($content);
    return $page;
  }

  /**
   * @return mixed
   */
  public function getNav()
  {
    return $this->_nav;
  }

  /**
   * @param mixed $nav
   *
   * @return PageElement
   */
  public function setNav($nav)
  {
    $this->_nav = $nav;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getContent()
  {
    return $this->_content;
  }

  /**
   * @param mixed $content
   *
   * @return PageElement
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

  protected function _produceHtml()
  {
    return Div::create(
      [
        Div::create($this->getNav())->addClass('col-xs-3'),
        Div::create($this->getContent())->addClass('col-xs-9'),
      ]
    )->addClass('row');
  }

}
