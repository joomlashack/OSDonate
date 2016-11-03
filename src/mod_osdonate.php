<?php
/**
 * @package   OSDonate
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2010 VeroPlus.com
 * @copyright 2011 - 2016 Open Source Training, LLC. All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

use Alledia\OSDonate\Free\Helper;

// no direct access
defined('_JEXEC') or die();

require_once 'include.php';

//load css
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'media/mod_osdonate/css/style.css');

//Return the selected paypal language from the module parameters
//substr returns part of the string.
//In this case substr starts at the first character and returns 1 more (2 total)
//e.g. substr(en_US, 3, 2); //will return "US"
//instead of using substr, we could have set the local values to just the lower case code.
//e.g. "en_US" could be "US"
$langSite = substr($params->get('locale'), 3, 2);

//$langSite will never be null so if statement will always execute
if (!$langSite) {
    $langSite = 'US';
}

//get intro text if there is any
//need more comments when I have some time
$introtext = '';
if ($params->get('show_text', 1)) {
    $introtext = '<p class="osdonate-introtext">' . $params->get('intro_text', '') . '</p>' . "\n";
}

//need more comments when I have some time
$amountLine = '';
if (!$params->get('show_amount')) {
    $amountLine .= '<input type="hidden" name="amount" value="' . $params->get('amount') . '" />' . "\n";
} else {
    $amountLine .= JText::_($params->get('amount_label'))
        . ':<br/><input type="text" name="amount" size="4" maxlength="10" value="'. $params->get('amount') . '"
                    class="osdonate-amount" />' . "\n";
}

//need more comments when I have some time
$currencies = explode(',', $params->get('currencies'));

//need more comments when I have some time
$availableCurrencies = array(
    'EUR',
    'USD',
    'GBP',
    'BRL',
    'CHF',
    'AUD',
    'HKD',
    'CAD',
    'JPY',
    'NZD',
    'SGD',
    'SEK',
    'DKK',
    'PLN',
    'NOK',
    'HUF',
    'CZK',
    'ILS',
    'MXN'
);

//need more comments when I have some time
$sizeOfCurr = sizeof($currencies);
for ($i = 0; $i < $sizeOfCurr; $i++) {
    for ($j = 0; $j < sizeof($availableCurrencies); $j++) {
        if ($currencies[$i] === $availableCurrencies[$j]) {
            $isOk = 1;
            break;
        }
    }
    if (!$isOk) {
        unset($currencies[$i]);
    }
    $isOk = 0;
}

//need more comments when I have some time
if (sizeof($currencies) == 0) {
    $amountLine = '<p class="error">' . JText::_('Error - no currencies selected!') . '<br/>' . JText::_(
            'Please check the backend parameters!'
        ) . '</p>';
    $fe_c       = '';
} else {
    if (sizeof($currencies) == 1) {
        $fe_c = '<input type="hidden" name="currency_code" value="' . $currencies[0] . '" />' . "\n";
        if ($params->get('show_amount', 1)) {
            $fe_c .= '&nbsp;' . $currencies[0] . "\n";
        }
    } else {
        if (sizeof($currencies) > 1) {
            if ($params->get('show_amount', 1)) {
                $fe_c = '<select name="currency_code">' . "\n";
                foreach ($currencies as $row) {
                    $fe_c .= '<option value="' . $row . '">' . $row . '</option>' . "\n";
                }
                $fe_c .= '</select>' . "\n";
            } else {
                $fe_c = '<input type="hidden" name="currency_code" value="' . $currencies[0] . '" />' . "\n";
            }
        }
    }
}

$application = JFactory::getApplication();

$returnMenuListIds = array(
    $params->get('return', ''),
    $params->get('cancel_return', '')
);

foreach ($returnMenuListIds as $index => $itemId) {
    // Check if the $itemId is a number or not (legacy params)
    if (is_numeric($itemId)) {
        // A menu item
        $menu = $application->getMenu();
        $link = $menu->getItem($itemId)->link;
    } else {
        // String, probably a relative or external URL
        $link = $itemId;
    }

    if (JURI::isInternal($link)) {
        $linkOfMenuItems[$index] = Helper::stripDoubleSlashes(JURI::base()) . JRoute::_('index.php?Itemid=' . $itemId);
    } else {
        $linkOfMenuItems[$index] = $link;
    }
}

//need more comments when I have some time
$target = '';
if ($params->get('open_new_window', 1)) {
    $target = 'target="paypal"';
}

$target = '';
if ($params->get('open_new_window', 1)) {
    $target = 'target="paypal"';
}

$widthOfModule = $params->get('width_of_sticky_hover', 200);

$use_sticky_hover = $params->get('use_sticky_hover', '0');
$horizontal_reference_side = $params->get('horizontal_reference_side');
$horizontal_distance = $params->get('horizontal_distance');
$vertical_reference_side = $params->get('vertical_reference_side');
$vertical_distance = $params->get('vertical_distance');
$sticky = '';

if ($use_sticky_hover == 1) {
    $document->addScript(JURI::base() . "/media/mod_osdonate/js/stickyHoverOptions.js");
    $sticky .= "<div class=\"osdonate-sticky-hover\" style=\"";
    $sticky .= $horizontal_reference_side . ":";
    $sticky .= $horizontal_distance . "px" . ";";
    $sticky .= $vertical_reference_side . ":";
    $sticky .= $vertical_distance . "px;width:" . $widthOfModule . "px;z-index:1000;visibility:visible;\"";
    $sticky .= " id=\"osdonatesticky\">";
} else {
    $sticky .= "<div id=\"osdonatestatic\">";
}

require JModuleHelper::getLayoutPath('mod_osdonate', $params->get('layout', 'default'));
