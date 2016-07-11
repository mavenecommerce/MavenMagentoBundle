MavenMagentoBundle [![Build Status](https://travis-ci.org/mavenecommerce/MavenMagentoBundle.svg)](https://travis-ci.org/mavenecommerce/MavenMagentoBundle)
=======

This bundle provide extended functional for OroCRMMagentoBundle.

At now provided:
  1. Creating shipment from Oro admin. User can put different value of the qty for order items, but not bigger that value qty in order.
  2. Send shipment with delivered service api:
  -   FedEx
  3. Sync sent shipment with magento

Installation
=======

Add this repository to repositories section in your composer.json file:
```JSON
    "repositories" : [
        {
            "url": "https://github.com/mavenecommerce/MavenMagentoBundle",
            "type": "git"
        }
    ]
```
Then run in cmd next:
```
    php composer require mavenecommerce/magento-bundle
```

Create database dump. In symfony console run command for load migrations:

```
    app/console o:m:l --force
```
Or
```
    app/console oro:migration:load  --force
```

After this actions you can use this bundle but before you must configure setup integration oro with magento(see : [Manual](https://www.orocrm.com/documentation/index/current/user-guide/magento-channel-integration "Manual"))


