<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Acceptance;

use League\Flysystem\Filesystem;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\ExportCommand;
use Productsup\BinCdeHeinemann\Tests\Helper\FixtureHelper;
use Productsup\BinCdeHeinemann\Tests\Mocks\MockProvider;
use Productsup\CDE\ContainerApi\BaseClient\Client;
use Productsup\CDE\Tests\Tools\AbstractCommandTester;

final class ExportCommandTest extends AbstractCommandTester
{
    use MockProvider;
    use FixtureHelper;

    private const BASE_FIXTURES_PATH = __DIR__.'/../Fixtures/';
    private const OUTPUT_XML =  'vfs://root/output.xml';
    protected ?string $testConfigLocation = __DIR__.'/../config/services.yml';

    /** @dataProvider dataProvider */
    public function testExportCommand(
        array $commandOptions,
        int $expectedResult,
        array $expectedLogs,
        array $inputContent,
        Filesystem $filesystem,
        Client $client,
        string $filePath,
        string $expectedFileContent
    ): void {
        $this->container->set(Filesystem::class, $filesystem);
        $this->container->set(Client::class, $client);
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
    }

    public function dataProvider(): array
    {
        return [
            'full_success_s3' => $this->getFullS3Success(),
            'filesystem_exception' => $this->getFilesystemException(),
        ];
    }

    private function getFullS3Success(): array
    {
        return [
            'command_options' => $this->getCommandFtpOptions(),
            'expected_result' => ExitCodes::COMMAND_SUCCESS,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'INFO: File generated for upload: vfs://root/output.xml',
                'INFO: Exporting process finished successfully.',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'filesystem' => $this->getFileSystemMock(),
            'client' =>  $this->getClientMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }

    private function getFilesystemException(): array
    {
        return [
            'command_options' => $this->getCommandFtpOptions(),
            'expected_result' => ExitCodes::ERROR_CODE_ENGINEERING_LEVEL,
            'expected_logs' => [
                'INFO: Starting the export.',
                'INFO: Creating XML file.',
                'INFO: File generated for upload: vfs://root/output.xml',
                'DEBUG: Exception encountered.',
                'ERROR: Process was terminated. An exception encountered during the run. If the problem persist, please contact the support.',
            ],
            'content' => json_decode($this->getFixture(self::BASE_FIXTURES_PATH, 'full_input_data.json'), true),
            'filesystem' => $this->getErrorFilesystemMock(),
            'client' =>  $this->getClientMock(),
            'filePath' => self::OUTPUT_XML,
            'expectedFileContent' => self::BASE_FIXTURES_PATH.'expected_success.xml',
        ];
    }

    private function getCommandFtpOptions(): array
    {
        return [
            '--access-key-id' => 'test',
            '--secret-access-key' => 'test',
            '--bucket' => 'test',
            '--region' => 'test',
            '--filename' => self::OUTPUT_XML,
        ];
    }
}
