<?php

namespace Packages\Lib;

use Finite\StatefulInterface;

class StatefulObject implements StatefulInterface
{
    private $state;

    public function getFiniteState()
    {
        return $this->state;
    }

    public function setFiniteState($state)
    {
        $this->state = $state;
    }

}