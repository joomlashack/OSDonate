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
use Joomla\CMS\Document\HtmlDocument;
use Joomla\CMS\Input\Input;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

defined('_JEXEC') or die();

/**
 * @var string          $path
 * @var object          $module
 * @var SiteApplication $app
 * @var Input           $input           Only Joomla 4
 * @var Registry        $params
 * @var string          $template
 * @var Helper          $helper
 * @var HtmlDocument    $document
 * @var string[]        $currencies
 * @var string          $target
 * @var string          $langSite        @deprecated v2.0.0
 * @var string          $introtext       @deprecated v2.0.0
 * @var string          $amountLine      @deprecated v2.0.0
 * @var array           $linkOfMenuItems @deprecated v2.0.0
 * @var string          $fe_c            @deprecated v2.0.0
 * @var string          $sticky          @deprecated v2.0.0
 */

echo $helper->getIntroText();
?>
<form id="<?php echo 'osdonate-form-' . $params->get('module.id'); ?>"
      class="osdonate-form"
      action="https://www.paypal.com/cgi-bin/webscr"
      method="post" <?php echo $target; ?>>
    <input type="hidden" name="cmd" value="_donations"/>
    <input type="hidden" name="business" value="<?php echo $params->get('business', ''); ?>"/>
    <input type="hidden" name="return" value="<?php echo $params->get('links.return'); ?>"/>
    <input type="hidden" name="undefined_quantity" value="0"/>
    <input type="hidden" name="item_name" value="<?php echo $params->get('item_name', ''); ?>"/>
    <?php echo $helper->getAmountLine(); ?>
    <?php echo $helper->getCurrencyCodeField(); ?>
    <input type="hidden" name="rm" value="2"/>
    <input type="hidden" name="charset" value="utf-8"/>
    <input type="hidden" name="no_shipping" value="1"/>
    <input type="hidden" name="image_url" value="<?php echo Uri::base() . $params->get('image_url', ''); ?>"/>
    <input type="hidden" name="cancel_return" value="<?php echo $params->get('links.cancel'); ?>"/>
    <input type="hidden" name="no_note" value="0"/>
    <input type="image" src="<?php echo $params->get('pp_image', ''); ?>" name="submit" alt="PayPal secure payments."/>
    <input type="hidden" name="lc" value="<?php echo $helper->getSiteLanguage(); ?>">
</form>
