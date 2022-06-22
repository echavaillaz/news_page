<?php

declare(strict_types=1);

namespace Pint\NewsPage\XClass\ContextMenu;

use Pint\NewsPage\Domain\Repository\PageRepository;
use TYPO3\CMS\Backend\ContextMenu\ItemProviders\RecordProvider;

class RecordProviderXClass extends RecordProvider
{
    protected function canBeCopied(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeCopied();
    }

    protected function canBeCut(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeCut();
    }

    protected function canBeDeleted(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeDeleted();
    }

    protected function canBeDisabled(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeDisabled();
    }

    protected function canBeEdited(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeEdited();
    }

    protected function canBeEnabled(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeEnabled();
    }

    protected function canBeNew(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeNew();
    }

    protected function canBePastedAfter(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBePastedAfter();
    }

    protected function isNewsPageRecord(): bool
    {
        return $this->table === 'tx_news_domain_model_news'
            && $this->pageRecord['doktype'] === PageRepository::DOKTYPE_NEWS
            && $this->pageRecord['news'] > 0;
    }
}
