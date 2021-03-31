<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
            && $this->record['page'] > 0;
    }
}
