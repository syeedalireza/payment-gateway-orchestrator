<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\StateMachine;

/**
 * Payment state machine
 */
final class PaymentStateMachine
{
    private string $state = 'pending';

    private const VALID_TRANSITIONS = [
        'pending' => ['processing', 'cancelled'],
        'processing' => ['completed', 'failed'],
        'completed' => ['refunded'],
        'failed' => ['pending'],
        'cancelled' => [],
        'refunded' => [],
    ];

    public function transition(string $newState): void
    {
        if (!$this->canTransitionTo($newState)) {
            throw new \InvalidArgumentException(
                "Cannot transition from {$this->state} to $newState"
            );
        }

        $this->state = $newState;
    }

    public function canTransitionTo(string $newState): bool
    {
        return in_array($newState, self::VALID_TRANSITIONS[$this->state] ?? [], true);
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function isPending(): bool
    {
        return $this->state === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->state === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->state === 'failed';
    }
}
