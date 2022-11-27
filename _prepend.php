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

Clearbricks::lib()->autoload([
    'Michelf\MarkdownInterface' => __DIR__ . '/lib/Michelf/MarkdownInterface.php',
    'Michelf\Markdown'          => __DIR__ . '/lib/Michelf/Markdown.php',
    'Michelf\MarkdownExtra'     => __DIR__ . '/lib/Michelf/MarkdownExtra.php',

    'dcMarkdown'     => __DIR__ . '/inc/class.dc.markdown.php',
    'dcMarkdownRest' => __DIR__ . '/_services.php',
]);

dcCore::app()->addBehavior('coreInitWikiPost', [dcMarkdown::class, 'coreInitWikiPost']);

if (!defined('DC_CONTEXT_ADMIN')) {
    return false;
}
// admin

Clearbricks::lib()->autoload(['dcMarkdownAdmin' => __DIR__ . '/inc/class.dc.markdown.php']);
