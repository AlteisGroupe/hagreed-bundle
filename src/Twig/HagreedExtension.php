<?php

namespace Alteis\HagreedBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\Environment;

class HagreedExtension extends AbstractExtension
{
    public function __construct(
        private readonly Environment $twig,
        private readonly ?string $token,
        private readonly ?string $template,
        private readonly ?string $element,
        private readonly array $cookies,
        private readonly array $consentsFormList,
        private readonly int $timeout,
        private readonly bool $turbo,
        private readonly array $language
    ) {}

    /**
     * @return array<int, TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('header_hagreed', [$this, 'header'], ['is_safe' => ['html']]),
            new TwigFunction('body_end_hagreed', [$this, 'bodyEnd'], ['is_safe' => ['html']]),
        ];
    }

    public function header(): string
    {
        if ($this->token === null) {
            throw new \Exception('token is null');
        }
        if ($this->turbo) {
            return $this->twig->render('@AlteisHagreed/header_turbo.html.twig', [
                'element' => $this->element,
                'token' => $this->token,
                'template' => $this->template,
                'timeout' => $this->timeout,
                'language' => $this->language,
                'cookies' => json_encode($this->cookies),
                'consentsFormList' => json_encode($this->consentsFormList),
            ]);
        } else {
            return $this->twig->render('@AlteisHagreed/header.html.twig', [
                'element' => $this->element,
                'token' => $this->token,
                'template' => $this->template,
                'timeout' => $this->timeout,
                'language' => $this->language,
                'cookies' => json_encode($this->cookies),
                'consentsFormList' => json_encode($this->consentsFormList),
            ]);
        }
    }

    public function bodyEnd(): string
    {
        return $this->twig->render('@AlteisHagreed/body_end.html.twig', ['element' => $this->element]);
    }
}