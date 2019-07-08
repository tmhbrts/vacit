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
            new TwigFilter('invitationStatus', [$this, 'showInvitationStatus']),
        ];
    }

    public function showInvitationStatus($bool)
    {
        if($bool) {
          return('✓');
        }
        return;
    }
}
