# Magento 2 Extension — Free Shipping Indicator

![Magento](https://img.shields.io/badge/Magento-2.4.x-orange?logo=magento)  ![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue?logo=php) ![Contributions](https://img.shields.io/badge/Contributions-Welcome-brightgreen)
  
##### This Magento 2 extension provides a clear visual indicator on the cart page, informing customers how close they are to qualifying for free shipping. It enhances the overall shopping experience and helps encourage higher cart values.
---

## Features

- Progress bar and message on the cart page and in the minicart showing how much more is needed for free shipping.
- Use Magento's core Free Shipping method settings, or define your own minimum amount.
- Tax-aware: optionally compare the amount including tax.
- Optionally subtract discounts; cart price rules with free shipping are respected.
- Multi-currency safe: thresholds are compared in base currency and shown in the display currency.
- Customizable message, eligible message, font size, colors and custom CSS.
- Accessible progress bar (`role="progressbar"`).

---

## Configuration

Go to **Stores > Configuration > NadeemSoft > Free Shipping Indicator**.

| Setting | Description |
|---------|-------------|
| Enable | Show the indicator. |
| Use Core Free Shipping Method Config | Use the threshold, "active" flag and **Include Tax to Amount** from `Stores > Configuration > Sales > Delivery Methods > Free Shipping`. |
| Order Minimum Total | Custom threshold (base currency), used when core config is off. |
| Include Tax in Amount | Compare the amount including tax. Turn this on if your store shows the cart subtotal including tax. |
| Subtract Discounts | Subtract discounts before comparing (default: Yes). |

The shipping cost is never part of the compared amount.

---

## Changelog

### 1.1.0

**Bug fix: subtotal / tax / shipping mismatch**

Reported issue: *"I have subtotal including tax. Subtotal is calculated without tax and grand total is calculated with shipping cost."*

- The indicator used the subtotal **excluding tax**, so it did not match a cart that displays the subtotal including tax.
- The "grand total" option included the **shipping cost** in the compared amount. Once shipping was estimated, the amount was inflated, and when free shipping applied and shipping dropped to 0 the indicator flipped back.
- Fix:
  - Removed the "Use Subtotal" (grand total) option; shipping is never counted.
  - Added **Include Tax in Amount**. In core mode, Magento's own **Include Tax to Amount** setting is followed.
  - The amount is now calculated the same way as core's Free Shipping method (base subtotal with discount, plus tax when enabled).
  - The message shows "(incl. tax)" when tax is included.

**Other changes**

- Comparison done in base currency and converted for display (fixes multi-currency stores).
- Hidden for virtual-only carts and when the core Free Shipping method is disabled (core mode).
- Cart price rules granting free shipping now mark the order as eligible.
- Security: all template output is escaped, colors and font size are validated, custom CSS cannot break out of its `<style>` tag, color picker values are JS-escaped.
- Refactored helper and block, defaults moved to `config.xml`, `composer.json` requirements added.

### 1.0.0

- Initial release.

**Upgrading:** run `bin/magento setup:upgrade` and `bin/magento cache:flush`, then review **Include Tax in Amount** in the configuration.

---

## Installation  

1. Copy the contents of this repository into:  
   ```bash
   {MAGENTO_ROOT}/app/code/NadeemSoft/ShipIndicator/
   ```
2. Run the following commands in your Magento root directory:  
   ```bash
   php bin/magento setup:upgrade
   php bin/magento setup:static-content:deploy
   php bin/magento cache:flush
   ```
---

## Screenshots  

**Cart Page Indicator**  
![Cart Page](https://github.com/inadeemkhan/magento2-images/blob/master/Free_Shipping_Indicator/new-cart-page.png) 

**Configuration Settings**  
![Configuration](https://github.com/inadeemkhan/magento2-images/blob/master/Free_Shipping_Indicator/new-configuration.png)  

---

## Prerequisites  

Ensure the following requirements are met before installing this extension:

| Prerequisite | How to Check | Documentation |
|--------------|--------------|---------------|
| Apache / Nginx | `apache2 -v` (Ubuntu)<br><br>`nginx -v` | [Apache Docs](https://devdocs.magento.com/guides/v2.2/install-gde/prereq/apache.html) <br> [Nginx Docs](https://docs.nginx.com/nginx/admin-guide/installing-nginx/installing-nginx-open-source/)|
| PHP >= 8.1 | `php -v` | [PHP on Ubuntu](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/php-ubuntu.html)<br>[PHP on CentOS](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/php-centos.html) |
| MySQL 8.0 / MariaDB 10.6+ | `mysql -u [root username] -p` | [MySQL Docs](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/mysql.html) |

---

## Contribution  

Contributions are welcome!  
The fastest way to contribute is by submitting a [pull request](https://help.github.com/articles/about-pull-requests/) on GitHub.  

---

## Issues & Support  

If you encounter any issues or bugs, please [open an issue](https://github.com/inadeemkhan/magento2-free-shippiing-indicator/issues) on GitHub.  

For direct support or feedback, feel free to contact:  
📧 [khannadeem243@gmail.com](mailto:khannadeem243@gmail.com)  

## 👨‍💻 Author

<p align="center">
  <img src="https://github.com/inadeemkhan.png" alt="Nadeem Khan" width="100" style="border-radius: 50%;"/>
  <br>
  <b>Nadeem Khan</b><br>
  🌐 <a href="https://inadeemkhan.github.io">Portfolio</a> | 📧 <a href="mailto:khannadeem243@gmail.com">khannadeem243@gmail.com</a>
</p>

<p align="center">
  <a href="https://github.com/inadeemkhan">
    <img src="https://img.shields.io/github/followers/inadeemkhan?style=social" alt="GitHub Follow"/>
  </a>
  <a href="https://github.com/inadeemkhan/magento2-shipindicator/stargazers">
    <img src="https://img.shields.io/github/stars/inadeemkhan/magento2-shipindicator?style=social" alt="GitHub Stars"/>
  </a>
  <a href="https://inadeemkhan.github.io">
    <img src="https://img.shields.io/badge/Portfolio-Visit-blue" alt="Portfolio"/>
  </a>
</p>
