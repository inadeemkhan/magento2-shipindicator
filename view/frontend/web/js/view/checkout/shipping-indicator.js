define([
    'uiComponent',
    'Magento_Checkout/js/model/totals',
    'ko',
    'Magento_Catalog/js/price-utils'
], function (Component, totals, ko, priceUtils) {
    'use strict';

    const config = window.checkoutConfig.shipIndicator;

    return Component.extend({
        defaults: { template: 'NadeemSoft_ShipIndicator/checkout/shipping-indicator' },
        config: config,
        threshold: config.threshold,

        isVisible: function() { return config.enabled; },

        getCurrentTotal: function () {
            var segments = totals.totals();
            if (!segments) return 0;

            if (config.useSubtotal == 1) {
                var val = parseFloat(segments.subtotal);
                // If subtotal should include discount (meaning subtotal - discount)
                if (config.includeDiscount == 1 && segments.discount_amount) {
                    val += parseFloat(segments.discount_amount); // discount_amount is usually negative
                }
                return val;
            }
            return parseFloat(segments.grand_total);
        },

        isFreeShipping: function () { return this.getCurrentTotal() >= this.threshold; },

        getRemainingAmount: function () {
            var remaining = this.threshold - this.getCurrentTotal();
            return priceUtils.formatPrice(remaining > 0 ? remaining : 0, window.checkoutConfig.priceFormat);
        },

        getBarWidth: function () {
            var percent = (this.getCurrentTotal() / this.threshold) * 100;
            return (percent > 100 ? 100 : (percent < 0 ? 0 : percent)) + '%';
        }
    });
});