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

dcCore::app()->addFormater('markdown', [dcMarkdown::class, 'convert']);
dcCore::app()->addFormaterName('markdown', __('Markdown'));

dcCore::app()->addBehavior('adminBlogPreferencesFormV2', [dcMarkdownAdmin::class, 'adminBlogPreferencesForm']);
dcCore::app()->addBehavior('adminBeforeBlogSettingsUpdate', [dcMarkdownAdmin::class, 'adminBeforeBlogSettingsUpdate']);

dcCore::app()->addBehavior('adminPostEditor', [dcMarkdownAdmin::class, 'adminPostEditor']);

// Add behaviour callback for post/page lists
dcCore::app()->addBehavior('adminColumnsListsV2', [dcMarkdownAdmin::class, 'adminColumnsLists']);
dcCore::app()->addBehavior('adminPostListHeaderV2', [dcMarkdownAdmin::class, 'adminPostListHeader']);
dcCore::app()->addBehavior('adminPostListValueV2', [dcMarkdownAdmin::class, 'adminPostListValue']);
dcCore::app()->addBehavior('adminPagesListHeaderV2', [dcMarkdownAdmin::class, 'adminPagesListHeader']);
dcCore::app()->addBehavior('adminPagesListValueV2', [dcMarkdownAdmin::class, 'adminPagesListValue']);

// Register REST methods
dcCore::app()->rest->addFunction('markdownConvert', [dcMarkdownRest::class, 'convert']);
