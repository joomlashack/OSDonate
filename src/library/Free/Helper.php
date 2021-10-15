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

namespace Alledia\OSDonate\Free;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

defined('_JEXEC') or die();

class Helper
{
    protected const VALID_CURRENCIES = [
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
    ];

    /**
     * @var Registry
     */
    protected $params = null;

    /**
     * @var string[]
     */
    protected $currencies = null;

    /**
     * @var string[]
     */
    protected $returnLinks = null;

    /**
     * @param Registry $params
     * @param object   $module
     *
     * @return void
     */
    public function __construct(Registry $params, object $module)
    {
        $this->params = $params;

        $this->params->set('links', $this->getReturnMenus());

        $this->params->set('module', $module);
        $this->params->set('module.params', $module->params);
    }

    /**
     * @return string
     */
    public function getSiteLanguage(): string
    {
        return substr($this->params->get('locale'), 3, 2) ?: 'US';
    }

    /**
     * @return string
     */
    public function getIntroText(): string
    {
        return $this->params->get('show_text', 1) && $this->params->get('intro_text')
            ? sprintf('<p class="osdonate-introtext">%s</p>', $this->params->get('intro_text', ''))
            : '';
    }

    /**
     * @return string
     */
    public function getAmountLine(): string
    {
        $amountAttribs = [
            'type'  => 'hidden',
            'name'  => 'amount',
            'value' => $this->params->get('amount')
        ];
        if ((bool)$this->params->get('show_amount') == false) {
            $amountLine = sprintf('<input %s/>', ArrayHelper::toString($amountAttribs));

        } else {
            $amountAttribs = array_replace(
                $amountAttribs,
                [
                    'type'      => 'text',
                    'size'      => 4,
                    'maxlength' => 10,
                    'class='    => 'osdonate-amount'
                ]
            );

            $amountLine = sprintf(
                '%s<br><input %s/>',
                Text::_($this->params->get('amount_label')),
                ArrayHelper::toString($amountAttribs)
            );
        }

        if (empty(static::getCurrencies())) {
            $amountLine = sprintf(
                '<p class="error">%s<br>%s</p>',
                Text::_('MOD_OSDONATE_ERROR_NO_CURRENCIES_HEADING'),
                Text::_('MOD_OSDONATE_ERROR_NO_CURRENCIES_BODY')
            );
        }

        return $amountLine;
    }

    /**
     * @return string[]
     */
    public function getCurrencies(): array
    {
        if ($this->currencies === null) {
            $this->currencies = array_map(
                'trim',
                array_filter(
                    explode(',', $this->params->get('currencies'))
                )
            );

            $this->currencies = array_values(array_intersect($this->currencies, static::VALID_CURRENCIES));
        }

        return $this->currencies;
    }

    /**
     * @return string[]
     */
    public function getReturnMenus(): array
    {
        if ($this->returnLinks === null) {
            try {
                $app = Factory::getApplication();
            } catch (\Throwable $error) {
                return [];
            }

            $this->returnLinks = [
                'return' => $this->params->get('return', ''),
                'cancel' => $this->params->get('cancel_return', '')
            ];

            foreach ($this->returnLinks as $type => $itemId) {
                if (is_numeric($itemId)) {
                    // A menu item
                    $menu = $app->getMenu();
                    $link = $menu ? $menu->getItem($itemId)->link : null;

                } else {
                    // Legacy String, probably a relative or external URL
                    $link = $itemId;
                }

                if ($link && Uri::isInternal($link)) {
                    $this->returnLinks[$type]
                        = static::stripDoubleSlashes(Uri::base()) . Route::_('index.php?Itemid=' . $itemId);

                } else {
                    $this->returnLinks[$type] = $link;
                }
            }
        }

        return $this->returnLinks;
    }

    /**
     * @return string
     */
    public function getCurrencyCodeField(): string
    {
        $currencies = $this->getCurrencies();
        switch (count($currencies)) {
            case 0:
                $inputField = '';
                break;

            case 1:
                $inputField = sprintf(
                    '<input type="hidden" name="currency_code" value="%s"/>%s' . "\n",
                    $currencies[0],
                    $this->params->get('show_amount', 1) ? ('&nbsp;' . $currencies[0]) : ''
                );
                break;

            default:
                if ($this->params->get('show_amount', 1)) {
                    $currencyOptions = array_map(
                        function ($row) {
                            return HTMLHelper::_('select.option', $row);
                        },
                        $currencies
                    );

                    $inputField = HTMLHelper::_('select.genericlist', $currencyOptions, 'currency_code') . "\n";

                } else {
                    $inputField = '<input type="hidden" name="currency_code" value="' . $currencies[0] . '" />' . "\n";
                }
        }

        return $inputField ?? '';
    }

    /**
     * @return string
     */
    public function getOpeningDiv(): string
    {
        $layout = $this->params->get('layout');
        if (strpos($layout, ':') !== false) {
            $layout = explode(':', $layout);
            $layout = array_pop($layout);
        }

        $attribs = [
            'id'    => 'osdonate_' . $this->params->get('module.id'),
            'class' => 'osdonate-container osdonate-' . $layout
        ];

        if ($this->params->get('use_sticky_hover', false)) {
            HTMLHelper::_('script', 'mod_osdonate/stickyHoverOptions.js', ['relative' => true]);

            $width              = $this->params->get('width_of_sticky_hover', 200);
            $horizontal         = $this->params->get('horizontal_reference_side');
            $horizontalDistance = $this->params->get('horizontal_distance');
            $vertical           = $this->params->get('vertical_reference_side');
            $verticalDistance   = $this->params->get('vertical_distance');

            $stickyStyles = [
                $horizontal . ':' . $horizontalDistance . 'px',
                $vertical . ':' . $verticalDistance . 'px',
                'width:' . $width . 'px',
                'z-index:1000',
                'visibility:visible'
            ];
            $attribs      = array_merge(
                $attribs,
                [
                    'class' => $attribs['class'] . ' osdonate-sticky-hover',
                    'style' => join(';', $stickyStyles)
                ]);
        }

        return sprintf('<div  %s>', ArrayHelper::toString($attribs));
    }

    /**
     * Strips double slash from an URL
     *
     * @param string $url
     *
     * @return string
     */
    protected function stripDoubleSlashes(string $url): string
    {
        preg_match('/^.+?[^\/:](?=[?\/])|$/', $url, $matches);

        return $matches[0];
    }
}
