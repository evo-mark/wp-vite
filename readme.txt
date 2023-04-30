=== WP Vite ===
Tags: wordpress, vite, esbuild, development, production, build
Requires at least: 6.0
Tested up to: 6.2
Requires PHP: 8.2
License: MIT
License URI: https://mit-license.org/

Bring Vite's lightning fast build process to your Wordpress theme or plugin

== Description ==

= Usage =

Inside your plugin entry file or function.php file (for themes) simply include the following:

```php
use Southcoastweb\WpVite\WpVite;

WpVite::enqueue([
    'namespace' => 'theme-vite',
    'input' => ["src/main.js"],
]);
```

The enqueue function takes a single associative array as a parameter. Here are the properties it can contain:

1. namespace: string **Required**
-  A unique namespace for the manifest being enqueued
2. input: string | string[] **Required**
-  One or more entry files. These must match exactly the ones defined in your Vite config file
3. dependencies: string[]
-  Wordpress JS dependencies for your manifest. In production, these will be mapped to the window object
4. admin: bool
-  Enqueue the inputs for Wordpress admin pages instead of frontend

== Frequently Asked Questions ==

= Does this work with Gutenberg block development? =

No. This plugin currently does not support usage in the development of block libraries. For that, we recommend [Vite Plugin Gutenberg Blocks](https://github.com/southcoastweb/vite-plugin-gutenberg-blocks).

== Screenshots ==

![Screenshot](/assets/screenshot-1.png)
1. Using Vite with Wordpress

== Changelog ==

= 0.2.4 =

- Readme fixes for params

= 0.2.3 =

- Added version to entry file
- Attempt fix for param table

= 0.2.2 =

- Screenshot added to assets
- Updated readme file

= 0.2.1 =

- Added 'admin' param for loading scripts on admin pages

= 0.2.0 =

- Added version cache-busting to both scripts and styles

= 0.1.0 =

- Initial release
