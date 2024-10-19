<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Command;

class ActivityLogger
{
    public function __construct(
        public string $workflowId,
        public string $activityId,
        public string $activityName,
        public int $activityIndex,
        /**
         * @var array<string, mixed>
         */
        public array $activityArguments,
        public mixed $output = null,
        public ?int $timestamp = null,
    ) {
        $this->timestamp = (new \DateTime())->getTimestamp();
    }
}
