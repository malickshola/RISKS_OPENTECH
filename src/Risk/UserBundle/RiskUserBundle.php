<?php

namespace Risk\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RiskUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
