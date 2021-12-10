<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {

    $parameters = $containerConfigurator->parameters();

    $containerConfigurator->import(SymfonySetList::SYMFONY_52);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::PHP_80);

    $parameters->set(
        Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER,
        __DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml'
    );
};
