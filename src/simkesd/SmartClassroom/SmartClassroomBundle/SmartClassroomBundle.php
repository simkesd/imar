<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SmartClassroomBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
