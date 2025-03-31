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

use Dotclear\Plugin\TemplateHelper\Code;

class FrontendTemplate
{
    public static function CommentHelp(): string
    {
        // Useful only for PO generation
        __('Comments can be formatted using the <a href="https://michelf.ca/projects/php-markdown/extra/">Markdown Extra</a> syntax.');
        __('Comments can be formatted using a simple wiki syntax.');
        __('HTML code is displayed as text and web addresses are automatically converted.');

        return Code::getPHPCode(
            FrontendTemplateCode::CommentHelp(...)
        );
    }
}
