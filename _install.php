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
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

$new_version = dcCore::app()->plugins->moduleInfo('formatting-markdown', 'version');
$old_version = dcCore::app()->getVersion('formatting-markdown');

if (version_compare((string) $old_version, $new_version, '>=')) {
    return;
}

try {
    if (version_compare((string) $old_version, '1.10', '<')) {
        # A bit of housecleaning for no longer needed files
        $remfiles = [
            'inc/markdown.php',
            'inc/License.text',
        ];
        foreach ($remfiles as $f) {
            @unlink(DC_ROOT . '/' . $f);
        }
    }

    dcCore::app()->setVersion('formatting-markdown', $new_version);

    return true;
} catch (Exception $e) {
    dcCore::app()->error->add($e->getMessage());
}

return false;
