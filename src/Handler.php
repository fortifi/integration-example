<?php
namespace FortifiIntegration;

use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\GlobalElements\Cards\Card;
use Fortifi\Ui\GlobalElements\Cards\Cards;
use Fortifi\Ui\GlobalElements\Panels\ContentPanel;
use Fortifi\Ui\GlobalElements\Panels\PanelHeader;
use Fortifi\Ui\PageElements\PageNavigation\PageNavigation;

class Handler extends AbstractForifiHandler
{
  public function getNav()
  {
    $nav = PageNavigation::create($this->getBaseUrl());
    $nav->addItem(new PageletLink($this->getBaseUrl() . 'customer', 'Customers', '#integrate-section'));
    $nav->addItem(new PageletLink($this->getBaseUrl() . 'domain', 'Domains', '#integrate-section'));
    return $nav;
  }

  /**
   * @throws \Exception
   */
  public function getContent()
  {
    $page = $this->_getRequest()->get('page', 1);
    $pageType = trim($this->path(1), '/');

    $cards = Cards::i();
    $cardOne = Card::i();
    $cardOne->setTitle("This is an integration page card");
    $cardOne->setLabel("Page Details");
    $cardOne->setColour(Card::COLOUR_INDIGO);
    $cardOne->addProperty("Page Type", $pageType);
    $cardOne->addProperty("Page #", $page);
    $cards->addCard($cardOne);

    $panel = ContentPanel::create(
      [
        "Page Navigation: ",
        new PageletLink(
          $this->getBaseUrl() . $pageType . '?page=' . ($page - 1), 'Previous Page ', '#integrate-section'
        ),
        ' | ',
        new PageletLink($this->getBaseUrl() . $pageType . '?page=' . ($page), 'Reload Page ', '#integrate-section'),
        ' | ',
        new PageletLink($this->getBaseUrl() . $pageType . '?page=' . ($page + 1), 'Next Page ', '#integrate-section'),
      ]
    );
    $panel->setHeader(PanelHeader::create(trim(ucwords($pageType) . " Page #" . $page)));
    return [$panel, $cards];
  }
}
