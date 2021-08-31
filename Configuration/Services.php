<?php

declare(strict_types=1);

use Pint\NewsPage\DataProcessing\NewsPageProcessor;
use Pint\NewsPage\Hooks\DatabaseRecordListHook;
use Pint\NewsPage\Hooks\DataHandlerHook;
use Pint\NewsPage\Hooks\DrawHeaderHook;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use TYPO3\CMS\Core\DependencyInjection\PublicServicePass;

return static function (ContainerConfigurator $_, ContainerBuilder $containerBuilder) {
    $containerBuilder->addCompilerPass(new PublicServicePass('news_page.public'));
    $containerBuilder->registerForAutoconfiguration(DatabaseRecordListHook::class)->addTag('news_page.public');
    $containerBuilder->registerForAutoconfiguration(DataHandlerHook::class)->addTag('news_page.public');
    $containerBuilder->registerForAutoconfiguration(DrawHeaderHook::class)->addTag('news_page.public');
    $containerBuilder->registerForAutoconfiguration(NewsPageProcessor::class)->addTag('news_page.public');
};
