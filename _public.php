<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of formatting-markdown, a plugin for Dotclear 2.
#
# Copyright (c) Olivier Meunier, Franck Paul and contributors
#
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------

if (!defined('DC_RC_PATH')) {return;}

/* Add behavior callback for markdown convert of comments */
$core->addBehavior('publicBeforeCommentTransform', array('dcMarkdownPublic', 'publicBeforeCommentTransform'));

class dcMarkdownPublic
{
    public static function publicBeforeCommentTransform($content)
    {
        global $core;

        if ($core->blog->settings->system->markdown_comments) {
            return dcMarkdown::convert($content);
        }
        return '';
    }
}
