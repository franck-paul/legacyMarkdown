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

if (!defined('DC_CONTEXT_ADMIN')) {return;}

// dead but useful code, in order to have translations
__('Markdown syntax') . __('Brings you markdown (extra) syntax for your entries (see http://michelf.com/projects/php-markdown/extra/)');

$core->addFormater('markdown', ['dcMarkdown', 'convert']);

$core->addBehavior('adminBlogPreferencesForm', ['dcMarkdownAdmin', 'adminBlogPreferencesForm']);
$core->addBehavior('adminBeforeBlogSettingsUpdate', ['dcMarkdownAdmin', 'adminBeforeBlogSettingsUpdate']);

$core->addBehavior('adminPostEditor', ['dcMarkdownAdmin', 'adminPostEditor']);
