<?php

declare(strict_types=1);

namespace CloudEvents\V1;

use DateTimeInterface;

class CloudEvent implements CloudEventInterface
{
    private string $id;
    private string $source;
    private string $type;
    private ?string $dataContentType;
    private ?string $dataSchema;
    private ?string $subject;
    private ?DateTimeInterface $time;
    private ?string $data;

    public function __construct(
        string $id,
        string $source,
        string $type,
        ?string $data = null,
        ?string $dataContentType = null,
        ?string $dataSchema = null,
        ?string $subject = null,
        ?DateTimeInterface $time = null
    ) {
        $this->id = $id;
        $this->source = $source;
        $this->type = $type;
        $this->data = $data;
        $this->dataContentType = $dataContentType;
        $this->dataSchema = $dataSchema;
        $this->subject = $subject;
        $this->time = $time;
    }

    public function getSpecVersion(): string
    {
        return static::SPEC_VERSION;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return $this
     */
    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @return $this
     */
    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getDataContentType(): ?string
    {
        return $this->dataContentType;
    }

    /**
     * @return $this
     */
    public function setDataContentType(?string $dataContentType): self
    {
        $this->dataContentType = $dataContentType;

        return $this;
    }

    public function getDataSchema(): ?string
    {
        return $this->dataSchema;
    }

    /**
     * @return $this
     */
    public function setDataSchema(?string $dataSchema): self
    {
        $this->dataSchema = $dataSchema;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @return $this
     */
    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTime(): ?DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @return $this
     */
    public function setTime(?DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
