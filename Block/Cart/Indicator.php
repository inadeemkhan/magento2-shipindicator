<?php
declare(strict_types=1);

namespace NadeemSoft\ShipIndicator\Block\Cart;

use Magento\Checkout\Model\Session;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Quote\Model\Quote;
use NadeemSoft\ShipIndicator\Helper\Data;

/**
 * Free shipping progress indicator.
 *
 * All comparisons are done in BASE currency (the currency the thresholds are
 * configured in) and converted only for display. Shipping cost is never part of
 * the compared amount, so the indicator cannot flip once shipping is estimated.
 */
class Indicator extends Template
{
    private ?Quote $quote = null;
    private ?float $currentAmount = null;

    public function __construct(
        Context $context,
        protected Session $session,
        protected PriceCurrencyInterface $priceCurrency,
        protected Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    private function getQuote(): Quote
    {
        return $this->quote ??= $this->session->getQuote();
    }

    /**
     * Quote must have items and need shipping (virtual-only carts have none).
     */
    public function hasValidQuote(): bool
    {
        $quote = $this->getQuote();
        return (int)$quote->getItemsCount() > 0 && !$quote->isVirtual();
    }

    public function canRender(): bool
    {
        if (!$this->helper->isEnable() || !$this->hasValidQuote()) {
            return false;
        }

        // Core method switched off: it can never give free shipping.
        return !($this->helper->useCoreConfig() && !$this->helper->isCoreFreeShippingActive());
    }

    /**
     * Threshold in base currency.
     */
    public function getFreeShippingMinValue(): float
    {
        return $this->helper->useCoreConfig()
            ? $this->helper->getCoreFreeShippingSubtotal()
            : $this->helper->getOrderMinTotal();
    }

    /**
     * Cart amount in base currency, built the same way core's free shipping
     * method builds it (see Magento\OfflineShipping\Model\Carrier\Freeshipping).
     */
    public function getCurrentTotal(): float
    {
        if ($this->currentAmount !== null) {
            return $this->currentAmount;
        }

        $quote = $this->getQuote();
        $address = $quote->getShippingAddress();

        if ($this->helper->useCoreConfig()) {
            // Core always subtracts discounts; tax only if "Include Tax to Amount".
            $withDiscount = true;
            $withTax = $this->helper->coreIncludesTax();
        } else {
            $withDiscount = $this->helper->includeDiscount();
            $withTax = $this->helper->includeTax();
        }

        if ($withDiscount) {
            $amount = (float)$address->getBaseSubtotalWithDiscount();
            if (!$amount) {
                $amount = (float)$quote->getBaseSubtotalWithDiscount();
            }
            if ($withTax) {
                $amount += (float)$address->getBaseTaxAmount();
            }
        } else {
            $amount = $withTax && $address->getBaseSubtotalTotalInclTax()
                ? (float)$address->getBaseSubtotalTotalInclTax()
                : (float)$quote->getBaseSubtotal();
        }

        return $this->currentAmount = max(0.0, $amount);
    }

    /**
     * Eligible when a cart price rule grants free shipping or the amount reaches the threshold.
     */
    public function isOrderEligibleForFreeShipping(): bool
    {
        if (!$this->canRender()) {
            return false;
        }

        if ($this->getQuote()->getShippingAddress()->getFreeShipping()) {
            return true;
        }

        return $this->getCurrentTotal() >= $this->getFreeShippingMinValue();
    }

    /**
     * Format a base-currency amount in the current display currency.
     */
    public function getFormattedPrice(float $baseAmount, int $precision = 2): string
    {
        return $this->priceCurrency->convertAndFormat($baseAmount, false, $precision);
    }

    /**
     * Remaining base-currency amount to reach free shipping.
     */
    public function getFreeShippingAmountDifference(): float
    {
        return max(0.0, $this->getFreeShippingMinValue() - $this->getCurrentTotal());
    }

    public function getFreeShippingCompletionRate(): float
    {
        $minValue = $this->getFreeShippingMinValue();

        if ($minValue <= 0 || !$this->hasValidQuote()) {
            return 0.0;
        }

        return round(min(100.0, ($this->getCurrentTotal() / $minValue) * 100), 2);
    }

    /**
     * Whether prices in the message are tax inclusive (for an optional label).
     */
    public function isTaxIncluded(): bool
    {
        return $this->helper->useCoreConfig()
            ? $this->helper->coreIncludesTax()
            : $this->helper->includeTax();
    }

    public function getFontSize(): string
    {
        $size = (int)$this->helper->getFontSize();
        return (string)($size >= 8 && $size <= 40 ? $size : 14);
    }

    public function getTextMessage(): string
    {
        return $this->helper->getTextMessage() ?: 'To get FREE SHIPPING, add';
    }

    public function getEligibleTextMessage(): string
    {
        return $this->helper->getEligibleTextMessage() ?: 'Your order is eligible for FREE SHIPPING.';
    }

    public function getMessageBackground(): string
    {
        return $this->sanitizeColor($this->helper->getMessageBackground(), '#ff5501');
    }

    public function getProgressBarColor(): string
    {
        return $this->sanitizeColor($this->helper->getProgressBarColor(), '#ff5501');
    }

    public function getMessageTextColor(): string
    {
        return $this->sanitizeColor($this->helper->getMessageTextColor(), '#ffffff');
    }

    /**
     * Admin CSS with anything able to break out of the style element removed.
     */
    public function getCustomCSS(): string
    {
        return str_replace(['<', '>'], '', $this->helper->getCustomCSS());
    }

    /**
     * Accept hex, rgb(a)/hsl(a) and named colours only; anything else falls back.
     */
    private function sanitizeColor(string $color, string $default): string
    {
        $color = trim($color);
        $valid = preg_match('/^#[0-9a-f]{3,8}$/i', $color)
            || preg_match('/^(rgb|hsl)a?\(\s*[\d.%\s,\/]+\)$/i', $color)
            || preg_match('/^[a-z]{3,20}$/i', $color);

        return $valid ? $color : $default;
    }
}
