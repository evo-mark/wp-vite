<p align="center">
    <a href="https://evomark.co.uk" target="_blank" alt="Link to evoMark's website">
        <picture>
          <source media="(prefers-color-scheme: dark)" srcset="https://evomark.co.uk/wp-content/uploads/static/evomark-logo--dark.svg">
          <source media="(prefers-color-scheme: light)" srcset="https://evomark.co.uk/wp-content/uploads/static/evomark-logo--light.svg">
          <img alt="evoMark company logo" src="https://evomark.co.uk/wp-content/uploads/static/evomark-logo--light.svg" width="500">
        </picture>
    </a>
</p>


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


    use EvoMark\WpVite\WpVite;

    $vite = new WpVite;
    $vite->enqueue([
        'namespace' => 'theme-vite',
        'input' => ["src/main.js"],
    ]);


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

No. This plugin currently does not support usage in the development of block libraries. For that, we recommend [Vite Plugin Gutenberg Blocks](https://github.com/evo-mark/vite-plugin-gutenberg-blocks).
