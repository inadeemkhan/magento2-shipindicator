<?php
declare(strict_types=1);

namespace NadeemSoft\ShipIndicator\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Typed access to the module and core free shipping configuration.
 */
class Data extends AbstractHelper
{
    private const CORE_PATH = 'carriers/freeshipping/';
    private const GENERAL_PATH = 'ship_indicator/general/';
    private const CUSTOM_PATH = 'ship_indicator/customization/';

    /**
     * Read a config value in store scope.
     */
    private function getConfig(string $path): mixed
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    private function getFlag(string $path): bool
    {
        return $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE);
    }

    private function getString(string $path): string
    {
        return trim((string)$this->getConfig($path));
    }

    public function isEnable(): bool
    {
        return $this->getFlag(self::GENERAL_PATH . 'is_enable');
    }

    public function useCoreConfig(): bool
    {
        return $this->getFlag(self::GENERAL_PATH . 'use_core_freeshipping_config');
    }

    /**
     * Minimum amount (base currency) for the custom threshold.
     */
    public function getOrderMinTotal(): float
    {
        return (float)$this->getConfig(self::GENERAL_PATH . 'order_min_total');
    }

    public function includeTax(): bool
    {
        return $this->getFlag(self::GENERAL_PATH . 'include_tax');
    }

    public function includeDiscount(): bool
    {
        return $this->getFlag(self::GENERAL_PATH . 'order_subtotal_includes_discount');
    }

    public function isCoreFreeShippingActive(): bool
    {
        return $this->getFlag(self::CORE_PATH . 'active');
    }

    /**
     * Core free shipping threshold (base currency).
     */
    public function getCoreFreeShippingSubtotal(): float
    {
        return (float)$this->getConfig(self::CORE_PATH . 'free_shipping_subtotal');
    }

    /**
     * Core "Include Tax to Amount" flag.
     */
    public function coreIncludesTax(): bool
    {
        return $this->getFlag(self::CORE_PATH . 'tax_including');
    }

    public function getFontSize(): string
    {
        return $this->getString(self::CUSTOM_PATH . 'font_size');
    }

    public function getTextMessage(): string
    {
        return $this->getString(self::CUSTOM_PATH . 'text_message');
    }

    public function getMessageTextColor(): string
    {
        return $this->getString(self::CUSTOM_PATH . 'message_text_color');
    }

    public function getMessageBackground(): string
    {
        return $this->getString(self::CUSTOM_PATH . 'message_background');
    }

    public function getProgressBarColor(): string
    {
        return $this->getString(self::CUSTOM_PATH . 'progress_bar_color');
    }

    public function getEligibleTextMessage(): string
    {
        return $this->getString(self::CUSTOM_PATH . 'eligible_text_message');
    }

    public function getCustomCSS(): string
    {
        return $this->getString(self::CUSTOM_PATH . 'custom_css');
    }
}
