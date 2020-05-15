<?php

declare(strict_types=1);

namespace Note\Domain\Traits;

trait Timestamps
{
    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $timestamp
     * @return void
     */
    public function setUpdatedAt(string $timestamp): void
    {
        $this->updated_at = $timestamp;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
