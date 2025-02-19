<?php

namespace Alteis\HagreedBundle\Command;

use Alteis\HagreedBundle\Service\ApiHagreedInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'alteis:hagreed:export-consents', description: 'Retrieve your Hagreed consent register')]
class ExportConsentsCommand extends Command
{
    public function __construct(
        private readonly ApiHagreedInterface $apiHagreed
    )
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            // ...
            ->addArgument('mail', InputArgument::REQUIRED, 'address mail')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $mail */
        $mail = $input->getArgument('mail');
        $data = $this->apiHagreed->exportConsents($mail);

        if ($data['status'] !== 'OK') {
            $output->writeln('<error>problem with the API</error>');
            return Command::FAILURE;
        }

        $headers = [
            'consent_id',
            'token',
            'date_created_utc',
            'date_last_updated_utc',
            'timezone',
            'form_id',
            'finality_slug',
            'hash_ip',
            'referer',
            'license_token',
            'type'
        ];
        $table = new Table($output);
        $table->setHeaderTitle('Consents');
        $table->setHeaders($headers);
        foreach ($data['response']['consents'] as $consent) {
            $row = [];
            foreach ($headers as $header) {
                $row[] = $consent[$header];
            }
            $table->addRow($row);
        }
        $table->render();
        return Command::SUCCESS;
    }
}