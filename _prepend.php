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

$__autoload['MarkdownExtra_Parser'] = dirname(__FILE__) . '/inc/markdown.php';
$__autoload['dcMarkdown']           = dirname(__FILE__) . '/inc/class.dc.markdown.php';

$core->addBehavior('coreInitWikiPost', array('dcMarkdown', 'coreInitWikiPost'));

if (!defined('DC_CONTEXT_ADMIN')) {return false;}
// admin

$__autoload['dcMarkdownAdmin'] = dirname(__FILE__) . '/inc/class.dc.markdown.php';
