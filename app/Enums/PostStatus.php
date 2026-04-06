<?php

namespace App\Enums;

enum PostStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
    case Review = 'review';
}
