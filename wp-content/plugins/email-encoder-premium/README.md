# Email Address Encoder ✪

A lightweight plugin that protects plain email addresses and mailto links from smart, email-harvesting robots.

## Information

Requires at least: 2.0  
Tested up to: 5.0  
Requires PHP: 5.4

## Installation

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Deactivate or uninstall the free version of *Email Address Encoder*.
2. Upload the `/email-encoder-premium/` directory and its contents to `/wp-content/plugins/`.
3. Login to your WordPress installation and activate the plugin through the _Plugins_ menu.
4. Go to _Settings -> Email Encoder_ and enter your license key.
5. Use the "Page Scanner" to ensure all your email addresses are protected.

### Installing via Composer

_Composer access is restricted to customers on the **Unlimited** plan._

Instead of downloading ZIP files, you may also install this plugin using [Composer](https://getcomposer.org/). To get started, add the Email Address Encoder repository to your `composer.json` file:

```json
"repositories": [
    {
        "type": "composer",
        "url": "https://:YOUR-LICENSE-KEY@encoder.till.im"
    }
]
```

Be sure to replace `YOUR-LICENSE-KEY` with... you guessed it, your license key.

After that you can install the plugin just like any other Composer package:

```
composer require tillkruss/email-encoder-premium
```

If you don't wish to include your license key in your `composer.json` file, you can use Composer's [`auth.json`](https://getcomposer.org/doc/articles/http-basic-authentication.md) file, or it's [`COMPOSER_AUTH`](https://getcomposer.org/doc/03-cli.md#composer-auth) environment variable.

## Frequently Asked Questions

### How can I make sure the plugin works?

You can use the "Page Scanner" found under _Settings -> Email Encoder_ to see whether all your email addresses are protected. Alternatively, you can manually look at the "page source" of your site.

**Please note:** Chrome’s Developer Tools, Safari’s Web Inspector and others automatically decode decimal and hexadecimal entities. You need to look at the "plain HTML source code".

## Changelog

#### 0.1.7

- Fixed PHP 7.3 issue
- Changed CSS Direction technique to be selectable
- Automatically deactivate free plugin upon activation
- Show warning when running on PHP 5.3 or lesser
- Block automatic warnings for `.local` domains

#### 0.1.6

- Added signup for automatic warnings
- Encode emails in Jetpack’s Open Graph tags
- Avoid more false-positive email matches
- Avoid parse error when using PHP 5.3

#### 0.1.5

- Removed page scanner notice from dashboard

#### 0.1.4

- Fixed false-positive matching of retina images

#### 0.1.3

- Revalidate non-active license keys when saving settings

#### 0.1.2

- Added hex encoding for `mailto:` links
- Added plugin icon to updates list

#### 0.1.1

- Added prefix to placeholders
- Added better exception handling
- Restored parser error messages
- Fixed comment obfuscation
- Fixed errors when using PHP 5.5 or lower

#### 0.1.0

- Initial release
