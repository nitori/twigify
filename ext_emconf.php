<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Twigiy',
    'description' => 'Adds Twig templating engine to TYPO3.',
    'version' => '0.0.1',
    'state' => 'experimental',
    'author' => 'Lars Peter Søndergaard',
    'author_email' => 'lars.peter@sondergaard.de',
    'category' => 'fe',
    'constraints' => array(
        'depends' => array(
            'typo3' => '7.6.0-7.6.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
