<?php

namespace Dojo\ClassifyDocument\Application;


use DateTime;

interface SchoolYearCalculator
{
    public function forDate(DateTime $dateTime) : string;
}