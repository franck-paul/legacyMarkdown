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

if (!defined('DC_RC_PATH')) {return;}
// public

class dcMarkdown
{
    public static function convert($str)
    {
        $o = new MarkdownExtra_Parser;
        return $o->transform($str);
    }

    public static function coreInitWikiPost($wiki2xhtml)
    {
        $wiki2xhtml->registerFunction('macro:md', ['dcMarkdown', 'convert']);
    }
}

if (!defined('DC_CONTEXT_ADMIN')) {return;}
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
            'md_blocks'     => [
                'options' => [
                    'none'    => __('-- none --'),
                    'nonebis' => __('-- block format --'),
                    'p'       => __('Paragraph'),
                    'h1'      => __('Level 1 header'),
                    'h2'      => __('Level 2 header'),
                    'h3'      => __('Level 3 header'),
                    'h4'      => __('Level 4 header'),
                    'h5'      => __('Level 5 header'),
                    'h6'      => __('Level 6 header')
                ]
            ],

            'md_strong'     => ['title' => __('Strong emphasis')],
            'md_em'         => ['title' => __('Emphasis')],
            'md_ins'        => ['title' => __('Inserted')],
            'md_del'        => ['title' => __('Deleted')],
            'md_quote'      => ['title' => __('Inline quote')],
            'md_code'       => ['title' => __('Code')],

            'md_br'         => ['title' => __('Linebreak ')],

            'md_blockquote' => ['title' => __('Blockquote')],
            'md_pre'        => ['title' => __('Preformatedtext')],
            'md_ul'         => ['title' => __('Unorderedlist')],
            'md_ol'         => ['title' => __('Orderedlist')],

            'md_link'       => [
                'title'        => __('Link'),
                'href_prompt'  => __('URL ? '),
                'title_prompt' => __('Title ? ')
            ],

            'md_img'        => [
                'title'        => __('Externalimage'),
                'src_prompt'   => __('URL ? '),
                'title_prompt' => __('Title ? ')
            ],

            'md_img_select' => [
                'title'    => __('Mediachooser'),
                'disabled' => (!$GLOBALS['core']->auth->check('media,media_admin', $GLOBALS['core']->blog->id) ? true : false)
            ],

            'md_post_link'  => ['title' => __('Linktoanentry')]
        ]) .
        dcPage::jsLoad(urldecode(dcPage::getPF('formatting-markdown/js/post.js')), $core->getVersion('formatting-markdown'));
    }
}
