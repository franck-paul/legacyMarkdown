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

            if ($ret) {
                // Cope with relative img src
                if (preg_match('/^http(s)?:\/\//', $core->blog->settings->system->public_url)) {
                    $media_root = $core->blog->settings->system->public_url;
                } else {
                    $media_root = $core->blog->host . path::clean($core->blog->settings->system->public_url) . '/';
                }
                $html = preg_replace_callback('/src="([^\"]*)"/', function ($matches) use ($media_root) {
                    if (!preg_match('/^http(s)?:\/\//', $matches[1])) {
                        // Relative URL, convert to absolute
                        return 'href="' . $media_root . $matches[1] . '"';
                    }
                    // Absolute URL, do nothing
                    return $matches[0];
                }, $html);
            }
        }

        $rsp->ret = $ret;
        $rsp->msg = $html;

        return $rsp;
    }
}
