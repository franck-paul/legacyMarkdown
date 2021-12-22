<?php
/**
 * @brief formatting-markdown, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return;
}
// public

class dcMarkdown
{
    public static function convert($str, $type = 'full')
    {
        $o = new Michelf\MarkdownExtra();
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
        $o->fn_id_prefix = 'ts' . dt::str('%s') . '.';

        return $o->transform($str);
    }

    public static function coreInitWikiPost($wiki2xhtml)
    {
        $wiki2xhtml->registerFunction('macro:md', ['dcMarkdown', 'convert']);
    }
}

if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}
// admin

class dcMarkdownAdmin
{
    public static function adminBlogPreferencesForm($core, $settings)
    {
        echo
        '<div class="fieldset"><h4 id="formatting_markdown">Markdown</h4>' .
        '<p><label class="classic">' .
        form::checkbox('markdown_comments', '1', $settings->system->markdown_comments) .
        __('Enable Markdown syntax for comments') . '</label></p>' .
        '<p class="clear form-note warning">' . __('This option, if enabled, will replace the standard wiki syntax for comments!') . '</p>' .
        '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate($settings)
    {
        $settings->system->put('markdown_comments', !empty($_POST['markdown_comments']), 'boolean');
    }

    public static function adminPostEditor($editor = '', $context = '', array $tags = [], $syntax = 'markdown')
    {
        global $core;

        if ($editor != 'dcLegacyEditor' || $syntax != 'markdown') {
            return;
        }

        return
        dcPage::jsJson('formatting_markdown', [
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

            'md_strong' => ['title' => __('Strong emphasis')],
            'md_em'     => ['title' => __('Emphasis')],
            'md_ins'    => ['title' => __('Inserted')],
            'md_del'    => ['title' => __('Deleted')],

            'md_quote' => [
                'title'       => __('Inline quote'),
                'cite_prompt' => __('Source URL:'),
                'lang_prompt' => __('Language:'),
            ],

            'md_code' => ['title' => __('Code')],
            'md_mark' => ['title' => __('Mark')],

            'md_foreign' => [
                'title'       => __('Foreign text'),
                'lang_prompt' => __('Language:'),
            ],

            'md_br' => ['title' => __('Linebreak ')],

            'md_blockquote' => ['title' => __('Blockquote')],
            'md_pre'        => ['title' => __('Preformatedtext')],
            'md_ul'         => ['title' => __('Unorderedlist')],
            'md_ol'         => ['title' => __('Orderedlist')],

            'md_details' => [
                'title'        => __('Details block'),
                'title_prompt' => __('Summary:'),
            ],

            'md_aside' => ['title' => __('Aside block')],

            'md_link' => [
                'title'        => __('Link'),
                'href_prompt'  => __('URL:'),
                'title_prompt' => __('Title:'),
                'lang_prompt'  => __('Language:'),
            ],

            'md_img' => [
                'title'        => __('Externalimage'),
                'src_prompt'   => __('URL:'),
                'title_prompt' => __('Title:'),
            ],

            'md_img_select' => [
                'title'    => __('Mediachooser'),
                'disabled' => (!$GLOBALS['core']->auth->check('media,media_admin', $GLOBALS['core']->blog->id) ? true : false),
            ],

            'md_post_link' => ['title' => __('Linktoanentry')],
        ]) .
        dcPage::cssLoad(urldecode(dcPage::getPF('formatting-markdown/css/jsToolBar.css')), 'screen', $core->getVersion('formatting-markdown')) .
        dcPage::jsLoad(urldecode(dcPage::getPF('formatting-markdown/js/post.js')), $core->getVersion('formatting-markdown'));
    }

    public static function adminColumnsLists($core, $cols)
    {
        $cols['posts'][1]['format'] = [true, __('Format')];
        $cols['pages'][1]['format'] = [true, __('Format')];
    }

    private static function adminEntryListHeader($core, $rs, $cols)
    {
        $cols['format'] = '<th scope="col">' . __('Format') . '</th>';
    }

    public static function adminPostListHeader($core, $rs, $cols)
    {
        self::adminEntryListHeader($core, $rs, $cols);
    }

    public static function adminPagesListHeader($core, $rs, $cols)
    {
        self::adminEntryListHeader($core, $rs, $cols);
    }

    public static function adminEntryListValue($core, $rs, $cols)
    {
        $cols['format'] = '<td class="nowrap">' . self::getFormat($rs->post_format) . '</td>';
    }

    public static function adminPostListValue($core, $rs, $cols)
    {
        self::adminEntryListValue($core, $rs, $cols);
    }

    public static function adminPagesListValue($core, $rs, $cols)
    {
        self::adminEntryListValue($core, $rs, $cols);
    }

    private static function getFormat(string $format = ''): string
    {
        $images = [
            'markdown' => dcPage::getPF('formatting-markdown/img/markdown.svg'),
            'xhtml'    => dcPage::getPF('formatting-markdown/img/xhtml.svg'),
            'wiki'     => dcPage::getPF('formatting-markdown/img/wiki.svg'),
        ];
        if (array_key_exists($format, $images)) {
            return '<img style="width: 1.25em; height: 1.25em;" src="' . $images[$format] . '" title="' . $format . '" />';
        }

        return $format;
    }
}
