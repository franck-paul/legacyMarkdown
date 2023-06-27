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

class Frontend extends dcNsProcess
{
    protected static $init = false; /** @deprecated since 2.27 */
    public static function init(): bool
    {
        static::$init = My::checkContext(My::FRONTEND);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        // Add behavior callback for markdown convert of comments
        dcCore::app()->addBehavior('publicBeforeCommentTransform', [FrontendBehaviors::class, 'publicBeforeCommentTransform']);

        // tpl:CommentHelp alternative (will replace the standard template tag)
        dcCore::app()->tpl->addValue('CommentHelp', [FrontendTemplate::class, 'CommentHelp']);

        return true;
    }
}
