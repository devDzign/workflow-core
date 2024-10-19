<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Workflow;

use InterInvest\Workflow\Core\Activity\ActivityInterface;
use InterInvest\Workflow\Core\Handler\EventMessageInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;


/**
 * @template R
 */
#[AutoconfigureTag]
interface WorkflowInterface
{
    /**
     * @return R
     */
    public function start(EventMessageInterface $eventMessage);

    /**
     * @template Activity of ActivityInterface
     *
     * @throws \Exception
     * @return Activity
     * @param class-string<Activity> $className
     */
    public function make(string $className);

    public static function supportedEvent(): string;
}
