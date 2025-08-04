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
use League\HTMLToMarkdown\HtmlConverter;
use Michelf\MarkdownExtra;

class Helper
{
    /**
     * Convert Markdown text into HTML
     *
     * @param      string  $str    The Markdown text to convert
     * @param      string  $type   The type (full/comment)
     *
     * @return     string  The HTML text
     */
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

        // Set backlink title
        $engine->fn_backlink_title = __('Back to content %%');

        $ret = $engine->transform($str);

        if ($type === 'comment') {
            // For comments remove all interactive content as far as possible
            $ret = self::stripInteractiveTags($ret);
        }

        return $ret;
    }

    /**
     * Register macro:md for Wiki syntax
     */
    public static function coreInitWikiPost(WikiToHtml $wiki): string
    {
        $wiki->registerFunction('macro:md', self::convert(...));

        return '';
    }

    /**
     * Convert Markdown (original syntax from J. Gruber) to HTML
     *
     * @param      string  $str    The HTML tex to convert
     *
     * @return     string  The Markdown text
     */
    public static function fromHTML(string $str): string
    {
        $config = [
            'header_style' => 'atx',    // Force ATX style for header (even for h1 and h2)
        ];

        $converter = new HtmlConverter($config);

        return $converter->convert($str);
    }

    protected static function stripInteractiveTags(string $str): string
    {
        // Non interactive HTML tags
        $allowed_tags = [
            // A
            'a',
            'abbr',
            'acronym',
            'address',
            // 'applet',
            'area',
            'article',
            'aside',
            'audio',

            // B
            'b',
            'base',
            'basefont',
            'bdi',
            'bdo',
            'big',
            'blockquote',
            'body',
            'br',
            // 'button',

            // C
            // 'canvas',
            'caption',
            'center',
            'cite',
            'code',
            'col',
            'colgroup',

            // D
            'data',
            'datalist',
            'dd',
            'del',
            'details',
            'dfn',
            // 'dialog',
            'dir',
            'div',
            'dl',
            'dt',

            // E
            'em',
            // 'embed',

            // F
            'fieldset',
            'figcaption',
            'figure',
            'font',
            'footer',
            // 'form',
            // 'frame',
            // 'frameset',

            // G

            // H
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'head',
            'hr',
            // 'html',

            // I
            'i',
            // 'iframe',
            'img',
            // 'input',
            'ins',
            'isindex',

            // J

            // K
            'kbd',
            'keygen',

            // L
            'label',
            'legend',
            'li',
            'link',

            // M
            'main',
            'map',
            'mark',
            'menu',
            'menuitem',
            'meta',
            'meter',

            // N
            'nav',
            'noframes',
            'noscript',

            // O
            // 'object',
            'ol',
            'optgroup',
            'option',
            'output',

            // P
            'p',
            'param',
            'picture',
            'pre',
            'progress',

            // Q
            'q',

            // R
            'rp',
            'rt',
            'rtc',
            'ruby',

            // S
            's',
            'samp',
            // 'script',
            'section',
            // 'select',
            'small',
            'source',
            'span',
            'strike',
            'strong',
            'style',
            'sub',
            'summary',
            'sup',

            // T
            'table',
            'tbody',
            'td',
            'template',
            // 'textarea',
            'tfoot',
            'th',
            'thead',
            'time',
            'title',
            'tr',
            'track',
            'tt',

            // U
            'u',
            'ul',

            // V
            'var',
            'video',

            // W
            'wbr',

            // X

            // Y

            // Z
        ];

        // Interactive HTML attributes
        $interactive_attributes = [
            'onabort',
            'onafterprint',
            'onautocomplete',
            'onautocompleteerror',
            'onbeforeprint',
            'onbeforeunload',
            'onblur',
            'oncancel',
            'oncanplay',
            'oncanplaythrough',
            'onchange',
            'onclick',
            'onclose',
            'oncontextmenu',
            'oncuechange',
            'ondblclick',
            'ondrag',
            'ondragend',
            'ondragenter',
            'ondragexit',
            'ondragleave',
            'ondragover',
            'ondragstart',
            'ondrop',
            'ondurationchange',
            'onemptied',
            'onended',
            'onerror',
            'onfocus',
            'onhashchange',
            'oninput',
            'oninvalid',
            'onkeydown',
            'onkeypress',
            'onkeyup',
            'onlanguagechange',
            'onload',
            'onloadeddata',
            'onloadedmetadata',
            'onloadstart',
            'onmessage',
            'onmousedown',
            'onmouseenter',
            'onmouseleave',
            'onmousemove',
            'onmouseout',
            'onmouseover',
            'onmouseup',
            'onmousewheel',
            'onoffline',
            'ononline',
            'onpause',
            'onplay',
            'onplaying',
            'onpopstate',
            'onprogress',
            'onratechange',
            'onredo',
            'onreset',
            'onresize',
            'onscroll',
            'onseeked',
            'onseeking',
            'onselect',
            'onshow',
            'onsort',
            'onstalled',
            'onstorage',
            'onsubmit',
            'onsuspend',
            'ontimeupdate',
            'ontoggle',
            'onundo',
            'onunload',
            'onvolumechange',
            'onwaiting',
        ];

        // 1. Remove non allowed HTML tags
        $str = strip_tags($str, $allowed_tags);

        // 2. Dirty remove javascript event attributes
        $list = implode('|', $interactive_attributes);

        return (string) preg_replace('/(' . $list . ')\s*=\s*".*?"/is', '', $str);
    }
}
