<?php
namespace FortifiIntegration;

use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\ContentElements\ObjectLists\ObjectList;
use Fortifi\Ui\ContentElements\ObjectLists\ObjectListCard;
use Fortifi\Ui\GlobalElements\Cards\Card;
use Fortifi\Ui\GlobalElements\Cards\Cards;
use Fortifi\Ui\GlobalElements\Panels\ContentPanel;
use Fortifi\Ui\GlobalElements\Panels\PanelHeader;

class Handler extends AbstractForifiHandler
{
  public function getNav()
  {
    $nav = ObjectList::i();
    $nav->addCard(
      ObjectListCard::i()->setTitle(
        new PageletLink($this->getBaseUrl() . 'customer', 'Customers', '#integrate-section')
      )
    );
    $nav->addCard(
      ObjectListCard::i()->setTitle(
        new PageletLink($this->getBaseUrl() . 'domain', 'Domains', '#integrate-section')
      )
    );
    return $nav;
  }

  /**
   * @return ContentPanel
   * @throws \Exception
   */
  public function getContent()
  {
    $page = $this->_getRequest()->get('page', 1);
    $pageType = trim($this->path(1), '/');

    $cards = Cards::i();
    $cardOne = Card::i();
    $cardOne->setTitle("This Card");
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
