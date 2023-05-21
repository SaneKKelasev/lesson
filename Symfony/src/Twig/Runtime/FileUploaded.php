<?php

namespace App\Twig\Runtime;

use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\RuntimeExtensionInterface;

class FileUploaded implements RuntimeExtensionInterface
{
    private ParameterBagInterface $parameterBag;
    private Packages $packages;

    /**
     * @param ParameterBagInterface $parameterBag
     * @param Packages $packages
     */
    public function __construct(
        ParameterBagInterface $parameterBag,
        Packages $packages
    ) {
        $this->parameterBag = $parameterBag;
        $this->packages = $packages;
    }

    public function asset(string $config, string $path)
    {
        return $this->packages->getUrl($this->parameterBag->get($config) . '/' . $path);
    }
}