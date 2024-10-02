<?php

namespace LTS\PhpDecliner;

/**
 * Класс для склонения существительных с числительным по падежам для языка ru_RU
 */
class DeclinerRussian implements DeclinerInterface
{
    /**
     * Таблица окончаний падежей
     *
     * Для каждого $number, слово с соответствующим ему окончанием находится в массиве слов на той же позиции, какое
     * число стоит в этой таблице по индексу $number (на позиции CASES[$number])
     */
    public const CASES = [2, 0, 1, 1, 1, 2, 2, 2, 2, 2];

    /**
     * @inheritDoc
     */
    public static function decline(int $number, array $words): string
    {
        if (empty($words[1])) {
            $words[1] = $words[0];
        }

        if (empty($words[2])) {
            $words[2] = $words[1];
        }

        /**
         * Если число в диапазоне 5-19 - у его числительного другие правила склонения
         */
        if (static::isGenitivePlural($number)) {
            return $words[2];
        }

        return $words[static::CASES[$number % 10]];
    }

    /**
     * Возвращает true, если переданный $number находится в диапазоне 5-19, т.к. по требованиям грамматики русского
     * языка, существительное рядом с таким числительным находится во множественном числе родительного падежа
     *
     * @param int $number
     *
     * @return bool
     */
    private static function isGenitivePlural(int $number): bool
    {
        return $number % 100 > 4 && $number % 100 < 20;
    }
}
