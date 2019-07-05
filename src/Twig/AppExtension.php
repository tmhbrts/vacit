<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('show_checkmark', [$this, 'showCheckmark']),
        ];
    }

    public function showCheckmark($bool)
    {
        if($bool) {
          return('✓');
        }
        return;
    }
}
