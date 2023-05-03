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

use Dotclear\Helper\Date;
use Michelf\MarkdownExtra;

class Helper
{
    public static function convert($str, $type = 'full')
    {
        $o = new MarkdownExtra();
        switch ($type) {
            case 'comment':
                // Setup some options in comments
                $o->hashtag_protection = true;

                break;
            case 'full':
            default:
                break;
        }
        // Setup generic options
        $o->fn_id_prefix = 'ts' . Date::str('%s') . '.';

        return $o->transform($str);
    }

    public static function coreInitWikiPost($wiki)
    {
        $wiki->registerFunction('macro:md', [self::class, 'convert']);
    }
}
