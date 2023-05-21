<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\FileUploaded;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('upload_file', [FileUploaded::class, 'asset'])
        ];
    }

}