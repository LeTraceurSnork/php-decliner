<?php

namespace LTS\PhpDecliner\Tests\DeclinerRussian;

use LTS\PhpDecliner\DeclinerRussian;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LTS\PhpDecliner\DeclinerRussian::decline
 * @covers \LTS\PhpDecliner\DeclinerRussian::isGenitivePlural
 */
class DeclineTest extends TestCase
{
    /**
     */
    public function testGenitivePlural(): void
    {
        $words = ['книга', 'книги', 'книг'];

        // Проверка на число в диапазоне 5-19
        $this->assertEquals('книг', DeclinerRussian::decline(5, $words));
        $this->assertEquals('книг', DeclinerRussian::decline(11, $words));
        $this->assertEquals('книг', DeclinerRussian::decline(19, $words));
        $this->assertEquals('книг', DeclinerRussian::decline(15, $words));
    }

    /**
     * Тест склонения для чисел, где используется правильная форма существительного
     */
    public function testNominativeOrGenitiveSingular(): void
    {
        $words = ['книга', 'книги', 'книг'];

        // Проверка для числа 1 (именительный падеж, единственное число)
        $this->assertEquals('книга', DeclinerRussian::decline(1, $words));

        // Проверка для чисел 2, 3, 4 (родительный падеж, единственное число)
        $this->assertEquals('книги', DeclinerRussian::decline(2, $words));
        $this->assertEquals('книги', DeclinerRussian::decline(3, $words));
        $this->assertEquals('книги', DeclinerRussian::decline(4, $words));

        // Проверка для чисел, оканчивающихся на 5-19
        for ($i = 5; $i < 20; $i++) {
            $this->assertEquals('книг', DeclinerRussian::decline($i, $words));
        }

        // Проверка для чисел 21, 31 и т.д. (правила как для числительных оканчивающихся на 1)
        $this->assertEquals('книга', DeclinerRussian::decline(21, $words));
        $this->assertEquals('книга', DeclinerRussian::decline(101, $words));

        // Проверка для чисел, оканчивающихся на 0
        for ($i = 0; $i <= 10; $i++) {
            $this->assertEquals('книг', DeclinerRussian::decline($i * 10, $words));
        }
    }

    /**
     * Тест несклоняемых слов
     *
     * @return void
     */
    public function testNonDeclinableWords(): void
    {
        $words = ['пальто'];

        for ($i = 0; $i < 25; $i++) {
            $this->assertEquals('пальто', DeclinerRussian::decline($i, $words));
        }
    }

    /**
     * Тест для больших чисел
     */
    public function testLargeNumbers(): void
    {
        $words = ['дом', 'дома', 'домов'];

        // Проверка на 100 и выше
        $this->assertEquals('домов', DeclinerRussian::decline(100, $words));
        $this->assertEquals('домов', DeclinerRussian::decline(111, $words));
        $this->assertEquals('дома', DeclinerRussian::decline(22, $words));
        $this->assertEquals('дом', DeclinerRussian::decline(121, $words));
    }
}
