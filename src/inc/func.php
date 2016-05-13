<?php
/**
 * @category  Joomla Component
 * @package   mod_osdonate
 * @author    VeroPlus.com
 * @copyright 2010 VeroPlus.com
 * @copyright 2011, 2013 Open Source Training, LLC. All rights reserved
 * @contact   www.ostraining.com, support@ostraining.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version   1.9.1
 */

// no direct access
defined('_JEXEC') or die();

function stripDoubleSlashes($url)
{
    preg_match('/^.+?[^\/:](?=[?\/])|$/', $url, $matches);
    return $matches[0];
}
