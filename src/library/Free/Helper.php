<?php
/**
 * @package   OSDonate
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2010 VeroPlus.com
 * @copyright 2011 - 2016 Open Source Training, LLC. All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace Alledia\OSDonate\Free;

defined('_JEXEC') or die();

class Helper
{
    /**
     * Strips double slash from an URL
     *
     * @param string $url
     * @return string
     */
    public static function stripDoubleSlashes($url)
    {
        preg_match('/^.+?[^\/:](?=[?\/])|$/', $url, $matches);

        return $matches[0];
    }
}
