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

if (!defined('DC_RC_PATH')) { return; }

require_once dirname(__FILE__).'/inc/markdown.php';

/* Add behavior callback for markdown convert of comments */
$core->addBehavior('publicBeforeCommentTransform',array('dcMarkdownPublic','publicBeforeCommentTransform'));

class dcMarkdownPublic
{
	public static function publicBeforeCommentTransform($content)
	{
		global $core;

		if ($core->blog->settings->system->markdown_comments)
		{
			$o = new MarkdownExtra_Parser;
			return $o->transform($content);
		}
		return '';
	}
}
