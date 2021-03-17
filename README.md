# News page

This extension adds a new page type to create advanced news via the page module.

## How it works

This extension register a new page type (*aka* `doktype`) to the core.
When you add a page with this doktype (arbitrarily `10`), a news is linked to the page record.
On every command, the common fields between the page and the news are synchronized.

---
The PageTS configuration `tx_news.predefined` is also respected.

---

### Fields mapping

Those fields are synchronized (page field -> news fields):

```
'categories' -> 'categories',
'editlock' -> 'editlock',
'endtime' -> 'endtime',
'fe_group' -> 'fe_group',
'hidden' -> 'hidden',
'rowDescription' -> 'notes',
'slug' -> 'path_segment',
'starttime' -> 'starttime',
'title' -> 'title',
'uid' -> 'page'
```

## Installation

Install this extension via `composer req pint/news-page` or download it from the [TYPO3 Extension Repository](https://extensions.typo3.org/extension/news_page/) and activate the extension in the Extension Manager of your TYPO3 installation.

## Configuration

1. Include the static TypoScript of the extension after `news`.
1. Add potentially a new defintion of the Fluid template like this:

```
page.10.templateName.cObject {
  pagets__news = TEXT
  pagets__news.value = News
}
```

1. Override potentially the template of the extension by extending your template definition:

```
[page['doktype'] == 10]
  page.10.templateRootPaths.20 = EXT:my_extension/Resources/Private/Templates/Page/
[end]
```

---
All the above exemples have to be adapted to your own configuration.

---
