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

if (!defined('DC_RC_PATH')) {return;}

$this->registerModule(
    "Markdown syntax",                                                                                           // Name
    "Brings you markdown (extra) syntax for your entries (see http://michelf.com/projects/php-markdown/extra/)", // Description
    "Michel Fortin, Franck Paul and contributors",                                                               // Author
    '1.7',                                                                                                       // Version
    array(
        'permissions' => 'usage,contentadmin',
        'type'        => 'plugin'
    )
);
