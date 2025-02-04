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
    '5.5',
    [
        'date'        => '2003-08-13T13:42:00+0100',
        'requires'    => [['core', '2.30']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'settings'    => [
            'pref' => '#user-options.user_options_edition',
            'blog' => '#params.legacy_markdown',
        ],
        'details'    => 'https://open-time.net/?q=legacyMarkdown',
        'support'    => 'https://github.com/franck-paul/legacyMarkdown',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/legacyMarkdown/main/dcstore.xml',
    ]
);
