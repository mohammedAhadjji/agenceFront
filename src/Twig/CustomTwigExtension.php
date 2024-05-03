<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CustomTwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_date_expired', [$this, 'isDateExpired']),
        ];
    }

    public function isDateExpired($date): bool
    {
        $now = new \DateTime();
        return $date > $now;
    }
}
