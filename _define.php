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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'Markdown syntax',                             // Name
    'Brings you markdown syntax for your entries', // Description
    'Michel Fortin, Franck Paul and contributors', // Author
    '1.19',
    [
        'requires'    => [['core', '2.22']],
        'permissions' => 'usage,contentadmin',
        'type'        => 'plugin',
        'settings'    => [
            'pref' => '#user-options.user_options_edition',
            'blog' => '#params.formatting_markdown',
        ],
        'details'    => 'https://open-time.net/?q=formatting-markdown',       // Details URL
        'support'    => 'https://github.com/franck-paul/formatting-markdown', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/formatting-markdown/master/dcstore.xml',
    ]
);
