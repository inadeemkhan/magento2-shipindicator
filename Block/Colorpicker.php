<?php
declare(strict_types=1);

namespace NadeemSoft\ShipIndicator\Block;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Colorpicker field renderer for system configuration.
 *
 * This block integrates a jQuery-based color picker into Magento's
 * system configuration form, allowing administrators to select and
 * preview colors directly in the backend.
 */
class Colorpicker extends Field
{
    /**
     * Render the HTML for the color picker element.
     *
     * This method appends a JavaScript-based color picker to the
     * configuration field. The selected color is applied as the
     * background of the input field and stored as its value.
     *
     * @param AbstractElement $element The configuration form element
     * @return string Rendered HTML with color picker integration
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html = $element->getElementHtml();
        $value = (string)$element->getData('value');

        $html .= '<script type="text/javascript">
            require(["jquery","jquery/colorpicker/js/colorpicker"], function ($) {
                $(document).ready(function () {
                    var thisElement = $("#' . $element->getHtmlId() . '");
                    thisElement.css("backgroundColor", "' . $value . '");
                    thisElement.ColorPicker({
                        color: "' . $value . '",
                        onChange: function (hsb, hex, rgb) {
                            thisElement.css("backgroundColor", "#" + hex).val("#" + hex);
                        }
                    });
                });
            });
        </script>';

        return $html;
    }
}