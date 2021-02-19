<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class HomeTitleExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('homeTitle', [$this, 'homeTitle']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function homeTitle($value)
    {
        $array = explode(' ', $value);
        $result = '
                <div class="line1"><span classe="">' . substr($array[0], 0,1) . '</span>'.substr($array[0], 1).'</div><div class="line2">' . $array[1] . '</div>
            <div class="line3">' . $array[2] . '</div>';
        return $result;
    }
}
