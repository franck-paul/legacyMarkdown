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
    '9.8',
    [
        'date'     => '2025-12-12T12:52:38+0100',
        'requires' => [
            ['core', '2.36'],
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
