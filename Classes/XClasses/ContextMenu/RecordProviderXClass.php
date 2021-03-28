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

namespace Pint\NewsPage\Hooks;

use TYPO3\CMS\Recordlist\RecordList\RecordListHookInterface;

class RecordProviderXClass extends RecordProvider
{
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

    protected function canBeEnabled(): bool
    {
        if ($this->isNewsPageRecord() === true) {
            return false;
        }

        return parent::canBeEnabled();
    }

    protected function isNewsPageRecord(): bool
    {
        return $this->table === 'tx_news_domain_model_news'
            && $this->pageRecord['doktype'] === PageRepository::DOKTYPE_NEWS
            && $this->record['page'] > 0;
    }
}
