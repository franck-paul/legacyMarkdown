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
use Dotclear\Helper\Html\Form\Img;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\None;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Td;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Form\Th;
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
     */
    public static function adminPostEditor(string $editor = '', string $context = '', array $tags = [], string $syntax = 'markdown'): string
    {
        if ($editor !== 'dcLegacyEditor' || $syntax !== 'markdown') {
            return '';
        }

        $data = [
            'style' => [  // List of classes used
                'class'  => true,
                'left'   => 'media-left',
                'center' => 'media-center',
                'right'  => 'media-right',
            ],
            'img_link_title' => __('Open the media'),
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
                'title'     => __('Strong emphasis'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_strong.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_strong-dark.svg')),
            ],
            'md_em' => [
                'title'     => __('Emphasis'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_em.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_em-dark.svg')),
            ],
            'md_ins' => [
                'title'     => __('Inserted'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_ins.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_ins-dark.svg')),
            ],
            'md_del' => [
                'title'     => __('Deleted'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_del.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_del-dark.svg')),
            ],

            'md_quote' => [
                'title'       => __('Inline quote'),
                'icon'        => urldecode(Page::getPF(My::id() . '/img/bt_quote.svg')),
                'icon_dark'   => urldecode(Page::getPF(My::id() . '/img/bt_quote-dark.svg')),
                'cite_prompt' => __('Source URL:'),
                'lang_prompt' => __('Language:'),
            ],

            'md_code' => [
                'title'     => __('Code'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_code.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_code-dark.svg')),
            ],
            'md_mark' => [
                'title'     => __('Mark'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_mark.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_mark-dark.svg')),
            ],

            'md_foreign' => [
                'title'       => __('Foreign text'),
                'icon'        => urldecode(Page::getPF(My::id() . '/img/bt_foreign.svg')),
                'icon_dark'   => urldecode(Page::getPF(My::id() . '/img/bt_foreign-dark.svg')),
                'lang_prompt' => __('Language:'),
            ],

            'md_br' => [
                'title'     => __('Linebreak '),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_br.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_br-dark.svg')),
            ],

            'md_blockquote' => [
                'title'     => __('Blockquote'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_bquote.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_bquote-dark.svg')),
            ],
            'md_pre' => [
                'title'     => __('Preformatedtext'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_pre.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_pre-dark.svg')),
            ],
            'md_ul' => [
                'title'     => __('Unorderedlist'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_ul.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_ul-dark.svg')),
            ],
            'md_ol' => [
                'title'     => __('Orderedlist'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_ol.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_ol-dark.svg')),
            ],

            'md_details' => [
                'title'        => __('Details block'),
                'icon'         => urldecode(Page::getPF(My::id() . '/img/bt_details.svg')),
                'icon_dark'    => urldecode(Page::getPF(My::id() . '/img/bt_details-dark.svg')),
                'title_prompt' => __('Summary:'),
            ],

            'md_aside' => [
                'title'     => __('Aside block'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_aside.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_aside-dark.svg')),
            ],

            'md_link' => [
                'title'     => __('Link'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_link.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_link-dark.svg')),
                'open_url'  => App::backend()->url()->get('admin.link.popup', ['popup' => 1, 'plugin_id' => 'dcLegacyEditor'], '&'),
            ],

            'md_img' => [
                'title'        => __('Externalimage'),
                'icon'         => urldecode(Page::getPF(My::id() . '/img/bt_img.svg')),
                'icon_dark'    => urldecode(Page::getPF(My::id() . '/img/bt_img-dark.svg')),
                'src_prompt'   => __('URL:'),
                'title_prompt' => __('Title (optional):'),
            ],

            'md_img_select' => [
                'title'     => __('Mediachooser'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_img_select.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_img_select-dark.svg')),
                'open_url'  => App::backend()->url()->get('admin.media', ['popup' => 1, 'plugin_id' => 'dcLegacyEditor'], '&'),
                'disabled'  => (!App::auth()->check(App::auth()->makePermissions([
                    App::auth()::PERMISSION_MEDIA,
                    App::auth()::PERMISSION_MEDIA_ADMIN,
                ]), App::blog()->id())),
            ],

            'md_post_link' => [
                'title'     => __('Linktoanentry'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_post.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_post-dark.svg')),
                'open_url'  => App::backend()->url()->get('admin.posts.popup', ['plugin_id' => 'dcLegacyEditor'], '&'),
            ],
            'md_footnote' => [
                'title'     => __('Footnote'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_footnote.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_footnote-dark.svg')),
            ],
            'md_preview' => [
                'title'     => __('Preview'),
                'icon'      => urldecode(Page::getPF(My::id() . '/img/bt_preview.svg')),
                'icon_dark' => urldecode(Page::getPF(My::id() . '/img/bt_preview-dark.svg')),
            ],
        ]) .
        My::cssLoad('jsToolBar.css') .
        My::jsLoad('post.js');
    }

    /**
     * @param      ArrayObject<string, mixed>  $cols   The cols
     */
    public static function adminColumnsLists(ArrayObject $cols): string
    {
        $cols['posts'][1]['format'] = [true, __('Format')];
        $cols['pages'][1]['format'] = [true, __('Format')];

        return '';
    }

    /**
     * @param      ArrayObject<string, string>    $cols   The cols
     */
    private static function adminEntryListHeader(ArrayObject $cols): string
    {
        $cols['format'] = (new Th())
            ->scope('col')
            ->text(__('Format'))
        ->render();

        return '';
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     */
    public static function adminPostListHeader(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListHeader($cols);
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     */
    public static function adminPagesListHeader(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListHeader($cols);
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     */
    private static function adminEntryListValue(MetaRecord $rs, ArrayObject $cols): string
    {
        $cols['format'] = (new Td())
            ->class('nowrap')
            ->items([
                self::getFormat($rs->post_format),
            ])
        ->render();

        return '';
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     */
    public static function adminPostListValue(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListValue($rs, $cols);
    }

    /**
     * @param      MetaRecord                     $rs     The recordset
     * @param      ArrayObject<string, string>    $cols   The cols
     */
    public static function adminPagesListValue(MetaRecord $rs, ArrayObject $cols): string
    {
        return self::adminEntryListValue($rs, $cols);
    }

    private static function getFormat(string $format = ''): Img|None
    {
        $images = [
            'markdown' => Page::getPF(My::id() . '/img/markdown.svg'),
            'xhtml'    => Page::getPF(My::id() . '/img/xhtml.svg'),
            'wiki'     => Page::getPF(My::id() . '/img/wiki.svg'),
        ];
        if (array_key_exists($format, $images)) {
            $syntax = App::formater()->getFormaterName($format);

            return (new Img($images[$format]))
                ->class(['mark', 'mark-generic'])
                ->alt($syntax)
                ->title($syntax);
        }

        return (new None());
    }
}
