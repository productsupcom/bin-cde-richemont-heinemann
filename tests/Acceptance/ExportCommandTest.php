<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Acceptance;

use League\Flysystem\Adapter\Ftp;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\ExportCommand;
use Productsup\BinCdeHeinemann\Tests\Helper\FixtureHelper;
use Productsup\BinCdeHeinemann\Tests\Mocks\MockProvider;
use Productsup\CDE\Tests\Tools\AbstractCommandTester;

final class ExportCommandTest extends AbstractCommandTester
{
    use MockProvider;
    use FixtureHelper;

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
        string $filePath,
        string $expectedFileContent
    ): void {
        $this->container->set(Ftp::class, $ftp);

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
            'full_success_s3' => $this->getFullFtpSuccess(),
            'ftp_connection_fail' => $this->getFtpConnectionFail(),
            'ftp_fail' => $this->getFtpErrorFail(),
        ];
    }

    private function getFullFtpSuccess(): array
    {
        return [
            'command_options' => $this->getCommandFtpOptions(),
            'expected_result' => ExitCodes::COMMAND_SUCCESS,
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
            'expected_result' => ExitCodes::ERROR_CODE_CLIENT_LEVEL,
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

    private function getFtpErrorfail(): array
    {
        return [
            'command_options' => $this->getCommandFtpOptions(),
            'expected_result' => ExitCodes::ERROR_CODE_ENGINEERING_LEVEL,
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
}
