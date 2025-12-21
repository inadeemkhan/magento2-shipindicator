<?php
declare(strict_types=1);

namespace NadeemSoft\ShipIndicator\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Helper class for NadeemSoft_ShipIndicator module.
 *
 * Provides access to system configuration values related to
 * free shipping indicator logic and customization.
 */
class Data extends AbstractHelper
{
    /**
     * Path to Magento core free shipping configuration.
     */
    protected const CORE_FREE_SHIPPING_STORE_CONFIG_PATH = 'carriers/freeshipping/';

    /**
     * Path to module general configuration.
     */
    protected const FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH = 'ship_indicator/general/';

    /**
     * Path to module customization configuration.
     */
    protected const INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH = 'ship_indicator/customization/';

    /**
     * Scope configuration instance.
     *
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * Data constructor.
     *
     * @param Context $context Magento helper context
     * @param ScopeConfigInterface $scopeConfig Scope configuration interface
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Check if the Free Shipping Indicator module is enabled.
     *
     * @return bool
     */
    public function isEnable(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'is_enable',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if Magento core free shipping configuration should be used.
     *
     * @return bool
     */
    public function getCoreShippingConfig(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'use_core_freeshipping_config',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get minimum order total required for free shipping (custom config).
     *
     * @return float
     */
    public function getOrderMinTotal(): float
    {
        return (float)$this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'order_min_total',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if subtotal should be used instead of grand total.
     *
     * @return bool
     */
    public function getOrderSubtotal(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'use_order_subtotal',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if subtotal should include discounts.
     *
     * @return bool
     */
    public function getOrderSubtotalWithDiscount(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::FREE_SHIPPING_INDICATOR_XML_CONFIG_PATH . 'order_subtotal_includes_discount',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get minimum subtotal required for free shipping from Magento core config.
     *
     * @return float
     */
    public function getCoreFreeShippingSubtotal(): float
    {
        return (float)$this->scopeConfig->getValue(
            self::CORE_FREE_SHIPPING_STORE_CONFIG_PATH . 'free_shipping_subtotal',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get configured font size for indicator message.
     *
     * @return string|null
     */
    public function getFontSize(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'font_size',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get custom text message displayed when free shipping is not yet achieved.
     *
     * @return string|null
     */
    public function getTextMessage(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'text_message',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get text color for indicator message.
     *
     * @return string|null
     */
    public function getMessageTextColor(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'message_text_color',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get background color for indicator message.
     *
     * @return string|null
     */
    public function getMessageBackground(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'message_background',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get progress bar color.
     *
     * @return string|null
     */
    public function getProgressBarColor(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'progress_bar_color',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get message displayed when order is eligible for free shipping.
     *
     * @return string|null
     */
    public function getEligibleTextMessage(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'eligible_text_message',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get custom CSS styles for indicator block.
     *
     * @return string|null
     */
    public function getCustomCSS(): ?string
    {
        return $this->scopeConfig->getValue(
            self::INDICATOR_CUSTOMIZATION_XML_CONFIG_PATH . 'custom_css',
            ScopeInterface::SCOPE_STORE
        );
    }
}