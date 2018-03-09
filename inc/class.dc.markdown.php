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
        $wiki2xhtml->registerFunction('macro:md', array('dcMarkdown', 'convert'));
    }
}

if (!defined('DC_CONTEXT_ADMIN')) {return;}
// admin

class dcMarkdownAdmin
{
    public static function adminBlogPreferencesForm($core, $settings)
    {
        echo
        '<div class="fieldset"><h4>Markdown</h4>' .
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

    public static function adminPostEditor($editor = '', $context = '', array $tags = array(), $syntax = 'markdown')
    {
        global $core;

        if ($editor != 'dcLegacyEditor' || $syntax != 'markdown') {
            return;
        }

        $res = dcPage::jsLoad(urldecode(dcPage::getPF('formatting-markdown/js/post.js')), $core->getVersion('formatting-markdown'));

        $res .=
        '<script type="text/javascript">' . "\n" .
        "jsToolBar.prototype.elements.md_blocks.options.none = '" . html::escapeJS(__('-- none --')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.nonebis = '" . html::escapeJS(__('-- block format --')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.p = '" . html::escapeJS(__('Paragraph')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.h1 = '" . html::escapeJS(__('Level 1 header')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.h2 = '" . html::escapeJS(__('Level 2 header')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.h3 = '" . html::escapeJS(__('Level 3 header')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.h4 = '" . html::escapeJS(__('Level 4 header')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.h5 = '" . html::escapeJS(__('Level 5 header')) . "'; " .
        "jsToolBar.prototype.elements.md_blocks.options.h6 = '" . html::escapeJS(__('Level 6 header')) . "'; " .

        "jsToolBar.prototype.elements.md_strong.title = '" . html::escapeJS(__('Strong emphasis')) . "'; " .
        "jsToolBar.prototype.elements.md_em.title = '" . html::escapeJS(__('Emphasis')) . "'; " .
        "jsToolBar.prototype.elements.md_ins.title = '" . html::escapeJS(__('Inserted')) . "'; " .
        "jsToolBar.prototype.elements.md_del.title = '" . html::escapeJS(__('Deleted')) . "'; " .
        "jsToolBar.prototype.elements.md_quote.title = '" . html::escapeJS(__('Inline quote')) . "'; " .
        "jsToolBar.prototype.elements.md_code.title = '" . html::escapeJS(__('Code')) . "'; " .

        "jsToolBar.prototype.elements.md_br.title = '" . html::escapeJS(__('Line break')) . "'; " .

        "jsToolBar.prototype.elements.md_blockquote.title = '" . html::escapeJS(__('Blockquote')) . "'; " .
        "jsToolBar.prototype.elements.md_pre.title = '" . html::escapeJS(__('Preformated text')) . "'; " .
        "jsToolBar.prototype.elements.md_ul.title = '" . html::escapeJS(__('Unordered list')) . "'; " .
        "jsToolBar.prototype.elements.md_ol.title = '" . html::escapeJS(__('Ordered list')) . "'; " .

        "jsToolBar.prototype.elements.md_link.title = '" . html::escapeJS(__('Link')) . "'; " .
        "jsToolBar.prototype.elements.md_link.href_prompt = '" . html::escapeJS(__('URL?')) . "'; " .
        "jsToolBar.prototype.elements.md_link.title_prompt = '" . html::escapeJS(__('Title?')) . "'; " .

        "jsToolBar.prototype.elements.md_img.title = '" . html::escapeJS(__('External image')) . "'; " .
        "jsToolBar.prototype.elements.md_img.src_prompt = '" . html::escapeJS(__('URL?')) . "'; " .
        "jsToolBar.prototype.elements.md_img.title_prompt = '" . html::escapeJS(__('Title?')) . "'; " .

        "jsToolBar.prototype.elements.md_img_select.title = '" . html::escapeJS(__('Media chooser')) . "'; " .
        "jsToolBar.prototype.elements.md_post_link.title = '" . html::escapeJS(__('Link to an entry')) . "'; ";

        if (!$GLOBALS['core']->auth->check('media,media_admin', $GLOBALS['core']->blog->id)) {
            $res .= "jsToolBar.prototype.elements.md_img_select.disabled = true;\n";
        }
        $res .=
            "</script>\n";

        return $res;
    }
}
