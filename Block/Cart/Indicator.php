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
     * Check if quote exists and contains items
     */
    public function hasValidQuote(): bool
    {
        $quote = $this->session->getQuote();
        return $quote !== null && (int)$quote->getItemsCount() > 0;
    }

    /**
     * Determine whether the indicator can be rendered
     */
    public function canRender(): bool
    {
        return $this->helper->isEnable() && $this->hasValidQuote();
    }

    /**
     * Retrieve the minimum order total required to qualify for free shipping.
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
     */
    public function getFreeShippingMethodMinValue(): float
    {
        return (float)$this->helper->getCoreFreeShippingSubtotal();
    }

    /**
     * Get the current cart total safely.
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCurrentTotal(): float
    {
        $quote = $this->session->getQuote();

        if (!$quote || !$quote->getItemsCount()) {
            return 0.0;
        }

        if (!$this->helper->getOrderSubtotal()) {
            return (float)$quote->getGrandTotal();
        }

        if ($this->helper->getOrderSubtotalWithDiscount()) {
            return (float)$quote->getSubtotalWithDiscount();
        }

        return (float)$quote->getSubtotal();
    }

    /**
     * Check if the order qualifies for free shipping.
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function isOrderEligibleForFreeShipping(): bool
    {
        if (!$this->canRender()) {
            return false;
        }

        $currentTotal = $this->getCurrentTotal();

        if ($this->helper->getCoreShippingConfig()) {
            return $currentTotal >= $this->getFreeShippingMethodMinValue();
        }

        return $currentTotal >= $this->getFreeShippingMinValue();
    }

    /**
     * Format price in store currency.
     */
    public function getFormattedPrice(float $price, int $precision = 2): string
    {
        return $this->priceCurrency->format($price, false, $precision);
    }

    /**
     * Remaining amount to reach free shipping.
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getFreeShippingAmountDifference(): float
    {
        $difference = $this->getFreeShippingMinValue() - $this->getCurrentTotal();
        return max(0.0, $difference);
    }

    /**
     * Progress percentage toward free shipping.
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getFreeShippingCompletionRate(): float
    {
        $minValue = $this->getFreeShippingMinValue();

        if ($minValue <= 0 || !$this->hasValidQuote()) {
            return 0.0;
        }

        $rate = ($this->getCurrentTotal() / $minValue) * 100;
        return min(100.0, $rate);
    }

    /**
     * Module enable check.
     */
    public function isModuleEnable(): bool
    {
        return $this->helper->isEnable();
    }

    public function getFontSize(): string
    {
        return $this->helper->getFontSize() ?: '14';
    }

    public function getTextMessage(): string
    {
        return $this->helper->getTextMessage() ?: 'To get FREE SHIPPING, add ';
    }

    public function getMessageBackground(): string
    {
        return $this->helper->getMessageBackground() ?: '#ff5501';
    }

    public function getProgressBarColor(): string
    {
        return $this->helper->getProgressBarColor() ?: 'red';
    }

    public function getCustomCSS(): string
    {
        return $this->helper->getCustomCSS() ?: '';
    }

    public function getMessageTextColor(): string
    {
        return $this->helper->getMessageTextColor() ?: 'red';
    }

    public function getEligibleTextMessage(): string
    {
        return $this->helper->getEligibleTextMessage()
            ?: 'Your order is eligible for FREE SHIPPING.';
    }
}
