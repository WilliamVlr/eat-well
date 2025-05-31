<?php

namespace App\Enums;

enum TimeSlot: string
{
    case Morning = 'Morning';
    case Afternoon = 'Afternoon';
    case Evening = 'Evening';
}