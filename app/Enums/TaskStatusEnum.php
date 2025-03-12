<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case PENDING = "pending";
    case PROCESSING = "processing";
    case CANCELED = "canceled";
    case COMPLETED = "completed";
}
