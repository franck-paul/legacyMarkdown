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

class FrontendBehaviors
{
    public static function publicBeforeCommentTransform(string $content): string
    {
        if (App::blog()->settings()->system->markdown_comments) {
            return Helper::convert($content, 'comment');
        }

        return '';
    }
}
