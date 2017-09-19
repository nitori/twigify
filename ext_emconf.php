<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Twigiy',
    'description' => 'Adds Twig templating engine to TYPO3.',
    'version' => '0.0.1',
    'state' => 'experimental',
    'author' => 'Lars Peter Søndergaard',
    'author_email' => 'lars.peter@sondergaard.de',
    'category' => 'fe',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    "autoload" => [
        "classmap" => [
            "Contrib/twig/lib/",
        ],
        "psr-4" => [
            "LFM\\Twigify\\" => "Classes/",
            "Twig\\" => "Contrib/twig/src/",
        ],
    ],
];
