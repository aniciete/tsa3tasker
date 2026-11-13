<?php

namespace App\Enums;

/**
 * Supported completion states for a Tasker task record.
 */
enum TaskStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
}
