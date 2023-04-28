<?php

namespace Southcoastweb\WpVite;

class ViteConfig
{
    public string $uploadsPath = "";
    public string $uploadsUrl = "";
    public string $hotFile = "hot";
    public array $dependencies = [];

    public function __construct(array $configArray)
    {
        $this->uploadsPath = $configArray['uploadsPath'];
        $this->uploadsUrl = $configArray['uploadsUrl'];
        $this->hotFile = $configArray['hotFile'];
        $this->dependencies = $configArray['dependencies'] ?? [];
    }
}
