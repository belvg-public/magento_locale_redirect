Magento locale redirect
=======================

Magento extension for redirecting users to the store according to the client's Accept Language header.
If shop does not support any language from the browser's list — show default store language.

-----
- version: 1.0.0

Requirements
------------
- PHP >= 5.2.0

Compatibility
-------------
- Magento >= 1.4

Installation Instructions
-------------------------

**Download**

Copy folder "app" into the root directory of your Magento installation.

**Modman**

Install modman Module Manager: https://github.com/colinmollenhour/modman
After having installed modman on your system, you can clone this module on your
Magento base directory by typing the following command:

    $ modman init
    $ modman clone git@github.com:belvg-public/magento_locale_redirect.git

**Composer**

Install composer: http://getcomposer.org/download/

Install Magento Composer: https://github.com/magento-hackathon/magento-composer-installer

Add the dependency to your `composer.json`:

    {
      ...
      "require": {
        ...
        "belvg-public/magento_locale_redirect": "dev-master",
        ...
      },
      "repositories": [
        ...
        {
          "type": "vcs",
          "url":  "git@github.com:belvg-public/magento_locale_redirect.git"
        },
        ...
      ],
      ...
      "extra": {
        "magento-root-dir": "<magento_installation_dir>/"
      }
      ...
    }

Then run the following command from the directory where your `composer.json`
file is contained:

    $ php composer.phar update belvg-public/magento_locale_redirect

or

    $ composer update belvg-public/magento_locale_redirect


Developer
---------
Pavel Novitsky <pavel@belvg.com>

@pavelnovitsky
