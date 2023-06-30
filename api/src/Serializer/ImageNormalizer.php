<?php

namespace App\Serializer;

use App\Entity\Image;
use ArrayObject;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

class ImageNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface {

    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'IMAGE_NORMALIZER_ALREADY_CALLED';

    /**
     * @param StorageInterface $storage
     */
    public function __construct(
        private readonly StorageInterface $storage
    ) {}


    /**
     * @param Image $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string
     * @throws ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array|ArrayObject|bool|float|int|string {
        $context[self::ALREADY_CALLED] = true;
        $object->setContentUrl($this->storage->resolveUri($object, 'file'));
        return $this->normalizer->normalize($object, $format, $context);
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool {
        if (isset($context[self::ALREADY_CALLED])){
            return false;
        }

        return $data instanceof Image;
    }

}
