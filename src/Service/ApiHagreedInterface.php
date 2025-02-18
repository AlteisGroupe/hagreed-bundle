<?php

namespace Alteis\HagreedBundle\Service;

interface ApiHagreedInterface
{
    /**
     * This method allows you to send an HTTP request to Hagreed to receive the Hagreed consent register in your email address.
     * @param string $email
     * @return array
     */
    public function exportConsents(string $email): array;
}