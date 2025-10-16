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

use Dotclear\App;
use Dotclear\Helper\Process\TraitProcess;

class Backend
{
    use TraitProcess;

    public static function init(): bool
    {
        // dead but useful code, in order to have translations
        __('Markdown syntax');
        __('Brings you markdown (extra) syntax for your entries (see https://michelf.ca/projects/php-markdown/)');

        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::formater()->addEditorFormater('dcLegacyEditor', 'markdown', Helper::convert(...));
        App::formater()->addFormaterName('markdown', __('Markdown'));

        App::behavior()->addBehaviors([
            'adminBlogPreferencesFormV2'    => BackendBehaviors::adminBlogPreferencesForm(...),
            'adminBeforeBlogSettingsUpdate' => BackendBehaviors::adminBeforeBlogSettingsUpdate(...),

            'adminPostEditor'            => BackendBehaviors::adminPostEditor(...),
            'adminPostFormItems'         => BackendBehaviors::adminPostFormItems(...),
            'adminPageFormItems'         => BackendBehaviors::adminPageFormItems(...),
            'adminConvertBeforePostEdit' => BackendBehaviors::adminConvertBeforePostEdit(...),

            'adminPageHelpBlock' => BackendBehaviors::adminPageHelpBlock(...),

            // Add behaviour callback for post/page lists
            'adminColumnsListsV2'    => BackendBehaviors::adminColumnsLists(...),
            'adminPostListHeaderV2'  => BackendBehaviors::adminPostListHeader(...),
            'adminPostListValueV2'   => BackendBehaviors::adminPostListValue(...),
            'adminPagesListHeaderV2' => BackendBehaviors::adminPagesListHeader(...),
            'adminPagesListValueV2'  => BackendBehaviors::adminPagesListValue(...),
        ]);

        // Register REST methods
        App::rest()->addFunction('markdownConvert', BackendRest::convert(...));

        return true;
    }
}
