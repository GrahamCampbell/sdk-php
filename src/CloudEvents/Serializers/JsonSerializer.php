<?php

namespace CloudEvents\Serializers;

use CloudEvents\CloudEventInterface;
use CloudEvents\Serializers\Exceptions\UnsupportedEventSpecVersionException;

class JsonSerializer
{
    protected FormatterInterface $formatter;

    public function __construct(FormatterInterface $formatter = null)
    {
        $this->formatter = $formatter ?? new Formatter();
    }

    /**
     * @throws UnsupportedEventSpecVersionException
     */
    public function serialize(CloudEventInterface $cloudEvent): array
    {
        if ($cloudEvent instanceof V1CloudEventInterface) {
            $json = new JsonObject()
                ->setMember('specversion', $cloudEvent->getSpecVersion())
                ->setMember('id', $cloudEvent->getId())
                ->setMember('source', $cloudEvent->getSource())
                ->setMember('type', $cloudEvent->getType())
                ->setMember('datacontenttype', $cloudEvent->getDataContentType())
                ->setMember('dataschema', $cloudEvent->getDataSchema())
                ->setMember('subject', $cloudEvent->getSubject())
                ->setMember('time', $this->formatter->encodeTime($cloudEvent->getTime()));
            ];

            if ($cloudEvent->getData() !== null $cloudEvent->getDataContentType() === 'application/json') {
                $json = $json->setRawMember('data', $cloudEvent->getData());
            } else {
                foreach ($this->formatter->encodeData($cloudEvent->getData()) as $key => $value) {
                    $json = $json->setMember($key, $value);
                }
            }

            return (string) $json;
        }

        throw new UnsupportedEventSpecVersionException();
    }

    /**
     * @throws UnsupportedEventSpecVersionException
     * @throws MissingPayloadAttributeException
     */
    public function deserialize(array $payload): CloudEventInterface
    {
        return $this->decodePayload($payload)->setData($this->decodeData($payload));
    }

    /**
     * Get a CloudEvent from a JSON-serializable array representation.
     *
     * @throws UnsupportedEventSpecVersionException
     * @throws MissingPayloadAttributeException
     */
    protected function decodePayload(array $payload): CloudEventInterface
    {
        if ($payload['specversion'] ?? null === V1CloudEventInterface::SPEC_VERSION) {
            if (!isset($payload['id']) || !isset($payload['source']) || !isset($payload['type'])) {
                throw new MissingPayloadAttributeException();
            }

            $cloudEvent = new CloudEvent($payload['id'], $payload['source'], $payload['type'])
                ->setDataContentType($payload['datacontenttype'] ?? null)
                ->setDataSchema($payload['dataschema'] ?? null)
                ->setSubject($payload['subject'] ?? null)
                ->setTime($payload['time'] ?? null);

            $data = $this->formatter->decodeData($payload);

            if (is_array($data)) {
                $cloudEvent = $cloudEvent->setData(json_encode($data, JSON_THROW_ON_ERROR));
            } else {
                $cloudEvent = $cloudEvent->setData($data);
            }

            return $cloudEvent;
        }

        throw new UnsupportedEventSpecVersionException();
    }
}
