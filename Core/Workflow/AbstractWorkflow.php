<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Workflow;

use InterInvest\Workflow\Core\Activity\ActivityInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

abstract class AbstractWorkflow implements WorkflowInterface
{
    public function __construct(
        #[AutowireLocator(ActivityInterface::class, defaultIndexMethod: 'activityName')]
        protected ServiceLocator $locator,
    ) {}

    /**
     * @template Activity of ActivityInterface
     * @throws \Exception
     * @return Activity
     * @param class-string<Activity> $className
     */
    public function make(string $className)
    {
        if (!$this->locator->has($className)) {
            throw new \BadMethodCallException("The class $className does not exist in the container");
        }

        return $this->locator->get($className);
    }
}
