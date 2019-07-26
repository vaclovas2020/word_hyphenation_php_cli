<?php


use AppConfig\Config;
use AppConfig\DbConfig;
use Hyphenation\WordHyphenationTool;
use Log\Logger;
use PHPUnit\Framework\TestCase;
use SimpleCache\FileCache;

class WordHyphenationToolTest extends TestCase
{

    private $logger;
    private $cache;
    private $config;

    /**
     * @dataProvider provider
     */
    public function testHyphenateWord(string $word, string $hyphenatedWord): void
    {
        $hyphenationTool = new WordHyphenationTool($this->logger, $this->cache, $this->config);
        $this->assertEquals($hyphenatedWord, $hyphenationTool->hyphenateWord($word),
            "Test failed: $word not hyphenated to $hyphenatedWord");
    }


    public function provider(): array
    {
        return array(
            array('mistranslate', 'mis-trans-late'),
            array('catfish', 'cat-fish'),
            array('network', 'net-work')
        );
    }

    /**
     * @dataProvider provider
     */
    public function testGetFoundPatternsOfWord(string $word): void
    {
        $hyphenationTool = new WordHyphenationTool($this->logger, $this->cache, $this->config);
        $this->assertNotEmpty($hyphenationTool->getFoundPatternsOfWord($word),
            "getFoundPatternsOfWord return empty array when given word is $word");
    }

    protected function setup(): void
    {
        $this->logger = $this->createMock(Logger::class);
        $this->cache = $this->createMock(FileCache::class);
        $this->config = $this->createMock(Config::class);
        $this->config
            ->method('getDbConfig')
            ->willReturn(DbConfig::getInstance(
                'localhost',
                'word_hyphenation_db',
                'root',
                'Q1w5e9r7t5y3@',
                $this->logger, true));
    }
}