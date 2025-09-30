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
use Dotclear\Database\MetaRecord;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Div;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Img;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Link;
use Dotclear\Helper\Html\Form\None;
use Dotclear\Helper\Html\Form\Option;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Select;
use Dotclear\Helper\Html\Form\Td;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Form\Th;
use Dotclear\Helper\Html\Form\Url;
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
     * @param      ArrayObject<string, mixed>   $main     The main
     * @param      ArrayObject<string, mixed>   $sidebar  The sidebar
     * @param      MetaRecord|null              $post     The post
     * @param      string                       $url      The entry edit URL
     */
    protected static function adminEntryFormItems(ArrayObject $main, ArrayObject $sidebar, ?MetaRecord $post, string $url): string
    {
        if ($post instanceof MetaRecord) {
            $convert = (new Div())
                ->class(['format_control', 'control_no_markdown', 'control_no_wiki'])
                ->items([
                    (new Link('convert-markdown'))
                        ->class(['button', App::backend()->post_id && App::backend()->post_format !== 'xhtml' ? ' hide' : ''])
                        ->href($url)
                        ->text(__('Convert to Markdown')),
                ])
            ->render();

            $sidebar['status-box']['items']['post_format'] .= $convert;
        }

        return '';
    }

    /**
     * @param      ArrayObject<string, mixed>   $main     The main
     * @param      ArrayObject<string, mixed>   $sidebar  The sidebar
     * @param      MetaRecord|null              $post     The post
     */
    public static function adminPostFormItems(ArrayObject $main, ArrayObject $sidebar, ?MetaRecord $post): string
    {
        if ($post instanceof MetaRecord) {
            $url = App::backend()->url()->get(
                'admin.post',
                [
                    'id'             => App::backend()->post_id,
                    'convert'        => '1',
                    'convert-format' => 'markdown',
                ]
            );
            self::adminEntryFormItems($main, $sidebar, $post, $url);
        }

        return '';
    }

    /**
     * @param      ArrayObject<string, mixed>   $main     The main
     * @param      ArrayObject<string, mixed>   $sidebar  The sidebar
     * @param      MetaRecord|null              $post     The post
     */
    public static function adminPageFormItems(ArrayObject $main, ArrayObject $sidebar, ?MetaRecord $post): string
    {
        if ($post instanceof MetaRecord) {
            $url = App::backend()->url()->get(
                'admin.plugin.pages',
                [
                    'act'            => 'page',
                    'id'             => App::backend()->post_id,
                    'convert'        => '1',
                    'convert-format' => 'markdown',
                ]
            );
            self::adminEntryFormItems($main, $sidebar, $post, $url);
        }

        return '';
    }

    /**
     * @param      ArrayObject<string, mixed>   $params  The parameters (excerpt, content, format)
     */
    public static function adminConvertBeforePostEdit(string $convert, ArrayObject $params): string
    {
        if ($convert === 'markdown') {
            $params['excerpt'] = Helper::fromHTML($params['excerpt']);
            $params['content'] = Helper::fromHTML($params['content']);
            $params['format']  = 'markdown';

            return __('Don\'t forget to validate your Markdown conversion by saving your post.');
        }

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

        $language_options = [];
        $language_codes   = App::lang()->getISOcodes(true, true);
        foreach ($language_codes as $language_name => $language_code) {
            $language_options[] = (new Option($language_name, $language_code))->lang($language_code);
        }

        $language_select = (new Select('language'))
            ->items($language_options)
            ->translate(false)
            ->label(new Label(__('Language:'), Label::OL_TF))
        ->render();

        // Add an empty choice
        array_unshift($language_options, (new Option('', '')));

        $citeurl_input = (new Url('cite_url'))
            ->size(35)
            ->maxlength(512)
            ->autocomplete('url')
            ->translate(false)
            ->label((new Label(__('URL:'), Label::OL_TF)))
        ->render();

        $citelang_select = (new Select('cite_language'))
            ->items($language_options)
            ->translate(false)
            ->label(new Label(__('Language:'), Label::OL_TF))
        ->render();

        $data = [
            'style' => [  // List of classes used
                'class'  => true,
                'left'   => 'media-left',
                'center' => 'media-center',
                'right'  => 'media-right',
            ],
            'img_link_title' => __('Open the media'),
            'dialog'         => [
                'ok'     => __('Ok'),
                'cancel' => __('Cancel'),
            ],
        ];

        return
        App::backend()->page()->jsJson('md_options', $data) .
        App::backend()->page()->jsJson('md_editor', [
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
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_strong.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_strong-dark.svg')),
            ],
            'md_em' => [
                'title'     => __('Emphasis'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_em.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_em-dark.svg')),
            ],
            'md_ins' => [
                'title'     => __('Inserted'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_ins.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_ins-dark.svg')),
            ],
            'md_del' => [
                'title'     => __('Deleted'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_del.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_del-dark.svg')),
            ],

            'md_quote' => [
                'title'     => __('Inline quote'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_quote.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_quote-dark.svg')),
                'dialog'    => [
                    'url'          => $citeurl_input,
                    'default_url'  => '',
                    'language'     => $citelang_select,
                    'default_lang' => '',
                ],
            ],

            'md_code' => [
                'title'     => __('Code'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_code.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_code-dark.svg')),
            ],
            'md_mark' => [
                'title'     => __('Mark'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_mark.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_mark-dark.svg')),
            ],

            'md_foreign' => [
                'title'     => __('Foreign text'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_foreign.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_foreign-dark.svg')),
                'dialog'    => [
                    'language'     => $language_select,
                    'default_lang' => 'en',
                ],
            ],

            'md_br' => [
                'title'     => __('Linebreak '),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_br.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_br-dark.svg')),
            ],

            'md_blockquote' => [
                'title'     => __('Blockquote'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_bquote.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_bquote-dark.svg')),
            ],
            'md_pre' => [
                'title'     => __('Preformatedtext'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_pre.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_pre-dark.svg')),
            ],
            'md_ul' => [
                'title'     => __('Unorderedlist'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_ul.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_ul-dark.svg')),
            ],
            'md_ol' => [
                'title'     => __('Orderedlist'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_ol.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_ol-dark.svg')),
            ],

            'md_details' => [
                'title'        => __('Details block'),
                'icon'         => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_details.svg')),
                'icon_dark'    => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_details-dark.svg')),
                'title_prompt' => __('Summary:'),
            ],

            'md_aside' => [
                'title'     => __('Aside block'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_aside.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_aside-dark.svg')),
            ],

            'md_link' => [
                'title'     => __('Link'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_link.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_link-dark.svg')),
                'open_url'  => App::backend()->url()->get('admin.link.popup', ['popup' => 1, 'plugin_id' => 'dcLegacyEditor'], '&'),
            ],

            'md_img' => [
                'title'        => __('Externalimage'),
                'icon'         => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_img.svg')),
                'icon_dark'    => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_img-dark.svg')),
                'src_prompt'   => __('URL:'),
                'title_prompt' => __('Title (optional):'),
            ],

            'md_img_select' => [
                'title'     => __('Mediachooser'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_img_select.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_img_select-dark.svg')),
                'open_url'  => App::backend()->url()->get('admin.media', ['popup' => 1, 'plugin_id' => 'dcLegacyEditor'], '&'),
                'disabled'  => (!App::auth()->check(App::auth()->makePermissions([
                    App::auth()::PERMISSION_MEDIA,
                    App::auth()::PERMISSION_MEDIA_ADMIN,
                ]), App::blog()->id())),
            ],

            'md_post_link' => [
                'title'     => __('Linktoanentry'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_post.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_post-dark.svg')),
                'open_url'  => App::backend()->url()->get('admin.posts.popup', ['plugin_id' => 'dcLegacyEditor'], '&'),
            ],
            'md_footnote' => [
                'title'     => __('Footnote'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_footnote.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_footnote-dark.svg')),
            ],
            'md_preview' => [
                'title'     => __('Preview'),
                'icon'      => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_preview.svg')),
                'icon_dark' => urldecode((string) App::backend()->page()->getPF(My::id() . '/img/bt_preview-dark.svg')),
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
        if (isset($cols['posts'])) {
            $cols['posts'][1]['format'] = [true, __('Format')];
        }
        if (isset($cols['pages'])) {
            $cols['pages'][1]['format'] = [true, __('Format')];
        }

        return '';
    }

    /**
     * @param      ArrayObject<string, mixed>     $cols         The cols
     * @param      bool                           $component    Component as value is prefered
     */
    private static function adminEntryListHeader(ArrayObject $cols, bool $component = false): string
    {
        $value = (new Th())
            ->scope('col')
            ->text(__('Format'));

        $cols['format'] = $component ? $value : $value->render();

        return '';
    }

    /**
     * @param      MetaRecord                     $rs           The recordset
     * @param      ArrayObject<string, mixed>     $cols         The cols
     * @param      bool                           $component    Component as value is prefered
     */
    public static function adminPostListHeader(MetaRecord $rs, ArrayObject $cols, bool $component = false): string
    {
        return self::adminEntryListHeader($cols, $component);
    }

    /**
     * @param      MetaRecord                     $rs           The recordset
     * @param      ArrayObject<string, mixed>     $cols         The cols
     * @param      bool                           $component    Component as value is prefered
     */
    public static function adminPagesListHeader(MetaRecord $rs, ArrayObject $cols, bool $component = false): string
    {
        return self::adminEntryListHeader($cols, $component);
    }

    /**
     * @param      MetaRecord                     $rs           The recordset
     * @param      ArrayObject<string, mixed>     $cols         The cols
     * @param      bool                           $component    Component as value is prefered
     */
    private static function adminEntryListValue(MetaRecord $rs, ArrayObject $cols, bool $component = false): string
    {
        $value = (new Td())
            ->class('nowrap')
            ->items([
                self::getFormat($rs->post_format),
            ]);

        $cols['format'] = $component ? $value : $value->render();

        return '';
    }

    /**
     * @param      MetaRecord                     $rs           The recordset
     * @param      ArrayObject<string, mixed>     $cols         The cols
     * @param      bool                           $component    Component as value is prefered
     */
    public static function adminPostListValue(MetaRecord $rs, ArrayObject $cols, bool $component = false): string
    {
        return self::adminEntryListValue($rs, $cols, $component);
    }

    /**
     * @param      MetaRecord                     $rs           The recordset
     * @param      ArrayObject<string, mixed>     $cols         The cols
     * @param      bool                           $component    Component as value is prefered
     */
    public static function adminPagesListValue(MetaRecord $rs, ArrayObject $cols, bool $component = false): string
    {
        return self::adminEntryListValue($rs, $cols, $component);
    }

    private static function getFormat(string $format = ''): Img|None
    {
        $images = [
            'markdown' => App::backend()->page()->getPF(My::id() . '/img/markdown.svg'),
            'xhtml'    => App::backend()->page()->getPF(My::id() . '/img/xhtml.svg'),
            'wiki'     => App::backend()->page()->getPF(My::id() . '/img/wiki.svg'),
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
