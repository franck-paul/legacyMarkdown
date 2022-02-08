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
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

// dead but useful code, in order to have translations
__('Markdown syntax') . __('Brings you markdown (extra) syntax for your entries (see https://michelf.ca/projects/php-markdown/)');

$core->addFormater('markdown', ['dcMarkdown', 'convert']);

$core->addBehavior('adminBlogPreferencesForm', ['dcMarkdownAdmin', 'adminBlogPreferencesForm']);
$core->addBehavior('adminBeforeBlogSettingsUpdate', ['dcMarkdownAdmin', 'adminBeforeBlogSettingsUpdate']);

$core->addBehavior('adminPostEditor', ['dcMarkdownAdmin', 'adminPostEditor']);

// Add behaviour callback for post/page lists
$core->addBehavior('adminColumnsLists', ['dcMarkdownAdmin', 'adminColumnsLists']);
$core->addBehavior('adminPostListHeader', ['dcMarkdownAdmin', 'adminPostListHeader']);
$core->addBehavior('adminPostListValue', ['dcMarkdownAdmin', 'adminPostListValue']);
$core->addBehavior('adminPagesListHeader', ['dcMarkdownAdmin', 'adminPagesListHeader']);
$core->addBehavior('adminPagesListValue', ['dcMarkdownAdmin', 'adminPagesListValue']);
$core->addBehavior('adminFiltersLists', ['dcMarkdownAdmin', 'adminFiltersLists']);

// Register REST methods
$core->rest->addFunction('markdownConvert', ['dcMarkdownRest', 'convert']);
