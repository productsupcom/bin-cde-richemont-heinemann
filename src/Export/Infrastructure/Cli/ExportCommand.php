<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Cli;

use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Service\ExportService;
use Productsup\CDE\Connector\Infrastructure\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ExportCommand extends AbstractCommand
{
    private const ACCESS_KEY_ID = 'access-key-id';
    private const SECRET_ACCESS_KEY = 'secret-access-key';
    private const BUCKET = 'bucket';
    private const REGION = 'region';
    private const FILENAME = 'filename';

    public function configure(): void
    {
        parent::configure();
        $this->setName('export')
            ->setDescription('Export products')
            ->addObligatoryOption(
                name: self::ACCESS_KEY_ID,
                mode: InputOption::VALUE_REQUIRED,
                description: 'Access Key Id'
            )
            ->addObligatoryOption(
                name: self::SECRET_ACCESS_KEY,
                mode: InputOption::VALUE_REQUIRED,
                description: 'Secret Access Key'
            )
            ->addObligatoryOption(
                name: self::BUCKET,
                mode: InputOption::VALUE_REQUIRED,
                description: 'Bucket'
            )
            ->addObligatoryOption(
                name: self::FILENAME,
                mode: InputOption::VALUE_REQUIRED,
                description: 'Filename',
            )
            ->addOption(
                name: self::REGION,
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Region',
                default: 'eu-central-1'
            );
    }

    protected function mapOptions(InputInterface $input, OutputInterface $output): array
    {
        return [
            'access_key_id' => self::ACCESS_KEY_ID,
            'secret_access_key' => self::SECRET_ACCESS_KEY,
            'bucket' => self::BUCKET,
            'region' => self::REGION,
            'filename' => self::FILENAME,
        ];
    }

    protected function getApplicationServiceClass(): string
    {
        return ExportService::class;
    }
}
