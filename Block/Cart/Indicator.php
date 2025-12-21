<?php
declare(strict_types=1);

namespace NadeemSoft\ShipIndicator\Block\Cart;

use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use NadeemSoft\ShipIndicator\Helper\Data;

class Indicator extends Template
{
    /**
     * @var Session
     */
    protected Session $session;

    /**
     * @var PriceCurrencyInterface
     */
    protected PriceCurrencyInterface $priceCurrency;

    /**
     * @var Data
     */
    protected Data $helper;

    /**
     * Indicator constructor.
     *
     * @param Context $context Rendering context for the block
     * @param Session $session Checkout session instance
     * @param PriceCurrencyInterface $priceCurrency Currency formatter
     * @param Data $helper Module helper instance
     * @param array $data Additional block data
     */
    public function __construct(
        Context $context,
        Session $session,
        PriceCurrencyInterface $priceCurrency,
        Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->session = $session;
        $this->priceCurrency = $priceCurrency;
        $this->helper = $helper;
    }

    /**
     * Retrieve the minimum order total required to qualify for free shipping.
     * 
     * This value is determined either by the configured free shipping method
     * or by the custom module configuration, depending on settings.
     *
     * @return float Minimum order total threshold
     */
    public function getFreeShippingMinValue(): float
    {
        if ($this->helper->isEnable() && $this->helper->getCoreShippingConfig()) {
            return (float)$this->getFreeShippingMethodMinValue();
        }
        return (float)$this->helper->getOrderMinTotal();
    }

    /**
     * Retrieve the minimum subtotal configured in Magento's core free shipping method.
     *
     * @return float Configured free shipping subtotal
     */
    public function getFreeShippingMethodMinValue(): float
    {
        return (float)$this->helper->getCoreFreeShippingSubtotal();
    }

    /**
     * Get the current cart total based on configuration.
     * 
     * Depending on helper settings, this may return:
     * - Grand total
     * - Subtotal with discount
     * - Subtotal without discount
     *
     * @return float Current cart total
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCurrentTotal(): float
    {
        $quote = $this->session->getQuote();

        if (!$this->helper->getOrderSubtotal()) {
            return (float)$quote->getGrandTotal();
        }

        if ($this->helper->getOrderSubtotalWithDiscount()) {
            return (float)$quote->getSubtotalWithDiscount();
        }

        return (float)$quote->getSubtotal();
    }

    /**
     * Check if the current cart/order total qualifies for free shipping.
     * 
     * This method validates module enablement and compares the current cart total
     * against the configured free shipping threshold.
     *
     * @return bool True if eligible, false otherwise
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function isOrderEligibleForFreeShipping(): bool
    {
        if (!$this->helper->isEnable()) {
            return false;
        }

        $currentTotal = $this->getCurrentTotal();

        if ($this->helper->getCoreShippingConfig()) {
            return $currentTotal >= $this->getFreeShippingMethodMinValue();
        }

        return $currentTotal >= $this->getFreeShippingMinValue();
    }

    /**
     * Format a price value into the store currency.
     *
     * @param float $price Price to format
     * @param int $precision Decimal precision
     * @return string Formatted price string
     */
    public function getFormattedPrice(float $price, int $precision = 2): string
    {
        return $this->priceCurrency->format($price, false, $precision);
    }

    /**
     * Calculate the remaining amount required to reach free shipping eligibility.
     *
     * @return float Difference between threshold and current total
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getFreeShippingAmountDifference(): float
    {
        return $this->getFreeShippingMinValue() - $this->getCurrentTotal();
    }

    /**
     * Calculate the percentage progress towards free shipping eligibility.
     *
     * @return float Completion rate percentage (0–100)
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getFreeShippingCompletionRate(): float
    {
        $minValue = $this->getFreeShippingMinValue();
        return $minValue > 0 ? ($this->getCurrentTotal() / $minValue) * 100 : 0.0;
    }

    /**
     * Check if the module is enabled in configuration.
     *
     * @return bool Module enablement status
     */
    public function isModuleEnable(): bool
    {
        return $this->helper->isEnable();
    }

    /**
     * Retrieve the configured font size for the indicator message.
     *
     * @return string Font size value
     */
    public function getFontSize(): string
    {
        return $this->helper->getFontSize() ?: "14";
    }

    /**
     * Retrieve the configured text message displayed when free shipping is not yet achieved.
     *
     * @return string Custom or default message
     */
    public function getTextMessage(): string
    {
        return $this->helper->getTextMessage() ?: "To get FREE SHIPPING, add ";
    }

    /**
     * Retrieve the background color for the indicator message.
     *
     * @return string Hex color code or default
     */
    public function getMessageBackground(): string
    {
        return $this->helper->getMessageBackground() ?: "#ff5501";
    }

    /**
     * Retrieve the progress bar color used in the indicator.
     *
     * @return string Color value
     */
    public function getProgressBarColor(): string
    {
        return $this->helper->getProgressBarColor() ?: "red";
    }

    /**
     * Retrieve any custom CSS applied to the indicator block.
     *
     * @return string CSS string
     */
    public function getCustomCSS(): string
    {
        return $this->helper->getCustomCSS() ?: "";
    }

    /**
     * Retrieve the text color for the indicator message.
     *
     * @return string Color value
     */
    public function getMessageTextColor(): string
    {
        return $this->helper->getMessageTextColor() ?: "red";
    }

    /**
     * Retrieve the message displayed when the order is eligible for free shipping.
     *
     * @return string Custom or default eligible message
     */
    public function getEligibleTextMessage(): string
    {
        return $this->helper->getEligibleTextMessage() ?: "Your order is eligible for FREE SHIPPING.";
    }
}