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

class BackendRest
{
    /**
     * @param      array<string, string>  $get    The get
     * @param      array<string, string>  $post   The post
     *
     * @return     array<string, mixed>
     */
    public static function convert(array $get, array $post): array
    {
        $payload = [
            'ret' => false,
        ];

        $md = $post['md'] ?? '';
        if ($md !== '') {
            $html = Helper::convert($md);

            # --BEHAVIOR-- coreContentFilter -- string, array<int, array<int, string>> -- since 2.34
            App::behavior()->callBehavior('coreContentFilter', 'post', [
                [&$html, 'html'],
            ]);

            if (strlen($html) > 0) {
                $media_root = App::blog()->host();
                $html       = preg_replace_callback('/src="([^\"]*)"/', static function (array $matches) use ($media_root): string {
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
