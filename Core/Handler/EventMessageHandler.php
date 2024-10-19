<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Handler;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

readonly class EventMessageHandler
{
    /**
     * @param iterable<WorkflowHandlerInterface> $workflowHandlers
     */
    public function __construct(
        #[AutowireIterator(WorkflowHandlerInterface::class)]
        private iterable $workflowHandlers,
    ) {
    }

    public function __invoke(EventMessageInterface $eventMessage): void
    {
        foreach ($this->workflowHandlers as $handler) {
            if ($handler->supports($eventMessage)) {
                $handler->handle($eventMessage);
                return;
            }
        }

        throw new \RuntimeException('No workflow found for the event type: ' . $eventMessage->getEventType());
    }
}
