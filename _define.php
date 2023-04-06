<?php
/**
 * @brief formatting-markdown, a plugin for Dotclear 2
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
    '2.0.1',
    [
        'requires'    => [['core', '2.26']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'type'     => 'plugin',
        'settings' => [
            'pref' => '#user-options.user_options_edition',
            'blog' => '#params.formatting_markdown',
        ],
        'details'    => 'https://open-time.net/?q=formatting-markdown',
        'support'    => 'https://github.com/franck-paul/formatting-markdown',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/formatting-markdown/master/dcstore.xml',
    ]
);
