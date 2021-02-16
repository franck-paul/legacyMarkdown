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
if (!defined('DC_RC_PATH')) {
    return;
}

// Add behavior callback for markdown convert of comments
$core->addBehavior('publicBeforeCommentTransform', ['dcMarkdownPublic', 'publicBeforeCommentTransform']);

// tpl:CommentHelp alternative (will replace the standard template tag)
$core->tpl->addValue('CommentHelp', ['dcMarkdownPublic', 'CommentHelp']);

class dcMarkdownPublic
{
    public static function publicBeforeCommentTransform($content)
    {
        global $core;

        if ($core->blog->settings->system->markdown_comments) {
            return dcMarkdown::convert($content, 'comment');
        }

        return '';
    }

    public static function CommentHelp($attr, $content)
    {
        return
            "<?php if (\$core->blog->settings->system->wiki_comments) {\n" .
            "    if (\$core->blog->settings->system->markdown_comments) {\n" .
            "      echo __('Comments can be formatted using the <a href=\"https://michelf.ca/projects/php-markdown/extra/\">Markdown Extra</a> syntax.');\n" .
            "    } else {\n" .
            "      echo __('Comments can be formatted using a simple wiki syntax.');\n" .
            "    }\n" .
            "} else {\n" .
            "  echo __('HTML code is displayed as text and web addresses are automatically converted.');\n" .
            '} ?>';
    }
}
