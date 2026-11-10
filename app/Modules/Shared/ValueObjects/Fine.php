<?php

namespace Modules\Shared\ValueObjects;

class Fine
{
    private float $amount;

    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Denda tidak boleh negatif');
        }

        $this->amount = $amount;
    }

    public function calculate(int $daysLate): float
    {
        return $this->amount * max(0, $daysLate);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}