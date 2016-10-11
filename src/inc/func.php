<?php
/**
 * @package   OSDonate
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2010 VeroPlus.com
 * @copyright 2011 - 2016 Open Source Training, LLC. All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die();

function stripDoubleSlashes($url)
{
    preg_match('/^.+?[^\/:](?=[?\/])|$/', $url, $matches);
    return $matches[0];
}
