<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

enum PropertyFormat: string
{
    case Textarea = 'textarea';
    case Url = 'url';
}
