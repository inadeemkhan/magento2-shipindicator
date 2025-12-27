<?php
declare(strict_types=1);

namespace NadeemSoft\ShipIndicator\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected const CORE_FREE_SHIPPING_STORE_CONFIG_PATH = 'carriers/freeshipping/';
    protected const FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH = 'ship_indicator/general/';
    protected const INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH = 'ship_indicator/customization/';

    /**
     * Check if the Free Shipping Indicator module is enabled.
     */
    public function isEnable(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'is_enable',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCoreShippingConfig(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'use_core_freeshipping_config',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getOrderMinTotal(): float
    {
        return (float) $this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'order_min_total',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getOrderSubtotal(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'use_order_subtotal',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getOrderSubtotalWithDiscount(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'order_subtotal_includes_discount',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCoreFreeShippingSubtotal(): float
    {
        return (float) $this->scopeConfig->getValue(
            self::CORE_FREE_SHIPPING_STORE_CONFIG_PATH . 'free_shipping_subtotal',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getFontSize(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'font_size',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getTextMessage(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'text_message',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getMessageTextColor(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'message_text_color',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getMessageBackground(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'message_background',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getProgressBarColor(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'progress_bar_color',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getEligibleTextMessage(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'eligible_text_message',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCustomCSS(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'custom_css',
            ScopeInterface::SCOPE_STORE
        );
    }
}
  