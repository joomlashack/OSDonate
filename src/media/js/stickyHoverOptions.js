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

    let stickyClass = 'osdonate-sticky-hover',
        minimumWidth = 768;

    /**
     * @param {string} selector
     *
     * @return void
     */
    let setStickyHoverStyle = function(selector) {
        let $parent   = $(selector).parent('div'),
            $osdonate = $(selector);

        // Move header text into the form container
        $osdonate.prev().prependTo($osdonate);

        $parent.css({
            'visibility': 'hidden',
            'margin'    : 0,
            'padding'   : 0,
            'min-height': 0,
            'border'    : 0
        });

        $osdonate.addClass(stickyClass);
        $osdonate.attr('style', function() {
            return $(selector).data('style');
        });
    };

    /**
     * @param {string} selector
     *
     * @return void
     */
    let disableStickyHoverStyle = function(selector) {
        let $parent   = $(selector).parent('div'),
            $osdonate = $(selector),
            $header = $(selector + ' h3');

        // Move header back to original container
        $parent.prepend($header.detach()).attr('style', '');

        $osdonate.attr('style', '').removeClass(stickyClass)
    };

    let $stickies = $('.' + stickyClass);

    $stickies.each(function() {
        let $this = $(this);

        $this.data('style', $this.attr('style'));
    });

    $(window).resize(function() {
        $stickies.each(function() {
            let selector = '#' + this.id;

            if ($(window).width() <= minimumWidth) {
                disableStickyHoverStyle(selector);
            } else {
                setStickyHoverStyle(selector);
            }
        });
    });

    $(window).trigger('resize');
});
