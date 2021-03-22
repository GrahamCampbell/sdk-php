<?php

namespace CloudEvents\Serializers;

use JsonException;
use ValueError;

/**
 * @internal
 */
class JsonObject
{
    /**
     * @param array<string,string>
     */
    private array $members;

    public function __construct()
    {
        $this->members = [];
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setMember(string $key, $value): self
    {
        try {
            $encodedKey = json_encode($key, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
              throw new ValueError(
                \sprintf('%s::setMember(): Argument #1 ($key) cannot be encoded as JSON. %s', self::class, $e->getMessage()),
                0,
                $e
            );
        }

        if ($value === null) {
            unset($this->members[$encodedKey]);
        } else {
            try {
                $encodedValue = json_encode($value, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                  throw new ValueError(
                    \sprintf('%s::addMember(): Argument #2 ($value) cannot be encoded as JSON. %s', self::class, $e->getMessage()),
                    0,
                    $e
                );
            }

            $this->members[$encodedKey] = $encodedValue;
        }

        return $this;
    }

    /**
     * @param mixed $value
     */
    public function setRawMember(string $key, string $value): self
    {
        try {
            $encodedKey = json_encode($key, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
              throw new ValueError(
                \sprintf('%s::setRawMember(): Argument #1 ($key) cannot be encoded as JSON. %s', self::class, $e->getMessage()),
                0,
                $e
            );
        }

        $this->members[$encodedKey] = $value;
    }

    public function __toString(): string
    {
        return sprintf('{%s}', implode(',', $this->members));
    }
}
