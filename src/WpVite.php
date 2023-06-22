<?php

namespace Southcoastweb\WpVite;

class WpVite
{
    public $type;
    public $vite;
    public $uploadsPath;
    public $uploadsUrl;
    public static $init = false;

    public function __construct()
    {
        $this->uploadsPath  = wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'scw-vite-hmr';
        $this->uploadsUrl  = wp_upload_dir()['baseurl'] . '/' . 'scw-vite-hmr';

        if (!file_exists($this->uploadsPath)) wp_mkdir_p($this->uploadsPath);

        $this->setupFilters();
    }

    public function getVite(): ViteAdapter
    {
        return $this->vite;
    }

    public function enqueue($args = [])
    {
        $uploadsPath = $this->uploadsPath . DIRECTORY_SEPARATOR  . $args['namespace'];
        $uploadsUrl = $this->uploadsUrl . "/" . $args['namespace'];
        $buildDirectory = $args['buildDirectory'] ?? 'build';

        $absolutePath = isset($args['absolutePath']) ? $args['absolutePath'] : null;
        $absoluteUrl = isset($args['absoluteUrl']) ? $args['absoluteUrl'] : null;

        if (!empty($absolutePath) && !empty($absoluteUrl)) {
            $uploadsPath = $absolutePath;
            $uploadsUrl = $absoluteUrl;
        } else if (!empty($absolutePath) || !empty($absoluteUrl)) {
            throw new \Exception("You must pass both 'absolutePath' and 'absoluteUrl' to use manual definitions");
        }

        if (!file_exists($uploadsPath)) {
            throw new \Exception("Directory \"" . $uploadsPath . "\" could not be found");
        }

        $this->validateArgs($args);


        $this->vite = new ViteAdapter([
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
                echo $this->vite->generateTags($input, $buildDirectory);
            }
        });
    }

    public function validateArgs(array $args): bool
    {
        if (!isset($args['input'])) {
            throw new \Exception("No 'input' found");
        } else if (!isset($args['namespace']) || empty($args['namespace'])) {
            throw new \Exception("No 'namespace' found");
        }
        return true;
    }

    public function setupFilters(): void
    {
        if (self::$init === true) return;

        add_filter('script_loader_tag', [$this, 'addScriptAttributes'], 10, 2);
        self::$init = true;
    }

    /**
     * Remove deprecated script/link attributes and add attributes from registered sources
     *
     * @filter script_loader_tag
     */
    public function addScriptAttributes(string $tag, string $handle): string
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

    public static function __callStatic($method, $args)
    {
        $instance = new static;
        return $instance->$method(...$args);
    }
}
