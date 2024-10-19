<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Serializer;

use InterInvest\Workflow\Core\Handler\EventMessage;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

#[AsDecorator('messenger.transport.symfony_serializer', onInvalid: ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE )]
final readonly class ExternalMessageSerializer implements SerializerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function decode(array $encodedEnvelope): Envelope
    {
        $isExternalMessage = $encodedEnvelope['headers']['X-External-Message'] ?? false;
        if ($isExternalMessage) {
            $encodedEnvelope['headers']['type'] = EventMessage::class;
        }

        return $this->serializer->decode($encodedEnvelope);
    }

    public function encode(Envelope $envelope): array
    {
        return $this->serializer->encode($envelope);
    }
}
