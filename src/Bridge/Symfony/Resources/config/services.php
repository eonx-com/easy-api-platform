<?php
declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EonX\EasyApiPlatform\Bridge\Symfony\Listeners\ReadListener;
use EonX\EasyApiPlatform\Routing\IriConverter;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(IriConverter::class)
        ->decorate('api_platform.iri_converter')
        ->arg('$decorated', service('.inner'));

    $services->set(ReadListener::class)
        ->arg(
            '$resourceMetadataCollectionFactory',
            service('api_platform.metadata.resource.metadata_collection_factory')
        )
        ->tag('kernel.event_listener', [
            'event' => 'kernel.request',
            'priority' => 4,
        ]);
};
