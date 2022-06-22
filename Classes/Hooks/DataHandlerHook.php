<?php

declare(strict_types=1);

namespace Pint\NewsPage\Hooks;

use function implode;
use Pint\NewsPage\Domain\Model\NewsPage;
use Pint\NewsPage\Domain\Repository\ContentRepository;
use Pint\NewsPage\Domain\Repository\NewsRepository;
use Pint\NewsPage\Domain\Repository\PageRepository;
use Pint\NewsPage\Service\PrefillService;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\LinkHandling\LinkService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

class DataHandlerHook
{
    protected ?string $categories = '';
    protected ContentRepository $contentRepository;
    protected LinkService $linkService;
    protected static array $mappingPageToNews = [
        'editlock' => 'editlock',
        'endtime' => 'endtime',
        'fe_group' => 'fe_group',
        'hidden' => 'hidden',
        'rowDescription' => 'notes',
        'slug' => 'path_segment',
        'starttime' => 'starttime',
        'title' => 'title'
    ];
    protected NewsRepository $newsRepository;
    protected PageRepository $pageRepository;

    public function __construct(
        ContentRepository $contentRepository,
        LinkService $linkService,
        NewsRepository $newsRepository,
        PageRepository $pageRepository
    ) {
        $this->contentRepository = $contentRepository;
        $this->linkService = $linkService;
        $this->newsRepository = $newsRepository;
        $this->pageRepository = $pageRepository;
    }

    public function processCmdmap_postProcess(
        string $command,
        string $table,
        string $id,
        string $value,
        DataHandler $dataHandler
    ): void {
        switch ($table) {
            case 'pages':
                if ($command === 'copyToLanguage' || $command === 'localize') {
                    $pageId = (int)$id;
                    $page = $this->pageRepository->findOneById($pageId, 'doktype');

                    if ($page['doktype'] === PageRepository::DOKTYPE_NEWS) {
                        $dataHandler->localize(
                            'tx_news_domain_model_news',
                            $this->newsRepository->findOneByPageId($pageId),
                            $value
                        );
                    }
                }
                break;
            case 'tt_content':
                if ($command === 'copy' || $command === 'move') {
                    $this->processContentElement(
                        $this->contentRepository->findOneById((int)$id, 'pid,tx_news_related_news,uid')
                    );
                }
                break;
        }
    }

    public function processDatamap_afterDatabaseOperations(
        string $status,
        string $table,
        string $id,
        array $fields,
        DataHandler $dataHandler
    ): void {
        switch ($table) {
            case 'pages':
                switch ($status) {
                    case 'new':
                        if (
                            (int)$fields['doktype'] === PageRepository::DOKTYPE_NEWS
                            && $fields['sys_language_uid'] === 0
                        ) {
                            $newsId = StringUtility::getUniqueId('NEW');
                            $pageId = (string)$dataHandler->substNEWwithIDs[$id];
                            $prefillService = GeneralUtility::makeInstance(PrefillService::class, $pageId);

                            $news = $this->mapData($fields);
                            $news['archive'] = $prefillService->getArchive();
                            $news['author'] = $prefillService->getAuthor();
                            $news['author_email'] = $prefillService->getAuthorEmail();
                            $news['categories'] = $this->categories;
                            $news['datetime'] = $prefillService->getDatetime();
                            $news['internalurl'] = $this->getInternalUrl($pageId);
                            $news['page'] = $pageId;
                            $news['pid'] = $pageId;
                            $news['type'] = NewsPage::TYPE_INTERNAL;

                            $this->processDatamap([
                                'pages' => [
                                    $pageId => [
                                        'news' => $newsId
                                    ]
                                ],
                                'tx_news_domain_model_news' => [
                                    $newsId => $news
                                ]
                            ]);
                        }
                        break;
                    case 'update':
                        $page = $this->pageRepository->findOneById((int)$id, 'doktype,uid');

                        if ($page['doktype'] === PageRepository::DOKTYPE_NEWS) {
                            $newsId = $this->newsRepository->findOneByPageId($page['uid']);

                            $news = $this->mapData($fields);
                            $news['categories'] = $this->categories;

                            $this->processDatamap([
                                'tx_news_domain_model_news' => [
                                    $newsId => $news
                                ]
                            ]);
                        }
                        break;
                }
                break;
            case 'tt_content':
                $this->processContentElement(
                    $this->contentRepository->findOneById(
                        $status === 'new' ? (int)$dataHandler->substNEWwithIDs[$id] : (int)$id,
                        'pid,tx_news_related_news,uid'
                    )
                );
                break;
        }
    }

    public function processDatamap_preProcessFieldArray(array $fields, string $table): void
    {
        if ((int)$fields['doktype'] === PageRepository::DOKTYPE_NEWS && $table === 'pages') {
            $this->categories = $fields['categories'];
        }
    }

    protected function getInternalUrl(string $linkParameter): string
    {
        return $this->linkService->asString($this->linkService->resolve($linkParameter));
    }

    protected function getPageId(array $page): int
    {
        return $page['sys_language_uid'] === 0 ? $page['uid'] : $page['l10n_parent'];
    }

    protected function mapData(array $fields): array
    {
        $data = [];

        foreach (self::$mappingPageToNews as $pageField => $newsField) {
            if ($fields[$pageField] !== null) {
                $data[$newsField] = $fields[$pageField];
            }
        }

        return $data;
    }

    protected function processContentElement(array $contentElement): void
    {
        $page = $this->pageRepository->findOneById($contentElement['pid'], 'doktype');

        if ($page['doktype'] === PageRepository::DOKTYPE_NEWS) {
            $this->processDatamap([
                'tx_news_domain_model_news' => [
                    $this->newsRepository->findOneByPageId($contentElement['pid']) => [
                        'content_elements' => implode(
                            ',',
                            $this->contentRepository->findAllByPageId($contentElement['pid'])
                        )
                    ]
                ]
            ]);
        } elseif ($contentElement['tx_news_related_news'] > 0) {
            $news = $this->newsRepository->findOneById($contentElement['tx_news_related_news'], 'pid,uid');

            $this->processDatamap([
                'tt_content' => [
                    $contentElement['uid'] => [
                        'tx_news_related_news' => 0
                    ]
                ],
                'tx_news_domain_model_news' => [
                    $news['uid'] => [
                        'content_elements'  => implode(
                            ',',
                            $this->contentRepository->findAllByPageId($news['pid'])
                        )
                    ]
                ]
            ]);
        }
    }

    protected function processDatamap(array $data): void
    {
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($data, []);
        $dataHandler->process_datamap();
    }
}
