<?php

/**
 * @brief legacyMarkdown, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\legacyMarkdown;

use Dotclear\App;
use Dotclear\Core\Content;

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
            # deprecated since 2.40 cope with coreContentFilterV2 instead
            App::behavior()->callBehavior('coreContentFilter', 'post', [
                [&$html, 'html'],
            ]);

            # --BEHAVIOR-- coreContentFilterV2 -- string, Content[] -- since 2.40
            $content = new Content('html', $html);
            App::behavior()->callBehavior(
                'coreContentFilterV2',
                'post',
                [
                    $content,
                ]
            );
            $html = $content->getContent();

            if ($html !== '') {
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
