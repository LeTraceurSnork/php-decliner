<?php

namespace LTS\PhpDecliner;

/**
 *  This interface defines the methods required for implementing noun declension.
 *  Classes that implement this interface should provide functionality to decline
 *  nouns according to grammatical cases and numerals of corresponding language.
 */
interface DeclinerInterface
{
    /**
     * @param int      $number Number of items
     * @param string[] $words  Declensions of item's name
     *
     * @return string
     */
    public static function decline(int $number, array $words): string;
}
