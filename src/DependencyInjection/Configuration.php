<?php

namespace Alteis\HagreedBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('alteis_hagreed');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->scalarNode('id')->defaultValue('hagreed')->end()
                    ->scalarNode('token')->defaultNull()->end()
                    ->integerNode('timeout')->defaultValue(5000)->end()
                    ->enumNode('template')->values(['default', 'fullpage', 'custom'])->defaultNull()->end()

                    ->arrayNode('language')
                        ->children()
                            ->enumNode('lang')->values(['en', 'fr'])->defaultNull()->end()
                            ->booleanNode('force_lang')->defaultNull()->end()
                        ->end()
                    ->end()

                    ->arrayNode('consents_form_list')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('id')->example('contact')->cannotBeEmpty()->end()
                                ->scalarNode('title')->example('Finalité des traitements 🥳')->cannotBeEmpty()->end()
                                ->scalarNode('description')->example('[RESPONSABLE DU TRAITEMENT] traite les données recueillies pour pouvoir apporter une réponse à votre sollicitation et également pouvoir communiquer avec vous
sur des nouveautés ou des offres à propos de [VOTRE OFFRE]. Pour en savoir plus sur la gestion de vos données personnelles et pour exercer vos droits, reportez-vous à cette <a
href=\"[URL VERS VOTRE PAGE DE POLITIQUE DE CONFIDENTIALITE]\">page</a>.')->defaultNull()->end()

                                ->arrayNode('purposes')
                                    ->arrayPrototype()
                                        ->children()
                                            ->scalarNode('slug')->example('contact')->cannotBeEmpty()->end()
                                            ->scalarNode('name')->example('J\'accepte que mes informations personnelles soient utilisées pour qu\'on puisse répondre à ma sollicitation.')->cannotBeEmpty()->end()
                                            ->booleanNode('mandatory')->end()
                                            ->scalarNode('description')->defaultNull()->example('Nous envoyons à nos abonnés au maximum 1 newsletter par mois afin de partager avec eux les bons plans, les informations commerciales et les nouveautés
concernant [VOTRE OFFRE]. Pour ce faire, nous transférons les données sur notre outil de campagne marketing : Brevo. Quoi qu\'il arrive, les données restent en France et la
politique de confidentialité et de gestion des données personnelles de Brevo s\'appliquent. <a href=\"https://www.brevo.com/fr/legal/privacypolicy/\" target=\"_blank\">En savoir plus</a>.')->end()
                                            ->scalarNode('inputId')->defaultNull()->end()
                                        ->end()
                                    ->end()
                                ->end()

                            ->end()
                        ->end()
                    ->end()

                    ->arrayNode('cookies')
                        ->arrayPrototype()
                            ->children()

                                ->scalarNode('id')->example('ga')->defaultNull()->end()

                                ->scalarNode('name')->example('Google Analytics')->defaultNull()->end()

                                ->scalarNode('description')->defaultNull()->end()

                                ->scalarNode('link')->example('https://marketingplatform.google.com/about/analytics/terms/fr/')->defaultNull()->end()

                                ->enumNode('category')->values(['NECESSARY', 'STATISTIQUES', 'MARKETING', 'PREFERENCES', 'DIVERS'])->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}