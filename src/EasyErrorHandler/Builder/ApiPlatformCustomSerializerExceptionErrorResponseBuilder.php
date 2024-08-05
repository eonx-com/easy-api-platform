<?php
declare(strict_types=1);

namespace EonX\EasyApiPlatform\EasyErrorHandler\Builder;

use EonX\EasyErrorHandler\Common\Translator\TranslatorInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Throwable;

final class ApiPlatformCustomSerializerExceptionErrorResponseBuilder extends
    AbstractApiPlatformSerializerExceptionErrorResponseBuilder
{
    public function __construct(
        TranslatorInterface $translator,
        array $keys,
        ?int $priority = null,
        private readonly array $customSerializerExceptions = [],
    ) {
        parent::__construct($translator, $keys, $priority);
    }

    protected function doBuildViolations(Throwable $throwable): array
    {
        foreach ($this->customSerializerExceptions as $exception) {
            if ($throwable::class !== $exception['class']) {
                continue;
            }

            if (\preg_match($exception['message_pattern'], $throwable->getMessage()) === 1) {
                $violation = $this->translator->trans($exception['violation_message'], []);
                if ($throwable instanceof NotNormalizableValueException) {
                    return [
                        $throwable->getPath() => [
                            $violation,
                        ],
                    ];
                }

                return [
                    $violation,
                ];
            }
        }

        return [];
    }
}