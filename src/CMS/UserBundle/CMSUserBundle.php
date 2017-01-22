<?php

namespace CMS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CMSUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
