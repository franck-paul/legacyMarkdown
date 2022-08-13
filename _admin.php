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

dcCore::app()->addFormater('markdown', ['dcMarkdown', 'convert']);

dcCore::app()->addBehavior('adminBlogPreferencesForm', ['dcMarkdownAdmin', 'adminBlogPreferencesForm']);
dcCore::app()->addBehavior('adminBeforeBlogSettingsUpdate', ['dcMarkdownAdmin', 'adminBeforeBlogSettingsUpdate']);

dcCore::app()->addBehavior('adminPostEditor', ['dcMarkdownAdmin', 'adminPostEditor']);

// Add behaviour callback for post/page lists
dcCore::app()->addBehavior('adminColumnsLists', ['dcMarkdownAdmin', 'adminColumnsLists']);
dcCore::app()->addBehavior('adminPostListHeader', ['dcMarkdownAdmin', 'adminPostListHeader']);
dcCore::app()->addBehavior('adminPostListValue', ['dcMarkdownAdmin', 'adminPostListValue']);
dcCore::app()->addBehavior('adminPagesListHeader', ['dcMarkdownAdmin', 'adminPagesListHeader']);
dcCore::app()->addBehavior('adminPagesListValue', ['dcMarkdownAdmin', 'adminPagesListValue']);
dcCore::app()->addBehavior('adminFiltersLists', ['dcMarkdownAdmin', 'adminFiltersLists']);

// Register REST methods
dcCore::app()->rest->addFunction('markdownConvert', ['dcMarkdownRest', 'convert']);
