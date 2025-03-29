<?php

namespace EvoMark\WpVite;

class ViteConfig
{
    public string $viteDistPath = "";
    public string $viteDistUri = "";
    public string $hotFile;
    public array $dependencies;
    public string $namespace;
    public bool $footer;
    public string $entryHandle;
    public bool $useReact;

    public function __construct(array $configArray)
    {
        $this->viteDistPath = $configArray['viteDistPath'];
        $this->viteDistUri = $configArray['viteDistUri'];
        $this->hotFile = $configArray['hotFile'] ?? "hot";
        $this->dependencies = $configArray['dependencies'] ?? [];
        $this->namespace = $configArray['namespace'] ?? "";
        $this->footer = $configArray['footer'] ?? false;
        $this->entryHandle = $configArray['entryHandle'] ?? "";
        $this->useReact = $configArray['useReact'] ?? false;
    }
}
