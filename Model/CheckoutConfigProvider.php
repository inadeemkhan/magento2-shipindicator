<?php
namespace NadeemSoft\ShipIndicator\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class CheckoutConfigProvider implements ConfigProviderInterface
{
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfig() {
        $storeScope = ScopeInterface::SCOPE_STORE;
        $isEnabled = $this->scopeConfig->getValue('ship_indicator/general/is_enable', $storeScope);
        
        if (!$isEnabled) {
            return ['shipIndicator' => ['enabled' => false]];
        }

        // Logic for Threshold
        $useCore = $this->scopeConfig->getValue('ship_indicator/general/use_core_freeshipping_config', $storeScope);
        $threshold = $useCore 
            ? $this->scopeConfig->getValue('carriers/freeshipping/free_shipping_subtotal', $storeScope)
            : $this->scopeConfig->getValue('ship_indicator/general/order_min_total', $storeScope);

        return [
            'shipIndicator' => [
                'enabled'          => true,
                'threshold'        => (float)$threshold,
                'useSubtotal'      => $this->scopeConfig->getValue('ship_indicator/general/use_order_subtotal', $storeScope),
                'includeDiscount'  => $this->scopeConfig->getValue('ship_indicator/general/order_subtotal_includes_discount', $storeScope),
                'msgText'          => $this->scopeConfig->getValue('ship_indicator/customization/text_message', $storeScope),
                'successMsg'       => $this->scopeConfig->getValue('ship_indicator/customization/eligible_text_message', $storeScope),
                'fontSize'         => $this->scopeConfig->getValue('ship_indicator/customization/font_size', $storeScope),
                'textColor'        => $this->scopeConfig->getValue('ship_indicator/customization/message_text_color', $storeScope) ?: '#ffffff',
                'bgColor'          => $this->scopeConfig->getValue('ship_indicator/customization/message_background', $storeScope) ?: '#ff5501',
                'barColor'         => $this->scopeConfig->getValue('ship_indicator/customization/progress_bar_color', $storeScope) ?: '#00a651',
                'customCss'        => $this->scopeConfig->getValue('ship_indicator/customization/custom_css', $storeScope)
            ]
        ];
    }
}