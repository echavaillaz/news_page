<?php

$EM_CONF['news_page'] = [
    'author' => 'Eric Chavaillaz',
    'author_email' => 'eric.chavaillaz@gmail.com',
    'category' => 'fe',
    'constraints' => [
        'depends' => [
            'news' => '8.5.0-8.99.99',
            'php' => '7.4.0-7.4.99',
            'typo3' => '10.4.0-10.4.99'
        ]
    ],
    'description' => 'Add a page type for the news.',
    'state' => 'stable',
    'title' => 'News Page',
    'version' => '10.4.0'
];
