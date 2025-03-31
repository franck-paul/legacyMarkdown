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

class FrontendTemplateCode
{
    public static function CommentHelp(
    ): void {
        if (App::blog()->settings()->system->wiki_comments) {
            if (App::blog()->settings()->system->markdown_comments) {
                echo __('Comments can be formatted using the <a href="https://michelf.ca/projects/php-markdown/extra/">Markdown Extra</a> syntax.');
            } else {
                echo __('Comments can be formatted using a simple wiki syntax.');
            }
        } else {
            echo __('HTML code is displayed as text and web addresses are automatically converted.');
        }
    }
}
