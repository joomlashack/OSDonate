<?php
/**
 * @package   OSDonate
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2010 VeroPlus.com
 * @copyright 2011-2019 Joomlashack.com. All rights reserved
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

// no direct access
defined('_JEXEC') or die();

echo $sticky;
echo $introtext;
?>

<form class="osdonate-form" id="osdonate-form" action="https://www.paypal.com/cgi-bin/webscr"
      method="post" <?php echo $target; ?>>
    <input type="hidden" name="cmd" value="_donations"/>
    <input type="hidden" name="business" value="<?php echo $params->get('business', ''); ?>"/>
    <input type="hidden" name="return" value="<?php echo $linkOfMenuItems[0]; ?>"/>
    <input type="hidden" name="undefined_quantity" value="0"/>
    <input type="hidden" name="item_name" value="<?php echo $params->get('item_name', ''); ?>"/>
    <?php echo $amountLine . $fe_c; ?>
    <input type="hidden" name="rm" value="2"/>
    <input type="hidden" name="charset" value="utf-8"/>
    <input type="hidden" name="no_shipping" value="1"/>
    <input type="hidden" name="image_url" value="<?php echo JURI::base() . $params->get('image_url', ''); ?>"/>
    <input type="hidden" name="cancel_return" value="<?php echo $linkOfMenuItems[1]; ?>"/>
    <input type="hidden" name="no_note" value="0"/>
    <input type="image" src="<?php echo $params->get('pp_image', ''); ?>" name="submit" alt="PayPal secure payments."/>
    <input type="hidden" name="lc" value="<?php echo $langSite; ?>">
</form>
</div>
