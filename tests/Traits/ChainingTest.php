<?php

use PHPUnit\Framework\TestCase;

class ChainingTest extends TestCase
{
    public function testTODO()
    {
        // Arrange
        $a = 'testing';

        // Act
        $x = $a;

        // Assert
        $this->assertEquals('testing', $x);
    }
}