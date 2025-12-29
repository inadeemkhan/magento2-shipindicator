# Magento 2 Extension — Free Shipping Indicator

![Magento](https://img.shields.io/badge/Magento-2.x-orange?logo=magento)  ![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php) ![Contributions](https://img.shields.io/badge/Contributions-Welcome-brightgreen)  
  
##### This Magento 2 extension provides a clear visual indicator on the cart page, informing customers how close they are to qualifying for free shipping. It enhances the overall shopping experience and helps encourage higher cart values.
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

**Minicart Indicator**  
![Cart Page](https://github.com/inadeemkhan/magento2-images/blob/master/Free_Shipping_Indicator/new-minicart.png) 

**Configuration Settings**  
![Configuration](https://github.com/inadeemkhan/magento2-images/blob/master/Free_Shipping_Indicator/new-configuration.png)  

---

## Prerequisites  

Ensure the following requirements are met before installing this extension:

| Prerequisite | How to Check | Documentation |
|--------------|--------------|---------------|
| Apache 2.4 / Nginx | `apache2 -v` (Ubuntu)<br>`httpd -v` (CentOS) <br>`nginx -v` | [Apache Docs](https://devdocs.magento.com/guides/v2.2/install-gde/prereq/apache.html) <br> [NGINX Docs](https://docs.nginx.com/nginx/admin-guide/installing-nginx/installing-nginx-open-source/)|
| PHP >= 8.1 | `php -v` | [PHP on Ubuntu](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/php-ubuntu.html)<br>[PHP on CentOS](http://devdocs.magento.com/guides/v2.2/install-gde/prereq/php-centos.html) |
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
