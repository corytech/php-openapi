<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use OpenApi\Annotations\Operation;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Summary extends Operation
{
    public function __construct(string $summary, string $method = 'post')
    {
        parent::__construct(['summary' => $summary, 'method' => $method]);
    }
}
