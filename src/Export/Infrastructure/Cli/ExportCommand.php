<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Cli;

use Productsup\BinCdeHeinemann\Export\Infrastructure\Service\ExportService;
use Productsup\CDE\Connector\Infrastructure\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ExportCommand extends AbstractCommand
{
    private const OPTION_FTP_HOST = 'ftp-host';
    private const OPTION_FTP_PORT = 'ftp-port';
    private const OPTION_FTP_DIRECTORY = 'ftp-directory';
    private const OPTION_FTP_USERNAME = 'ftp-username';
    private const OPTION_FTP_PASSWORD = 'ftp-password';
    private const OPTION_FTP_REMOTE_FILE = 'ftp-remote-file';
    private const OPTION_XML_HEADER = 'xml-header';
    private const OPTION_XML_RECEIVER_ID = 'xml-receiver-id';
    private const OPTION_XML_RECEIVER_EMAIL = 'xml-receiver-email';

    public function configure(): void
    {
        parent::configure();
        $this->setName('export')
            ->setDescription('Export products')
            ->addObligatoryOption(
                name: self::OPTION_FTP_HOST,
                mode: InputOption::VALUE_REQUIRED,
                description: 'SFTP/FTP host.'
            )
            ->addObligatoryOption(
                name: self::OPTION_FTP_PORT,
                mode: InputOption::VALUE_REQUIRED,
                description: 'SFTP/FTP port.'
            )
            ->addObligatoryOption(
                name: self::OPTION_FTP_DIRECTORY,
                mode: InputOption::VALUE_REQUIRED,
                description: 'SFTP/FTP directory.'
            )
            ->addObligatoryOption(
                name: self::OPTION_FTP_USERNAME,
                mode: InputOption::VALUE_REQUIRED,
                description: 'SFTP/FTP username.'
            )
            ->addObligatoryOption(
                name: self::OPTION_FTP_PASSWORD,
                mode: InputOption::VALUE_REQUIRED,
                description: 'SFTP/FTP password.'
            )
            ->addObligatoryOption(
                name: self::OPTION_FTP_REMOTE_FILE,
                mode: InputOption::VALUE_REQUIRED,
                description: 'Filename.',
            )
            ->addOption(
                name: self::OPTION_XML_HEADER,
                mode: InputOption::VALUE_REQUIRED,
                description: 'XML custom header value.',
            )
            ->addOption(
                name: self::OPTION_XML_RECEIVER_ID,
                mode: InputOption::VALUE_REQUIRED,
                description: 'XML custom receiver value.',
            )
            ->addOption(
                name: self::OPTION_XML_RECEIVER_EMAIL,
                mode: InputOption::VALUE_REQUIRED,
                description: 'XML custom email value.',
            );

    }

    protected function mapOptions(InputInterface $input, OutputInterface $output): array
    {
        return [
            'ftp-host' => self::OPTION_FTP_HOST,
            'ftp-port'=> self::OPTION_FTP_PORT,
            'ftp-directory'=> self::OPTION_FTP_DIRECTORY,
            'ftp-username'=> self::OPTION_FTP_USERNAME,
            'ftp-password'=> self::OPTION_FTP_PASSWORD,
            'ftp-remote-file'=> self::OPTION_FTP_REMOTE_FILE,
            'xml-header'=> self::OPTION_XML_HEADER,
            'xml-receiver-id'=> self::OPTION_XML_RECEIVER_EMAIL,
            'xml-receiver-email'=> self::OPTION_XML_RECEIVER_EMAIL,
        ];
    }

    protected function getApplicationServiceClass(): string
    {
        return ExportService::class;
    }
}
