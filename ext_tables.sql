CREATE TABLE pages (
	news int(10) UNSIGNED NOT NULL DEFAULT 0
);

CREATE TABLE tx_news_domain_model_news (
	back_page int(10) UNSIGNED NOT NULL DEFAULT 0,
	page int(10) UNSIGNED NOT NULL DEFAULT 0,
	related_links int(10) UNSIGNED NOT NULL DEFAULT 0
);
