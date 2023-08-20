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
use Dotclear\Core\Process;

class Backend extends Process
{
    public static function init(): bool
    {
        // dead but useful code, in order to have translations
        __('Markdown syntax') . __('Brings you markdown (extra) syntax for your entries (see https://michelf.ca/projects/php-markdown/)');

        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        dcCore::app()->addFormater('markdown', Helper::convert(...));
        dcCore::app()->addFormaterName('markdown', __('Markdown'));

        dcCore::app()->addBehaviors([
            'adminBlogPreferencesFormV2'    => BackendBehaviors::adminBlogPreferencesForm(...),
            'adminBeforeBlogSettingsUpdate' => BackendBehaviors::adminBeforeBlogSettingsUpdate(...),

            'adminPostEditor' => BackendBehaviors::adminPostEditor(...),

            // Add behaviour callback for post/page lists
            'adminColumnsListsV2'    => BackendBehaviors::adminColumnsLists(...),
            'adminPostListHeaderV2'  => BackendBehaviors::adminPostListHeader(...),
            'adminPostListValueV2'   => BackendBehaviors::adminPostListValue(...),
            'adminPagesListHeaderV2' => BackendBehaviors::adminPagesListHeader(...),
            'adminPagesListValueV2'  => BackendBehaviors::adminPagesListValue(...),
        ]);

        // Register REST methods
        dcCore::app()->rest->addFunction('markdownConvert', BackendRest::convert(...));

        return true;
    }
}
