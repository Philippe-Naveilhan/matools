<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CapitalizeComposedExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('capitelizeComposed', [$this, 'capitelizeComposed']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function capitelizeComposed($value)
    {
        $resultarray = [];
        $array = explode('-', $value);
        foreach ($array as $single){
            $resultarray[] = ucfirst($single);
        }
        $result = implode('-', $resultarray);
        return $result;
    }
}
