# hagreed-bundle
Hagreed integration for Symfony – Easily manage user consents and cookies in your application, leveraging the Hagreed system.

Link site: https://www.hagreed.com/

## Configuration
### installation
Hagreed Bundle requires PHP 8.2 or higher and Symfony 7.0 or higher. Run the following command to install it in your application:
```shell
composer require alteis/hagreed-bundle
```
### minimal require
Add your token to the **HAGREED_TOKEN** variable in your `.env` file
> To create your **token**, please fill out the form on the website https://www.hagreed.com/
```.env
HAGREED_TOKEN="your-token"
```

In your html.twig code, add the following functions: `{{ header_hagreed() }}` & `{{ body_end_hagreed() }}`.
```twig
<html>
    <head>
        ....
        {{ header_hagreed() }} {# Add in the header #}
    </head>
    <body>
        ...
        {{ body_end_hagreed() }}  {# Add towards the end of the body block #}
    </body>
</html>
 ```
Create file `config/packages/alteis_hagreed.yaml` if not exist.
```yaml
alteis_hagreed:
    token: '%env(HAGREED_TOKEN)%'
```
 Register the bundle in your application. Edit the `config/bundles.php` file and add the following if this has not already been done
 ```php
<?php

return [
    ...
    Alteis\HagreedBundle\AlteisHagreedBundle::class => ['all' => true],
];

```
Add the two dependencies to your `importmap.php` file if this has not already been done.
```php
<?php
return [
    ...
    '@tizy/hagreed/hagreed.js' => [
        'version' => '1.2.7',
    ],
    '@tizy/hagreed/style.css' => [
        'version' => '1.2.7',
        'type' => 'css',
    ],
];
```
### display banner
Code for users to change their mind about cookies.
```html
<a href="javascript:window.hagreedBundle.displayBanner();">Cookie Management</a>
```
### more options
``` yaml
alteis_hagreed:
    token: '%env(HAGREED_TOKEN)%'
    template: 'default'
    id: 'hagreed' #Refer to the Installation section.
    timeout: 5000 #The cookie box will launch - if the user has never made a choice - after 5000 ms (5 seconds).
    cookies: #Insert your cookies here
        -
            id: ga
            name: 'Google Analytics'
            description: ''
            link: 'https://marketingplatform.google.com/about/analytics/terms/fr/'
            category: NECESSARY
    language:
        lang: fr #The default language is French, set "en" for English.
        force_lang: false #If the user's browser is set to French, we will still display English.
    consents_form_list:
        -
            id: contact #The value of the "id" field of your form
            title: 'Finalité des traitements 🥳'
            description: '[RESPONSABLE DU TRAITEMENT] traite les données recueillies pour pouvoir apporter une réponse à votre sollicitation et également pouvoir communiquer avec vous sur des nouveautés ou des offres à propos de [VOTRE OFFRE]. 
            Pour en savoir plus sur la gestion de vos données personnelles et pour exercer vos droits, reportez-vous à cette <a href="google.com">page</a>.'
            purposes:
                -
                    slug: "marketing"
                    name: "J'accepte également que mes données soient utilisées afin de recevoir des nouveautés ou des offres commerciales quant à [VOTRE OFFRE]."
                    mandatory: false
                    description: "Nous envoyons à nos abonnés au maximum 1 newsletter par mois afin de partager avec eux les bons plans, les informations commerciales et les nouveautés
                    concernant [VOTRE OFFRE]. Pour ce faire, nous transférons les données sur notre outil de campagne marketing : Brevo. Quoi qu'il arrive, les données restent en France et la
                    politique de confidentialité et de gestion des données personnelles de Brevo s'appliquent. <a href=\"https://www.brevo.com/fr/legal/privacypolicy/\" target=\"_blank\">En savoir
                    plus</a>."
                    inputId: "field-marketing-purpose"
```
