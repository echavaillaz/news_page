<?php

declare(strict_types=1);

namespace Pint\NewsPage\Domain\Model;

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
