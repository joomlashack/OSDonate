<?php
/**
 * @package   OSDonate
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2010 VeroPlus.com
 * @copyright 2011-2021 Joomlashack.com. All rights reserved
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

use Alledia\OSDonate\Free\Helper;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Language;
use Joomla\Registry\Registry;

// no direct access
defined('_JEXEC') or die();

/**
 * @var object          $module
 * @var string[]        $attribs
 * @var array           $chrome
 * @var SiteApplication $app
 * @var string          $scope
 * @var Registry        $params
 * @var string          $template
 * @var string          $path
 * @var Language        $lang
 * @var string          $coreLanguageDirectory
 * @var string          $extensionLanguageDirectory
 * @var string[]        $langPaths
 * @var string          $content
 */

if ((include 'include.php') == false) {
    return;
}

$helper = new Helper($params, $module);
HTMLHelper::_('stylesheet', 'mod_osdonate/style.min.css', ['relative' => true]);

/** @deprecated v2.0.0: Use native document loading */
$document = Factory::getDocument();

/** @deprecated v2.0.0: Use Helper::getSiteLanguage() directly */
$langSite = $helper->getSiteLanguage();

/** @deprecated v2.0.0: Use Helper::getIntroText() directly */
$introtext = $helper->getIntroText();

/** @deprecated v2.0.0: Use Helper::getAmountLine() directly */
$amountLine = $helper->getAmountLine();

/** @deprecated v2.0.0: Use $returnMenus instead */
$linkOfMenuItems = array_values($helper->getReturnMenus());

/** @deprecated v2.0.0: Use Helper::getCurrencyField() directly */
$fe_c            = $helper->getCurrencyCodeField();

$currencies      = $helper->getCurrencies();
$target          = $params->get('open_new_window', 1) ? 'target="paypal"' : '';

/** @deprecated v2.0.0: Don't display in templates */
$sticky = $helper->getOpeningDiv();
echo $sticky;

require ModuleHelper::getLayoutPath('mod_osdonate', $params->get('layout', 'default'));

echo '</div>';
