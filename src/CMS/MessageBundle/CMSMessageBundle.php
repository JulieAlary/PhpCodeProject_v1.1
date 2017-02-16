<?php

namespace CMS\MessageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CMSMessageBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSMessageBundle';
    }
}
