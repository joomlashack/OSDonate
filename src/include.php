<?php
/**
 * @package   OSDonate
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2016-2022 Joomlashack.com. All rights reserved
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 * This file is part of OSDonate.
 *
 * OSDonate is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * OSDonate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OSDonate.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('_JEXEC') or die();

use Alledia\Framework\AutoLoader;
use Joomla\CMS\Factory;

try {
    $frameworkPath = JPATH_SITE . '/libraries/allediaframework/include.php';
    if (!(is_file($frameworkPath) && include $frameworkPath)) {
        $app = Factory::getApplication();

        if ($app->isClient('administrator')) {
            $app->enqueueMessage('[OSMap] Joomlashack framework not found', 'error');
        }
        return false;
    }
    unset($frameworkPath);

    if (defined('ALLEDIA_FRAMEWORK_LOADED') && !defined('MOD_OSDONATE_LOADED')) {
        define('MOD_OSDONATE_LOADED', 1);

        AutoLoader::register('Alledia\OSDonate', JPATH_SITE . '/modules/mod_osdonate/library');
    }

} catch (Throwable $error) {
    Factory::getApplication()->enqueueMessage('[OSDonate] Unable to initialize: ' . $error->getMessage(), 'error');

    return false;

}

return defined('ALLEDIA_FRAMEWORK_LOADED') && defined('MOD_OSDONATE_LOADED');
