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
class dcMarkdownPublic
{
    public static function publicBeforeCommentTransform($content)
    {
        if (dcCore::app()->blog->settings->system->markdown_comments) {
            return dcMarkdown::convert($content, 'comment');
        }

        return '';
    }

    public static function CommentHelp()
    {
        // Useful only for PO generation
        __('Comments can be formatted using the <a href="https://michelf.ca/projects/php-markdown/extra/">Markdown Extra</a> syntax.');
        __('Comments can be formatted using a simple wiki syntax.');
        __('HTML code is displayed as text and web addresses are automatically converted.');

        return
            "<?php if (dcCore::app()->blog->settings->system->wiki_comments) {\n" .
            "    if (dcCore::app()->blog->settings->system->markdown_comments) {\n" .
            "      echo __('Comments can be formatted using the <a href=\"https://michelf.ca/projects/php-markdown/extra/\">Markdown Extra</a> syntax.');\n" .
            "    } else {\n" .
            "      echo __('Comments can be formatted using a simple wiki syntax.');\n" .
            "    }\n" .
            "} else {\n" .
            "  echo __('HTML code is displayed as text and web addresses are automatically converted.');\n" .
            '} ?>';
    }
}

// Add behavior callback for markdown convert of comments
dcCore::app()->addBehavior('publicBeforeCommentTransform', [dcMarkdownPublic::class, 'publicBeforeCommentTransform']);

// tpl:CommentHelp alternative (will replace the standard template tag)
dcCore::app()->tpl->addValue('CommentHelp', [dcMarkdownPublic::class, 'CommentHelp']);
