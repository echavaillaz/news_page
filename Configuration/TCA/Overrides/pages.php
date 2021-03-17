<?php

use Pint\NewsPage\Domain\Model\NewsPage;
use Pint\NewsPage\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Domain\Repository\PageRepository as CorePageRepository;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') === true || die;

(static function () {
    ExtensionManagementUtility::addTcaSelectItem(
        'pages',
        'doktype',
        [
            'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news',
            PageRepository::DOKTYPE_NEWS,
            'apps-pagetree-page-news'
        ],
        (string)CorePageRepository::DOKTYPE_DEFAULT,
        'after'
    );

    ExtensionManagementUtility::addTCAcolumns(
        'pages',
        [
            'news' => [
                'config' => [
                    'allowed' => 'tx_news_domain_model_news',
                    'appearance' => [
                        'collapseAll' => false,
                        'enabledControls' => [
                            'delete' => false,
                            'hide' => false,
                            'info' => false
                        ]
                    ],
                    'default' => 0,
                    'foreign_field' => 'page',
                    'foreign_table' => 'tx_news_domain_model_news',
                    'maxitems' => 1,
                    'minitems' => 1,
                    'overrideChildTca' => [
                        'types' => [
                            NewsPage::TYPE_INTERNAL => [
                                'showitem' => '
                                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                                        istopnews,
                                        teaser,
                                        --palette--;;paletteDate,
                                        bodytext,
                                        back_page,
                                    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
                                        fal_media,
                                        fal_related_files,
                                    --div--;LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tabs.relations,
                                        related,
                                        related_from,
                                        related_links,
                                        tags,
                                    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
                                        --palette--;;paletteAuthor,
                                        --palette--;;metatags,
                                        --palette--;;alternativeTitles,
                                        --palette--;;sitemap,
                                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                                        --palette--;;paletteLanguage
                                '
                            ]
                        ]
                    ],
                    'type' => 'inline'
                ],
                'displayCond' => 'FIELD:news:REQ:true',
                'exclude' => true,
                'label' => 'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news'
            ]
        ]
    );

    ExtensionManagementUtility::registerPageTSConfigFile(
        'news_page',
        'Configuration/TsConfig/Page/Includes/news-page.tsconfig',
        'News Page'
    );

    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][PageRepository::DOKTYPE_NEWS] = 'apps-pagetree-page-news';

    unset(
        $GLOBALS['TCA']['pages']['palettes']['access']['label'],
        $GLOBALS['TCA']['pages']['palettes']['visibility']['label']
    );

    $GLOBALS['TCA']['pages']['types'][PageRepository::DOKTYPE_NEWS] = [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                doktype,
                title,
                slug,
            --div--;LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news,
                news,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
                backend_layout,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                --palette--;;visibility,
                --palette--;;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription
        '
    ];
})();
