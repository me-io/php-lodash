<?php

use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    public function testAppend()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = \__::append($a, 4);

        // Assert
        $this->assertEquals([1, 2, 3, 4], $x);
    }

    public function testCompact()
    {
        // Arrange
        $a = [0, 1, false, 2, '', 3];

        // Act
        $x = \__::compact($a);

        // Assert
        $this->assertEquals([1, 2, 3], $x);
    }

    public function testFlatten()
    {
        // Arrange
        $a  = [1, 2, [3, [4]]];
        $a2 = [1, 2, [3, [[4]]]];

        // Act
        $x  = \__::flatten($a);
        $x2 = \__::flatten($a2, true);

        // Assert
        $this->assertEquals([1, 2, 3, 4], $x);
        $this->assertEquals([1, 2, 3, [[4]]], $x2);
    }

    public function testPatch()
    {
        // Arrange
        $a = [1, 1, 1, 'contacts' => ['country' => 'US', 'tel' => [123]], 99];
        $p = ['/0' => 2, '/1' => 3, '/contacts/country' => 'CA', '/contacts/tel/0' => 3456];

        // Act
        $x = \__::patch($a, $p);

        // Assert
        $this->assertEquals([2, 3, 1, 'contacts' => ['country' => 'CA', 'tel' => [3456]], 99], $x);
    }

    public function testPrepend()
    {
        // Arrange
        $a = [1, 2, 3];

        // Act
        $x = \__::prepend($a, 4);

        // Assert
        $this->assertEquals([4, 1, 2, 3], $x);
    }

    public function testRange()
    {
        // Act
        $x = \__::range(5);
        $y = \__::range(-2, 2);
        $z = \__::range(1, 10, 2);

        // Assert
        $this->assertEquals([1, 2, 3, 4, 5], $x);
        $this->assertEquals([-2, -1, 0, 1, 2], $y);
        $this->assertEquals([1, 3, 5, 7, 9], $z);
    }

    public function testRepeat()
    {
        // Act
        $x = \__::repeat('foo', 3);

        // Assert
        $this->assertEquals(['foo', 'foo', 'foo'], $x);

        // Act
        $x = \__::repeat('foo', null);

        // Assert
        $this->assertEquals([], $x);
    }

    public function testChunk()
    {
        // Act
        $x = \__::chunk([1, 2, 3, 4, 5], 3);

        // Assert
        $this->assertEquals([1, 2, 3], $x[0]);

        // Assert
        $this->assertEquals([4, 5], $x[1]);
    }

    public function testDrop()
    {
        // Act
        $x = \__::drop([1, 2, 3], 2);

        // Assert
        $this->assertEquals([3], $x);
    }

    public function testRandomize()
    {
        // Act
        $x = \__::randomize([1, 2, 3, 4, 5]);

        // Assert
        $this->assertNotEquals([1, 2, 3, 4, 5], $x);
    }

    public function testSearch()
    {
        // Act
        $x = __::search(['a', 'b', 'c'], 'b');

        // Assert
        $this->assertEquals(1, $x);
    }

    public function testContains()
    {
        // Act
        $x = __::contains(['a', 'b', 'c'], 'b');

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testAverage()
    {
        // Act
        $x = __::average([1, 2, 3]);

        // Assert
        $this->assertEquals(2, $x);
    }

    public function testSize()
    {
        // Act
        $x = __::size([1, 2, 3]);

        // Assert
        $this->assertEquals(3, $x);
    }

    public function testClean()
    {
        // Act
        $x = __::clean([true, false, 0, 1, 'string', '']);

        // Assert
        $this->assertEquals([true, 1, 'string'], $x);
    }

    public function testRandom()
    {
        // Act
        $x = __::random([1, 2, 3]);

        // Assert
        $this->assertTrue(in_array($x, [1, 2, 3]));
    }

    public function testIntersection()
    {
        // Act
        $x = __::intersection(["green", "red", "blue"], ["green", "yellow", "red"]);

        // Assert
        $this->assertEquals(["green", "red"], $x);
    }

    public function testIntersects()
    {
        // Act
        $x = __::intersects(["green", "red", "blue"], ["green", "yellow", "red"]);

        // Assert
        $this->assertEquals(true, $x);
    }

    public function testInitial()
    {
        // Act
        $x = __::initial([1, 2, 3], 1);

        // Assert
        $this->assertEquals([1, 2], $x);
    }

    public function testRest()
    {
        // Act
        $x = __::rest([1, 2, 3], 2);

        // Assert
        $this->assertEquals([3], $x);
    }
}