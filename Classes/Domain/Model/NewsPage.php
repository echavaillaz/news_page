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

namespace Hemmer\NewsPage\Domain\Model;

use GeorgRinger\News\Domain\Model\News;

class NewsPage extends News
{
    public const TYPE_INTERNAL = 1;

    protected int $backPage = 0;

    public function getBackPage(): int
    {
        return $this->backPage;
    }

    public function setBackPage(int $backPage): NewsPage
    {
        $this->backPage = $backPage;

        return $this;
    }
}
