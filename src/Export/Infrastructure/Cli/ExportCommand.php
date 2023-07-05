<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Cli;

use Productsup\CDE\Connector\Infrastructure\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ExportCommand extends AbstractCommand
{
    private const PERSONAL_ACCESS_TOKEN= 'personal-access-token';
    private const COMPANY_ID= 'company-id';

    public function configure(): void
    {
        parent::configure();
        $this->setName('export')
            ->setDescription('Export products')
            ->addObligatoryOption(
                name: self::PERSONAL_ACCESS_TOKEN,
                mode: InputOption::VALUE_REQUIRED,
                description: 'personal access token'
            )
            ->addObligatoryOption(
                name: self::COMPANY_ID,
                mode: InputOption::VALUE_REQUIRED,
                description: 'Company ID',
            );
    }

    protected function mapOptions(InputInterface $input, OutputInterface $output): array
    {
        return [
            'personal_access_token' => self::PERSONAL_ACCESS_TOKEN,
            'company_id' => self::COMPANY_ID,
        ];
    }

    protected function getApplicationServiceClass(): string
    {
        return ExportService::class;
    }
}
