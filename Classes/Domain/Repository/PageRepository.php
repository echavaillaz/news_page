<?php

declare(strict_types=1);

namespace Pint\NewsPage\Domain\Repository;

class PageRepository extends AbstractRepository
{
    public const DOKTYPE_NEWS = 10;

    protected const TABLE = 'pages';
}
