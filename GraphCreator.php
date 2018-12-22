<?php
/**
 * Класс, выполняющий создание графа слов из файла или массива.
 */
class GraphCreator
{
    /**
     * Создаёт граф слов из файла. Вторым аргументом можно передать фильтрующую функцию.
     *
     * @param string $fileName
     * @param callable|null $filter
     * @return WordGraph
     */
    public function createGraphFromFile($fileName)
    {
        $words = $this->loadWordsFromFile($fileName);
        return $this->createGraphFromWords($words);
    }

    /**
     * Загружает граф слов из файла. Вторым аргументом можно передать фильтрующую функцию.
     *
     * @param string $fileName
     * @param callable|null $filter
     * @return array
     */
    private function loadWordsFromFile($fileName): array
    {
        $file = fopen($fileName, 'r');
        $words = [];
        while (!feof($file)) {
            $word = trim(fgets($file));
            $words[] = $word;
        }
        return $words;
    }

    /**
     * Создаёт граф слов из списка слов.
     *
     * @param array $words
     * @return WordGraph
     */
    public function createGraphFromWords($words)
    {
        $graph = [];
        foreach ($words as $firstWord) {
            foreach ($words as $secondWord) {
                if ($this->stringsHaveOneCharDifference($firstWord, $secondWord)) {
                    $graph[$firstWord][] = $secondWord;
                }
            }
        }
        return $graph;
    }

    /**
     * Возвращает `true`, если две строки отличаются только на один символ, и `false` в обратном случае.
     *
     * @param string $str1
     * @param string $str2
     * @return bool
     */
    private function stringsHaveOneCharDifference($str1, $str2)
    {
        $distance = 0;
        if (\mb_strlen($str1) !== \mb_strlen($str2)) {
            return false;
        }
        $len = \mb_strlen($str1);
        for ($i = 0; $i < $len; $i++) {
            if (\mb_substr($str1, $i, 1) !== \mb_substr($str2, $i, 1)) {
                $distance++;
                if ($distance > 1) {
                    return false;
                }
            }
        }
        return $distance === 1;
    }
}
