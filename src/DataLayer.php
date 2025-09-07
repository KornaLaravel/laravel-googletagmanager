<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Support\Arr;

class DataLayer
{
    public function __construct(
        /** @var array<string, mixed> */
        protected array $data = [],
    ) {}

    /**
     * Add data to the data layer. Supports dot notation.
     * Inspired by laravel's config repository class.
     *
     * @param array<string, mixed>|string $key
     */
    public function set(array|string $key, mixed $value = null): void
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                Arr::set($this->data, $innerKey, $innerValue);
            }

            return;
        }

        Arr::set($this->data, $key, $value);
    }

    /**
     * Empty the data layer.
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * Return an array representation of the data layer.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Return a json representation of the data layer.
     */
    public function toJson(): string
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}
