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

jQuery(document).ready(function($) {
    'use strict';

    let setStickyHoverStyle = function(osdonate) {
        //declaring selectors
        let parentOfOSDonate = $(osdonate).parent('div'),
            OSDonate         = $(osdonate);

        //moving header text inside of #osdonatesticky
        OSDonate.prev().prependTo(OSDonate);

        parentOfOSDonate.css({
            'visibility': 'hidden',
            'margin'    : 0,
            'padding'   : 0,
            'min-height': 0,
            'border'    : 0
        });
        OSDonate.attr('style', function() {
            console.log(osdonate, $(osdonate).data());
            return $(osdonate).data('style');
        });
    }

    function disableStickyHoverStyle(osdonate) {
        //declaring selectors
        let parentOfOSDonate = $(osdonate).parent('div'),
            OSDonate         = $(osdonate);

        //moving header text back out of #osdonatesticky
        let headerText = $(osdonate + ' h3').detach();
        parentOfOSDonate.prepend(headerText);

        parentOfOSDonate.attr('style', '');
        OSDonate.attr('style', '');
    }

    let $stickies = $('.osdonate-sticky-hover');

    $stickies.each(function() {
        let osdonate = '#' + this.id,
            $this = $(this);

        $this.data('style', $this.attr('style'));
    });

    $(window).resize(function() {
        $stickies.each(function() {
            let osdonate = '#' + this.id;

            if ($(window).width() <= 768) {
                disableStickyHoverStyle(osdonate);
            } else {
                setStickyHoverStyle(osdonate);
            }
        });
    });

    $(window).trigger('resize');
});
