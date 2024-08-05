<?php
declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EonX\EasyApiPlatform\Bundle\Enum\ConfigParam;
use EonX\EasyApiPlatform\Bundle\Enum\ConfigTag;
use EonX\EasyApiPlatform\EasyErrorHandler\Builder\ApiPlatformCustomSerializerExceptionErrorResponseBuilder;
use EonX\EasyApiPlatform\EasyErrorHandler\Builder\ApiPlatformMissingConstructorArgumentsExceptionErrorResponseBuilder;
use EonX\EasyApiPlatform\EasyErrorHandler\Builder\ApiPlatformNotNormalizableValueExceptionErrorResponseBuilder;
use EonX\EasyApiPlatform\EasyErrorHandler\Builder\ApiPlatformTypeErrorExceptionErrorResponseBuilder;
use EonX\EasyApiPlatform\EasyErrorHandler\Builder\ApiPlatformUnexpectedValueExceptionErrorResponseBuilder;
use EonX\EasyApiPlatform\EasyErrorHandler\Builder\ApiPlatformValidationExceptionErrorResponseBuilder;
use EonX\EasyApiPlatform\EasyErrorHandler\Provider\ApiPlatformErrorResponseBuilderProvider;
use EonX\EasyErrorHandler\Bundle\Enum\ConfigParam as EasyErrorHandlerConfigParam;
use EonX\EasyErrorHandler\Bundle\Enum\ConfigTag as EasyErrorHandlerConfigTag;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(ApiPlatformValidationExceptionErrorResponseBuilder::class)
        ->arg('$keys', param(EasyErrorHandlerConfigParam::ResponseKeys->value))
        ->tag(ConfigTag::EasyErrorHandlerErrorResponseBuilder->value, ['priority' => 99]);

    $services->set(ApiPlatformNotNormalizableValueExceptionErrorResponseBuilder::class)
        ->arg('$keys', param(EasyErrorHandlerConfigParam::ResponseKeys->value))
        ->tag(ConfigTag::EasyErrorHandlerErrorResponseBuilder->value, ['priority' => 98]);

    $services->set(ApiPlatformMissingConstructorArgumentsExceptionErrorResponseBuilder::class)
        ->arg('$keys', param(EasyErrorHandlerConfigParam::ResponseKeys->value))
        ->tag(ConfigTag::EasyErrorHandlerErrorResponseBuilder->value, ['priority' => 97]);

    $services->set(ApiPlatformUnexpectedValueExceptionErrorResponseBuilder::class)
        ->arg('$keys', param(EasyErrorHandlerConfigParam::ResponseKeys->value))
        ->tag(ConfigTag::EasyErrorHandlerErrorResponseBuilder->value, ['priority' => 96]);

    $services->set(ApiPlatformTypeErrorExceptionErrorResponseBuilder::class)
        ->arg('$keys', param(EasyErrorHandlerConfigParam::ResponseKeys->value))
        ->tag(ConfigTag::EasyErrorHandlerErrorResponseBuilder->value, ['priority' => 95]);

    $services->set(ApiPlatformCustomSerializerExceptionErrorResponseBuilder::class)
        ->arg('$keys', param(EasyErrorHandlerConfigParam::ResponseKeys->value))
        ->arg('$customSerializerExceptions', param(ConfigParam::EasyErrorHandlerCustomSerializerExceptions->value))
        ->tag(ConfigTag::EasyErrorHandlerErrorResponseBuilder->value, ['priority' => 94]);

    $services->set(ApiPlatformErrorResponseBuilderProvider::class)
        ->arg('$builders', tagged_iterator(ConfigTag::EasyErrorHandlerErrorResponseBuilder->value))
        ->tag(EasyErrorHandlerConfigTag::ErrorResponseBuilderProvider->value, ['priority' => -1]);
};
