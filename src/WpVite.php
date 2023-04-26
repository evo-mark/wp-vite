<?php

namespace Southcoastweb\WordpressVite;

class WpVite
{
    public static $vite;
    public static $uploadsPath;
    public static $uploadsUrl;

    public static function run()
    {
        self::$uploadsPath  = wp_upload_dir()['basedir'] . '/' . 'scw-vite-hmr/theme-vite';
        self::$uploadsUrl  = wp_upload_dir()['baseurl'] . '/' . 'scw-vite-hmr/theme-vite';

        if (!file_exists(self::$uploadsPath)) wp_mkdir_p(self::$uploadsPath);
    }

    public static function getVite(): Vite
    {
        return self::$vite;
    }

    public static function make($args = [])
    {
        self::$vite = new Vite([
            'uploadsPath' => self::$uploadsPath,
            'uploadsUrl' => self::$uploadsUrl,
            'hotFile' => $args['hotFile'] ?? 'hot'
        ]);

        add_action('wp_head', function () {
            echo self::$vite->generateTags('src/main.js', 'build');
            echo self::$vite->generateTags('src/test.js', 'build');
        });
    }
}
