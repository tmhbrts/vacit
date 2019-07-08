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
            new TwigFilter('inviteAction', [$this, 'showInviteAction'])
        ];
    }

    public function showInvitationStatus($bool)
    {
        if($bool) {
          return('✓');
        }
        return;
    }

    public function showInviteAction($bool)
    {
        if($bool) {
          return('✓');
        } else {
          return('
            <button class="invite">Uitnodigen</button>
          ');
        }
    }


}
