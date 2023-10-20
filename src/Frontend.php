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
use Dotclear\Core\Process;

class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        // Add behavior callback for markdown convert of comments
        App::behavior()->addBehavior('publicBeforeCommentTransform', FrontendBehaviors::publicBeforeCommentTransform(...));

        // tpl:CommentHelp alternative (will replace the standard template tag)
        App::frontend()->template()->addValue('CommentHelp', FrontendTemplate::CommentHelp(...));

        return true;
    }
}
