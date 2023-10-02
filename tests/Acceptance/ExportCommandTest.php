<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Acceptance;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Sftp\SftpAdapter;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\ExportCommand;
use Productsup\BinCdeHeinemann\Tests\Helper\FixtureHelper;
use Productsup\BinCdeHeinemann\Tests\Mocks\MockProvider;
use Productsup\CDE\Tests\Tools\AbstractCommandTester;

final class ExportCommandTest extends AbstractCommandTester
{
    use MockProvider;
    use FixtureHelper;

    public const COMMAND_SUCCESS = 0;
    public const COMMAND_FAILURE = 1;
    public const ERROR_CODE_SUPPORT_LEVEL = 224;
    public const ERROR_CODE_ENGINEERING_LEVEL = 192;
    public const ERROR_CODE_CLIENT_LEVEL = 240;
    public const ERROR_CODE_FEEDBACK_FILE = 10;
    private const BASE_FIXTURES_PATH = __DIR__.'/../Fixtures/';
    private const OUTPUT_XML = '/data/productsup/output.xml';
    protected ?string $testConfigLocation = __DIR__.'/../config/services.yml';

    /** @dataProvider dataProvider */
    public function testExportCommand(
        array $commandOptions,
        int $expectedResult,
        array $expectedLogs,
        array $inputContent,
        Ftp $ftp,
        SftpAdapter $sftp,
        string $filePath,
        string $expectedFileContent
    ): void {
        $this->container->set(Ftp::class, $ftp);
        $this->container->set(SftpAdapter::class, $sftp);

        $this->buildMockClient();

        $this->populateInputContent($inputContent);
        if (!empty($calls)) {
            $this->appendCalls($calls);
        }
        $this->setUpFromCommandClass(ExportCommand::class);
        $this->execute($commandOptions);
        $this->checkLogs($expectedLogs);
        $this->assertEquals($expectedResult, $this->getStatusCode());

        $this->assertFileExists($filePath);
        $this->assertEquals(file_get_contents($expectedFileContent), file_get_contents($filePath));

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function dataProvider(): array
    {
        return [
            'full_success_ftp' => $this->getFullFtpSuccess(),
            'full_success_sftp' => $this->getFullSftpSuccess(),
            'ftp_connection_fail' => $this->getFtpConnectionFail(),
            'sftp_connection_fail' => $this->getSftpConnectionFail(),
            'ftp_fail' => $this->getFtpErrorFail(),
            'sftp_fail' => $this->getSftpErrorFail(),
        ];
    }

    private function getFullFtpSuccess(): array
    {
        return [
            'command_options' => $this->getCommandFtpOptions(),
            'expected_result' => self::COMMAND_SUCCESS,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'INFO: File generated for upload : /data/productsup/output.xml',
                'INFO: Exporting process finished successfully.',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'ftp' => $this->getFtpMock(),
            'sftp' => $this->getSftpMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }
    private function getFullSftpSuccess(): array
    {
        return [
            'command_options' => $this->getCommandSftpOptions(),
            'expected_result' => self::COMMAND_SUCCESS,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'INFO: File generated for upload : /data/productsup/output.xml',
                'INFO: Exporting process finished successfully.',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'ftp' => $this->getFtpMock(),
            'sftp' => $this->getSftpMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }
    private function getFtpConnectionFail(): array
    {
        return [
            'command_options' => $this->getCommandFtpOptions(),
            'expected_result' => self::ERROR_CODE_CLIENT_LEVEL,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'DEBUG: Executable execution failed',
                'ERROR: Failure: (240)',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'ftp' => $this->getConnectionExceptionFtpMock(),
            'sftp' => $this->getSftpMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }

    private function getSftpConnectionFail(): array
    {
        return [
            'command_options' => $this->getCommandSftpOptions(),
            'expected_result' => self::ERROR_CODE_CLIENT_LEVEL,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'DEBUG: Executable execution failed',
                'ERROR: Failure: (240)',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'ftp' => $this->getFtpMock(),
            'sftp' => $this->getConnectionExceptionSftpMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }

    private function getFtpErrorfail(): array
    {
        return [
            'command_options' => $this->getCommandFtpOptions(),
            'expected_result' => self::ERROR_CODE_ENGINEERING_LEVEL,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'DEBUG: Executable execution failed',
                'ERROR: Failure: (192)',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'ftp' => $this->getErrorFtpMock(),
            'sftp' => $this->getSftpMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }

    private function getSftpErrorFail(): array
    {
        return [
            'command_options' => $this->getCommandSftpOptions(),
            'expected_result' => self::ERROR_CODE_ENGINEERING_LEVEL,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'DEBUG: Executable execution failed',
                'ERROR: Failure: (192)',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'ftp' => $this->getFtpMock(),
            'sftp' => $this->getErrorSftpMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }
    private function getCommandFtpOptions(): array
    {
        return [
            '--ftp-host' => 'ftp://test-host.io/',
            '--ftp-port' => 21,
            '--ftp-username' => 'test-username',
            '--ftp-password' => 'test-password',
            '--ftp-directory' => '/test-dir',
            '--ftp-remote-file' => self::OUTPUT_XML,
        ];
    }
    private function getCommandSftpOptions(): array
    {
        return [
            '--ftp-host' => 'sftp://test-host.io/',
            '--ftp-port' => 22,
            '--ftp-username' => 'test-username',
            '--ftp-password' => 'test-password',
            '--ftp-directory' => '/test-dir',
            '--ftp-remote-file' => self::OUTPUT_XML,
        ];
    }
}
