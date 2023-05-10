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
declare(strict_types=1);

namespace Dotclear\Plugin\legacyMarkdown;

use dcCore;
use dcNsProcess;

class Backend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = My::checkContext(My::BACKEND);

        // dead but useful code, in order to have translations
        __('Markdown syntax') . __('Brings you markdown (extra) syntax for your entries (see https://michelf.ca/projects/php-markdown/)');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->addFormater('markdown', [Helper::class, 'convert']);
        dcCore::app()->addFormaterName('markdown', __('Markdown'));

        dcCore::app()->addBehaviors([
            'adminBlogPreferencesFormV2'    => [BackendBehaviors::class, 'adminBlogPreferencesForm'],
            'adminBeforeBlogSettingsUpdate' => [BackendBehaviors::class, 'adminBeforeBlogSettingsUpdate'],

            'adminPostEditor' => [BackendBehaviors::class, 'adminPostEditor'],

            // Add behaviour callback for post/page lists
            'adminColumnsListsV2'    => [BackendBehaviors::class, 'adminColumnsLists'],
            'adminPostListHeaderV2'  => [BackendBehaviors::class, 'adminPostListHeader'],
            'adminPostListValueV2'   => [BackendBehaviors::class, 'adminPostListValue'],
            'adminPagesListHeaderV2' => [BackendBehaviors::class, 'adminPagesListHeader'],
            'adminPagesListValueV2'  => [BackendBehaviors::class, 'adminPagesListValue'],
        ]);

        // Register REST methods
        dcCore::app()->rest->addFunction('markdownConvert', [BackendRest::class, 'convert']);

        return true;
    }
}
