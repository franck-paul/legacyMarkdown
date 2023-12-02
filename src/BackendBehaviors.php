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

use ArrayObject;
use Dotclear\App;
use Dotclear\Core\Backend\Page;
use Dotclear\Database\MetaRecord;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Interface\Core\BlogSettingsInterface;

class BackendBehaviors
{
    public static function adminBlogPreferencesForm(BlogSettingsInterface $settings): string
    {
        // Add fieldset for plugin options
        echo
        (new Fieldset('legacy_markdown'))
        ->legend((new Legend(__('Markdown'))))
        ->fields([
            (new Para())->items([
                (new Checkbox('markdown_comments', $settings->system->markdown_comments))
                    ->value(1)
                    ->label((new Label(__('Enable Markdown syntax for comments'), Label::INSIDE_TEXT_AFTER))),
            ]),
            (new Para())->class('clear form-note warn')->items([
                (new Text(null, __('This option, if enabled, will replace the standard wiki syntax for comments!'))),
            ]),
        ])
        ->render();

        return '';
    }

    public static function adminBeforeBlogSettingsUpdate(BlogSettingsInterface $settings): string
    {
        $settings->system->put('markdown_comments', !empty($_POST['markdown_comments']), 'boolean');

        return '';
    }

    /**
     * @param      string                   $editor   The editor
     * @param      string                   $context  The context
     * @param      array<string, string>    $tags     The tags
     * @param      string                   $syntax   The syntax
     *
     * @return     string
     */
    public static function adminPostEditor(string $editor = '', string $context = '', array $tags = [], string $syntax = 'markdown'): string
    {
        if ($editor != 'dcLegacyEditor' || $syntax != 'markdown') {
            return '';
        }

        $data['style'] = [  // List of classes used
            'class'  => true,
            'left'   => 'media-left',
            'center' => 'media-center',
            'right'  => 'media-right',
        ];

        return
        Page::jsJson('md_options', $data) .
        Page::jsJson('md_editor', [
            'md_blocks' => [
                'options' => [
                    'none'    => __('-- none --'),
                    'nonebis' => __('-- block format --'),
                    'p'       => __('Paragraph'),
                    'h1'      => __('Level 1 header'),
                    'h2'      => __('Level 2 header'),
                    'h3'      => __('Level 3 header'),
                    'h4'      => __('Level 4 header'),
                    'h5'      => __('Level 5 header'),
                    'h6'      => __('Level 6 header'),
                ],
            ],

            'md_strong' => [
                'title' => __('Strong emphasis'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_strong.svg')),
            ],
            'md_em' => [
                'title' => __('Emphasis'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_em.svg')),
            ],
            'md_ins' => [
                'title' => __('Inserted'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_ins.svg')),
            ],
            'md_del' => [
                'title' => __('Deleted'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_del.svg')),
            ],

            'md_quote' => [
                'title'       => __('Inline quote'),
                'icon'        => urldecode(Page::getPF(My::id() . '/img/bt_quote.svg')),
                'cite_prompt' => __('Source URL:'),
                'lang_prompt' => __('Language:'),
            ],

            'md_code' => [
                'title' => __('Code'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_code.svg')),
            ],
            'md_mark' => [
                'title' => __('Mark'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_mark.svg')),
            ],

            'md_foreign' => [
                'title'       => __('Foreign text'),
                'icon'        => urldecode(Page::getPF(My::id() . '/img/bt_foreign.svg')),
                'lang_prompt' => __('Language:'),
            ],

            'md_br' => [
                'title' => __('Linebreak '),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_br.svg')),
            ],

            'md_blockquote' => [
                'title' => __('Blockquote'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_bquote.svg')),
            ],
            'md_pre' => [
                'title' => __('Preformatedtext'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_pre.svg')),
            ],
            'md_ul' => [
                'title' => __('Unorderedlist'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_ul.svg')),
            ],
            'md_ol' => [
                'title' => __('Orderedlist'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_ol.svg')),
            ],

            'md_details' => [
                'title'        => __('Details block'),
                'icon'         => urldecode(Page::getPF(My::id() . '/img/bt_details.svg')),
                'title_prompt' => __('Summary:'),
            ],

            'md_aside' => [
                'title' => __('Aside block'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_aside.svg')),
            ],

            'md_link' => [
                'title'        => __('Link'),
                'icon'         => urldecode(Page::getPF(My::id() . '/img/bt_link.svg')),
                'href_prompt'  => __('URL:'),
                'title_prompt' => __('Title:'),
                'lang_prompt'  => __('Language:'),
            ],

            'md_img' => [
                'title'        => __('Externalimage'),
                'icon'         => urldecode(Page::getPF(My::id() . '/img/bt_img.svg')),
                'src_prompt'   => __('URL:'),
                'title_prompt' => __('Title:'),
            ],

            'md_img_select' => [
                'title'    => __('Mediachooser'),
                'icon'     => urldecode(Page::getPF(My::id() . '/img/bt_img_select.svg')),
                'open_url' => App::backend()->url()->get('admin.media', ['popup' => 1, 'plugin_id' => 'dcLegacyEditor'], '&'),
                'disabled' => (!App::auth()->check(App::auth()->makePermissions([
                    App::auth()::PERMISSION_MEDIA,
                    App::auth()::PERMISSION_MEDIA_ADMIN,
                ]), App::blog()->id())),
            ],

            'md_post_link' => [
                'title'    => __('Linktoanentry'),
                'icon'     => urldecode(Page::getPF(My::id() . '/img/bt_post.svg')),
                'open_url' => App::backend()->url()->get('admin.posts.popup', ['plugin_id' => 'dcLegacyEditor'], '&'),
            ],
            'md_footnote' => [
                'title' => __('Footnote'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_footnote.svg')),
            ],
            'md_preview' => [
                'title' => __('Preview'),
                'icon'  => urldecode(Page::getPF(My::id() . '/img/bt_preview.svg')),
            ],
        ]) .
        My::cssLoad('jsToolBar.css') .
        My::jsLoad('post.js');
    }

    /**
     * @param      ArrayObject<string, mixed>  $cols   The cols
     *
     * @return     string
     */
    public static function adminColumnsLists(ArrayObject $cols): string
    {
        $cols['posts'][1]['format'] = [true, __('Format')];
        $cols['pages'][1]['format'] = [true, __('Format')];

        return '';
    }

    /**
     * @param      ArrayObject<string, string>    $cols   The cols
     *
     * @return     string
     */
    private static function adminEntryListHeader(ArrayObject $cols): string
    {
        $cols['format'] = '<th scope="col">' . __('Format') . '</th>';

        return '';
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     *
     * @return     string
     */
    public static function adminPostListHeader(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListHeader($cols);
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     *
     * @return     string
     */
    public static function adminPagesListHeader(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListHeader($cols);
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     *
     * @return     string
     */
    private static function adminEntryListValue(MetaRecord $rs, ArrayObject $cols): string
    {
        $cols['format'] = '<td class="nowrap">' . self::getFormat($rs->post_format) . '</td>';

        return '';
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     *
     * @return     string
     */
    public static function adminPostListValue(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListValue($rs, $cols);
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     *
     * @return     string
     */
    public static function adminPagesListValue(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListValue($rs, $cols);
    }

    private static function getFormat(string $format = ''): string
    {
        $images = [
            'markdown' => Page::getPF(My::id() . '/img/markdown.svg'),
            'xhtml'    => Page::getPF(My::id() . '/img/xhtml.svg'),
            'wiki'     => Page::getPF(My::id() . '/img/wiki.svg'),
        ];
        if (array_key_exists($format, $images)) {
            return '<img style="width: 1.25em; height: 1.25em;" src="' . $images[$format] . '" title="' . App::formater()->getFormaterName($format) . '">';
        }

        return $format;
    }
}
