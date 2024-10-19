<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Handler;

class EventMessage implements EventMessageInterface
{
    /**
     * @param array<int|string, mixed> $data
     */
    public function __construct(
        public string $id,
        public string $eventType,
        public array $data,
        public ?int $timestamp = null
    ) {
        $this->timestamp = $timestamp ?? (new \DateTime())->getTimestamp();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }
}
