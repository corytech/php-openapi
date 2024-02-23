<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use Nelmio\ApiDocBundle\Annotation\Operation;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Summary extends Operation
{
    public function __construct(string $summary)
    {
        parent::__construct(['summary' => $summary]);
    }
}
