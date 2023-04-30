<?php

namespace Southcoastweb\WpVite;

class WpVite
{
    public static $type;
    public static $vite;
    public static $uploadsPath;
    public static $uploadsUrl;

    public static function run()
    {
        self::$uploadsPath  = wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'scw-vite-hmr';
        self::$uploadsUrl  = wp_upload_dir()['baseurl'] . '/' . 'scw-vite-hmr';

        if (!file_exists(self::$uploadsPath)) wp_mkdir_p(self::$uploadsPath);

        self::setupFilters();
    }

    public static function getVite(): ViteAdapter
    {
        return self::$vite;
    }

    public static function enqueue($args = [])
    {
        $uploadsPath = self::$uploadsPath . DIRECTORY_SEPARATOR  . $args['namespace'];
        $uploadsUrl = self::$uploadsUrl . "/" . $args['namespace'];
        $buildDirectory = $args['buildDirectory'] ?? 'build';

        if (!file_exists($uploadsPath)) {
            throw new \Exception("Directory \"" . $uploadsPath . "\" could not be found");
        }

        self::validateArgs($args);


        self::$vite = new ViteAdapter([
            'uploadsPath' => $uploadsPath,
            'uploadsUrl' => $uploadsUrl,
            'hotFile' => $args['hotFile'] ?? 'hot',
            'dependencies' => $args['dependencies'] ?? []
        ]);

        $hook = isset($args['admin']) && $args['admin'] === true ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';

        add_action($hook, function () use ($buildDirectory, $args) {
            $inputs = is_array($args['input']) ? $args['input'] : (array) $args['input'];
            if (count($inputs) === 0) {
                throw new \Exception("No valid input files received");
            }
            foreach ($inputs as $input) {
                echo self::$vite->generateTags($input, $buildDirectory);
            }
        });
    }

    public static function validateArgs(array $args): bool
    {
        if (!isset($args['input'])) {
            throw new \Exception("No 'input' found");
        } else if (!isset($args['namespace']) || empty($args['namespace'])) {
            throw new \Exception("No 'namespace' found");
        }
        return true;
    }

    public static function setupFilters(): void
    {
        add_filter('script_loader_tag', [__CLASS__, 'addScriptAttributes'], 10, 2);
    }

    /**
     * Remove deprecated script/link attributes and add attributes from registered sources
     *
     * @filter script_loader_tag
     */
    public static function addScriptAttributes(string $tag, string $handle): string
    {
        $attributes = ['type', 'async', 'crossorigin', 'defer', 'fetchpriority', 'integrity', 'nomodule', 'nonce', 'referrerpolicy', 'blocking'];
        $tag = preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
        foreach ($attributes as $attribute) {
            $data = wp_scripts()->get_data($handle, $attribute);
            if (!empty($data)) {
                $tag = str_replace('src', $attribute . '="' . esc_attr($data) . '" src', $tag);
            }
        }

        return $tag;
    }
}
