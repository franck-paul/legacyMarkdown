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

if (!dcCore::app()->newVersion(basename(__DIR__), dcCore::app()->plugins->moduleInfo(basename(__DIR__), 'version'))) {
    return;
}

try {
    $old_version = dcCore::app()->getVersion(basename(__DIR__));

    if (version_compare((string) $old_version, '1.10', '<')) {
        # A bit of housecleaning for no longer needed files
        $remfiles = [
            ['inc','markdown.php'],
            ['inc','License.text'],
        ];
        foreach ($remfiles as $f) {
            @unlink(dcUtils::path([__DIR__, ...$f]));
        }
    }

    return true;
} catch (Exception $e) {
    dcCore::app()->error->add($e->getMessage());
}

return false;
