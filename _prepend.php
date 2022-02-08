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

$__autoload['Michelf\MarkdownInterface'] = __DIR__ . '/lib/Michelf/MarkdownInterface.php';
$__autoload['Michelf\Markdown']          = __DIR__ . '/lib/Michelf/Markdown.php';
$__autoload['Michelf\MarkdownExtra']     = __DIR__ . '/lib/Michelf/MarkdownExtra.php';

$__autoload['dcMarkdown']     = __DIR__ . '/inc/class.dc.markdown.php';
$__autoload['dcMarkdownRest'] = __DIR__ . '/_services.php';

$core->addBehavior('coreInitWikiPost', ['dcMarkdown', 'coreInitWikiPost']);

if (!defined('DC_CONTEXT_ADMIN')) {
    return false;
}
// admin

$__autoload['dcMarkdownAdmin'] = __DIR__ . '/inc/class.dc.markdown.php';
