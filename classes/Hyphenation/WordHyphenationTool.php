<?php

namespace Hyphenation;

use AppConfig\Config;
use DB\DbWord;
use Log\LoggerInterface;
use SimpleCache\CacheInterface;

class WordHyphenationTool
{

    private $logger;
    private $patternFinder;
    private $hyphenatedWordGetter;
    private $hyphenatedWordSetter;

    public function __construct(LoggerInterface $logger, CacheInterface $cache, Config $config,
                                PatternLoaderInterface $patternLoader)
    {
        $this->logger = $logger;
        $dbWord = new DbWord($config);
        $this->patternFinder = new PatternFinder($logger, $cache, $config, $patternLoader);
        $this->hyphenatedWordGetter = new HyphenatedWordGetterProxy($dbWord, $cache, $config);
        $this->hyphenatedWordSetter = new HyphenatedWordSetterProxy($dbWord, $cache, $config);
    }

    /**
     * @return PatternFinder
     */
    public function getPatternFinder(): PatternFinder
    {
        return $this->patternFinder;
    }


    public function hyphenateWord(string $word): string
    {
        $resultStr = $this->hyphenatedWordGetter->get($word);
        if (empty($resultStr)) {
            $result = $this->patternFinder->findPatternsAndPushToWord(strtolower($word));
            $resultStr = $this->getResultStrFromResultArray($result);
            $this->logger->info('Word `{word}` hyphenated to `{hyphenateWord}`', array(
                'word' => $word,
                'hyphenateWord' => $resultStr
            ));
            $this->hyphenatedWordSetter->set($word, $resultStr, $this->patternFinder->getFoundPatternsAtWord());
        }
        $resultStr = substr($word, 0, 1) . substr($resultStr, 1);
        return $resultStr;
    }

    public function hyphenateAllText(string $text): string
    {
        $words = [];
        $count = preg_match_all('/[a-zA-Z]+[.,!?;:]*/', $text, $words);
        $words = $words[0];
        $currentWord = 1;
        foreach ($words as $word) {
            $this->logger->info('Processing word {current} / {total}', array(
                'current' => $currentWord,
                'total' => $count
            ));
            $word = preg_replace('/[.,!?;:]+/', '', $word);
            $hyphenatedWord = $this->hyphenateWord($word);
            $text = str_replace($word, $hyphenatedWord, $text);
            $currentWord++;
        }
        return $text;
    }

    private function getResultStrFromResultArray(array &$result): string
    {
        $resultStr = '';
        foreach ($result as $charData) {
            $resultStr .= $charData;
        }
        return $resultStr;
    }

}
