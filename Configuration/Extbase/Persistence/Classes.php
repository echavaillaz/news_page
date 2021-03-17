<?php

declare(strict_types=1);

use Pint\NewsPage\Domain\Model\NewsPage;

return [
    NewsPage::class => [
        'recordType' => NewsPage::TYPE_INTERNAL,
        'tableName' => 'tx_news_domain_model_news'
    ]
];
