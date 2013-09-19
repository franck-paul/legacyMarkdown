<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of googleTools, a plugin for Dotclear 2.
#
# Copyright (c) Olivier Meunier, Franck Paul and contributors
#
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------

if (!defined('DC_CONTEXT_ADMIN')) { return; }

$GLOBALS['__autoload']['MarkdownExtra_Parser'] = dirname(__FILE__).'/markdown.php';
$core->addFormater('markdown', array('dcMarkdown','convert'));

$core->addBehavior('adminPostHeaders',array('dcMarkdown','adminPostHeaders'));
$core->addBehavior('adminPageHeaders',array('dcMarkdown','adminPostHeaders'));

class dcMarkdown
{
	public static function adminPostHeaders() {

	    $res = '<script type="text/javascript" src="index.php?pf=formatting-markdown/_post.js"></script>';

	    $res .=
		'<script type="text/javascript">'."\n".
		"//<![CDATA[\n".
		"jsToolBar.prototype.elements.md_blocks.options.none = '".html::escapeJS(__('-- none --'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.nonebis = '".html::escapeJS(__('-- block format --'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.p = '".html::escapeJS(__('Paragraph'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.h1 = '".html::escapeJS(__('Level 1 header'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.h2 = '".html::escapeJS(__('Level 2 header'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.h3 = '".html::escapeJS(__('Level 3 header'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.h4 = '".html::escapeJS(__('Level 4 header'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.h5 = '".html::escapeJS(__('Level 5 header'))."'; ".
		"jsToolBar.prototype.elements.md_blocks.options.h6 = '".html::escapeJS(__('Level 6 header'))."'; ".

		"jsToolBar.prototype.elements.md_strong.title = '".html::escapeJS(__('Strong emphasis'))."'; ".
		"jsToolBar.prototype.elements.md_em.title = '".html::escapeJS(__('Emphasis'))."'; ".
		"jsToolBar.prototype.elements.md_ins.title = '".html::escapeJS(__('Inserted'))."'; ".
		"jsToolBar.prototype.elements.md_del.title = '".html::escapeJS(__('Deleted'))."'; ".
		"jsToolBar.prototype.elements.md_quote.title = '".html::escapeJS(__('Inline quote'))."'; ".
		"jsToolBar.prototype.elements.md_code.title = '".html::escapeJS(__('Code'))."'; ".

		"jsToolBar.prototype.elements.md_br.title = '".html::escapeJS(__('Line break'))."'; ".

		"jsToolBar.prototype.elements.md_blockquote.title = '".html::escapeJS(__('Blockquote'))."'; ".
		"jsToolBar.prototype.elements.md_pre.title = '".html::escapeJS(__('Preformated text'))."'; ".
		"jsToolBar.prototype.elements.md_ul.title = '".html::escapeJS(__('Unordered list'))."'; ".
		"jsToolBar.prototype.elements.md_ol.title = '".html::escapeJS(__('Ordered list'))."'; ".

		"jsToolBar.prototype.elements.md_link.title = '".html::escapeJS(__('Link'))."'; ".
		"jsToolBar.prototype.elements.md_link.href_prompt = '".html::escapeJS(__('URL?'))."'; ".
		"jsToolBar.prototype.elements.md_link.title_prompt = '".html::escapeJS(__('Title?'))."'; ".

		"jsToolBar.prototype.elements.md_img.title = '".html::escapeJS(__('External image'))."'; ".
		"jsToolBar.prototype.elements.md_img.src_prompt = '".html::escapeJS(__('URL?'))."'; ".
		"jsToolBar.prototype.elements.md_img.title_prompt = '".html::escapeJS(__('Title?'))."'; ".

		"jsToolBar.prototype.elements.md_img_select.title = '".html::escapeJS(__('Media chooser'))."'; ".
		"jsToolBar.prototype.elements.md_post_link.title = '".html::escapeJS(__('Link to an entry'))."'; ";

		if (!$GLOBALS['core']->auth->check('media,media_admin',$GLOBALS['core']->blog->id)) {
			$res .= "jsToolBar.prototype.elements.md_img_select.disabled = true;\n";
		}
		$res .=
		"\n//]]>\n".
		"</script>\n";

		return $res;
	}

	public static function convert($str)
	{
		$o = new MarkdownExtra_Parser;
		return $o->transform($str);
	}
}
?>