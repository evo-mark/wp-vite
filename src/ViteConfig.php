<?php

namespace Southcoastweb\WpVite;

class ViteConfig
{
    public string $uploadsPath = "";
    public string $uploadsUrl = "";
    public string $hotFile;
    public array $dependencies;
    public bool $footer;

    public function __construct(array $configArray)
    {
        $this->uploadsPath = $configArray['uploadsPath'];
        $this->uploadsUrl = $configArray['uploadsUrl'];
        $this->hotFile = $configArray['hotFile'] ?? "hot";
        $this->dependencies = $configArray['dependencies'] ?? [];
        $this->footer = $configArray['footer'] ?? false;
    }
}
