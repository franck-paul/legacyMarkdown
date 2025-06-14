<?php

/**
 * @brief legacyMarkdown, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'Markdown syntax',
    'Brings you markdown syntax for your entries',
    'Michel Fortin, Franck Paul and contributors',
    '7.8.1',
    [
        'date'     => '2025-06-14T17:33:05+0200',
        'requires' => [
            ['core', '2.34'],
            ['TemplateHelper'],
        ],
        'permissions' => 'My',
        'type'        => 'plugin',
        'priority'    => 1005,  // Must be higher than dcLegacyEditor/dcCKEditor priority (ie 1000)
        'settings'    => [
            'pref' => '#user-options.user_options_edition',
            'blog' => '#params.legacy_markdown',
        ],
        'details'    => 'https://open-time.net/?q=legacyMarkdown',
        'support'    => 'https://github.com/franck-paul/legacyMarkdown',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/legacyMarkdown/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
