<?php


use Alteis\HagreedBundle\Service\ApiHagreedInterface;
use Alteis\HagreedBundle\Service\ApiHagreedService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Alteis\HagreedBundle\Twig\HagreedExtension;
use Alteis\HagreedBundle\Command\ExportConsentsCommand;

return static function (ContainerConfigurator $container): void {

    $container->services()
        ->set(HagreedExtension::class, HagreedExtension::class)
        ->arg('$token', '%alteis_hagreed.token%')
        ->arg('$template', '%alteis_hagreed.template%')
        ->arg('$element', '%alteis_hagreed.element%')
        ->arg('$cookies', '%alteis_hagreed.cookies%')
        ->arg('$timeout', '%alteis_hagreed.timeout%')
        ->arg('$turbo', '%alteis_hagreed.turbo%')
        ->arg('$language', '%alteis_hagreed.language%')
        ->arg('$consentsFormList', '%alteis_hagreed.consents_form_list%')
        ->autowire()
        ->tag('twig.extension');

    $container->services()
        ->set(ExportConsentsCommand::class, ExportConsentsCommand::class)
        ->autowire()
        ->tag('console.command');


    $container->services()->set(ApiHagreedService::class)->arg('$token', '%alteis_hagreed.token%')->private()->autowire();
    $container->services()->alias(ApiHagreedInterface::class, ApiHagreedService::class);
};