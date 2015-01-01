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

if (!defined('DC_CONTEXT_ADMIN')) { return; }

// dead but useful code, in order to have translations
__('Markdown syntax').__('Brings you markdown (extra) syntax for your entries (see http://michelf.com/projects/php-markdown/extra/)');

$core->addFormater('markdown', array('dcMarkdown','convert'));

$core->addBehavior('adminBlogPreferencesForm',array('dcMarkdownAdmin','adminBlogPreferencesForm'));
$core->addBehavior('adminBeforeBlogSettingsUpdate',array('dcMarkdownAdmin','adminBeforeBlogSettingsUpdate'));

$core->addBehavior('adminPostEditor',array('dcMarkdownAdmin','adminPostEditor'));
