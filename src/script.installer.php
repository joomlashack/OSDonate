<?php

/**
 * @package   OSDonate
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2016-2026 Joomlashack.com. All rights reserved
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

use Alledia\Installer\AbstractScript;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;

// phpcs:disable PSR1.Files.SideEffects
defined('_JEXEC') or die();

require_once __DIR__ . '/library/Installer/include.php';

// phpcs:enable PSR1.Files.SideEffects
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

class Mod_OSDonateInstallerScript extends AbstractScript
{
    /**
     * @inheritDoc
     */
    protected function customPostFlight($type, $parent): void
    {
        $files = Folder::files(JPATH_SITE . '/language', 'mod_osdonate', true, true);
        foreach ($files as $file) {
            File::delete($file);
        }
    }
}
