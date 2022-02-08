<?php
/**
 * @brief formatting-markdown, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

class dcMarkdownRest
{
    public static function convert($core, $get, $post)
    {
        $md  = $post['md'] ?? '';
        $rsp = new xmlTag('markdown');

        $ret  = false;
        $html = '';
        if ($md !== '') {
            $html = dcMarkdown::convert($md);
            $ret  = strlen($html) > 0;
        }

        $rsp->ret = $ret;
        $rsp->msg = $html;

        return $rsp;
    }
}
