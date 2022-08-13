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
    public static function convert($get, $post)
    {
        $payload = [
            'ret' => false,
        ];

        $md = $post['md'] ?? '';
        if ($md !== '') {
            $html = dcMarkdown::convert($md);
            if (strlen($html) > 0) {
                $media_root = dcCore::app()->blog->host;
                $html       = preg_replace_callback('/src="([^\"]*)"/', function ($matches) use ($media_root) {
                    if (!preg_match('/^http(s)?:\/\//', $matches[1])) {
                        // Relative URL, convert to absolute
                        return 'src="' . $media_root . $matches[1] . '"';
                    }
                    // Absolute URL, do nothing
                    return $matches[0];
                }, $html);

                $payload = [
                    'ret'  => true,
                    'html' => $html,
                ];
            }
        }

        return $payload;
    }
}
