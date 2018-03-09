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

if (!defined('DC_RC_PATH')) {return;}

/* Add behavior callback for markdown convert of comments */
$core->addBehavior('publicBeforeCommentTransform', array('dcMarkdownPublic', 'publicBeforeCommentTransform'));

class dcMarkdownPublic
{
    public static function publicBeforeCommentTransform($content)
    {
        global $core;

        if ($core->blog->settings->system->markdown_comments) {
            return dcMarkdown::convert($content);
        }
        return '';
    }
}
