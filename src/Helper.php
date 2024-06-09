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

use Dotclear\Helper\Html\WikiToHtml;
use Michelf\MarkdownExtra;

class Helper
{
    public static function convert(string $str, string $type = 'full'): string
    {
        $engine = new MarkdownExtra();
        switch ($type) {
            case 'comment':
                // Setup some options in comments
                $engine->hashtag_protection = true;

                break;
            case 'full':
            default:
                break;
        }

        // Use microseconds to avoid collisions between the entry excerpt and
        // the entry content footnotes ID, as the entry excerpt and the entry content
        // are converted independently.
        $timeofday            = gettimeofday();
        $engine->fn_id_prefix = 'ts' . $timeofday['sec'] . $timeofday['usec'] . '.';

        return $engine->transform($str);
    }

    public static function coreInitWikiPost(WikiToHtml $wiki): string
    {
        $wiki->registerFunction('macro:md', self::convert(...));

        return '';
    }
}
