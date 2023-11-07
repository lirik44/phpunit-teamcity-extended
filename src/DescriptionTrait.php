<?php

namespace PHPUnitTeamcity;

use PHPUnit\Util\Test;

trait DescriptionTrait
{
    private function getTestDescription()
    {
        //This method parse @description annotation in tests
        $annotations = Test::parseTestMethodAnnotations(static::class, $this->getName(false));

        if (isset($annotations['method']['description'][0])) {
            return $annotations['method']['description'][0];
        }

        if (isset($annotations['class']['description'][0])) {
            return $annotations['class']['description'][0];
        }
    }
}
