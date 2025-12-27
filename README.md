# Magento 2 Extension — Free Shipping Indicator  

![Magento](https://img.shields.io/badge/Magento-2.x-orange?logo=magento)  
![PHP](https://img.shields.io/badge/PHP-7.x-blue?logo=php)  
![License](https://img.shields.io/badge/License-MIT-green)  
![Contributions](https://img.shields.io/badge/Contributions-Welcome-brightgreen)  

**Author:** Nadeem Khan  

This Magento 2 extension adds a visual indicator on the cart page to inform customers how close they are to qualifying for free shipping. This helps improve the shopping experience and can encourage customers to increase their cart value.  

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
![Cart Page](https://github.com/inadeemkhan/magento2-images/blob/master/Free_Shipping_Indicator/FS-1.png)  

**Configuration Settings**  
![Configuration](https://github.com/inadeemkhan/magento2-images/blob/master/Free_Shipping_Indicator/FS-2.png)  

**Customization Options**  
![Customization](https://github.com/inadeemkhan/magento2-images/blob/master/Free_Shipping_Indicator/FS-3.png)  

---

## Prerequisites  

Ensure the following requirements are met before installing this extension:  

| Prerequisite | How to Check | Documentation |
|--------------|--------------|---------------|
| Apache 2.2 / 2.4 | `apache2 -v` (Ubuntu)<br>`httpd -v` (CentOS) | [Apache Docs](https://devdocs.magento.com/guides/v2.2/install-gde/prereq/apache.html) |
| PHP 7.x.x | `php -v` | [PHP on Ubuntu](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/php-ubuntu.html)<br>[PHP on CentOS](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/php-centos.html) |
| MySQL 5.6.x | `mysql -u [root username] -p` | [MySQL Docs](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/mysql.html) |

---

## Contribution  

Contributions are welcome!  
The fastest way to contribute is by submitting a [pull request](https://help.github.com/articles/about-pull-requests/) on GitHub.  

---

## Issues & Support  

If you encounter any issues or bugs, please [open an issue](https://github.com/inadeemkhan/magento2-free-shippiing-indicator/issues) on GitHub.  

For direct support or feedback, feel free to contact:  
📧 [khannadeem243@gmail.com](mailto:khannadeem243@gmail.com)  
