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
// public

$__autoload['MarkdownExtra_Parser'] = dirname(__FILE__) . '/inc/markdown.php';
$__autoload['dcMarkdown']           = dirname(__FILE__) . '/inc/class.dc.markdown.php';

$core->addBehavior('coreInitWikiPost', array('dcMarkdown', 'coreInitWikiPost'));

if (!defined('DC_CONTEXT_ADMIN')) {return false;}
// admin

$__autoload['dcMarkdownAdmin'] = dirname(__FILE__) . '/inc/class.dc.markdown.php';
