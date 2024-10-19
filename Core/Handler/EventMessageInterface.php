<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Handler;

interface EventMessageInterface
{
    public function getId(): string;

    public function getEventType(): string;

    /**
     * @return array<string|int, mixed>
     */
    public function getData(): array;

    public function getTimestamp(): ?int;
}
