<?php

namespace Sunu\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SunuUserBundle extends Bundle
{
    public function getParent()

    {
  
      return 'FOSUserBundle';
  
    }
}
