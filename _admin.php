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

dcCore::app()->addBehaviors([
    'adminBlogPreferencesFormV2'    => [dcMarkdownAdmin::class, 'adminBlogPreferencesForm'],
    'adminBeforeBlogSettingsUpdate' => [dcMarkdownAdmin::class, 'adminBeforeBlogSettingsUpdate'],

    'adminPostEditor'               => [dcMarkdownAdmin::class, 'adminPostEditor'],

    // Add behaviour callback for post/page lists
    'adminColumnsListsV2'           => [dcMarkdownAdmin::class, 'adminColumnsLists'],
    'adminPostListHeaderV2'         => [dcMarkdownAdmin::class, 'adminPostListHeader'],
    'adminPostListValueV2'          => [dcMarkdownAdmin::class, 'adminPostListValue'],
    'adminPagesListHeaderV2'        => [dcMarkdownAdmin::class, 'adminPagesListHeader'],
    'adminPagesListValueV2'         => [dcMarkdownAdmin::class, 'adminPagesListValue'],
]);

// Register REST methods
dcCore::app()->rest->addFunction('markdownConvert', [dcMarkdownRest::class, 'convert']);
