<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class CartHeader
{
    use DefaultActionTrait;

    #[LiveListener('refreshCart')]
    public function refreshCart()
    {
    }
}