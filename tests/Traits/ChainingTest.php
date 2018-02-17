<?php

use PHPUnit\Framework\TestCase;

class ChainingTest extends TestCase
{
    public function testChaining()
    {
        // Arrange
        $a = [4, 1, 2, 3];

        // Act

        $x = __::chain([0, 1, 2, 3, null])
            ->compact()
            ->prepend(4)
            ->value();

        // Assert
        $this->assertEquals($a, $x);
    }
}