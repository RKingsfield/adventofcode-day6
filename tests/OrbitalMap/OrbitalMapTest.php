<?php

namespace App\Tests\OrbitalMap;

use App\OrbitalMap\OrbitalMap;
use PHPUnit\Framework\TestCase;

class OrbitalMapTest extends TestCase
{
    /**
     * @dataProvider dataProviderForConstructor
     */
    public function testOrbitCounterConstructor($input, $expectedResult)
    {
        $orbitMap = new OrbitalMap($this->loadFileInput($input));
        $this->assertEquals($expectedResult, $orbitMap->asArray());
    }

    /**
     * @dataProvider dataProviderForCounter
     * @depends      testOrbitCounterConstructor
     */
    public function testOrbitCount($input, $expectedResult)
    {
        $orbitMap = new OrbitalMap($this->loadFileInput($input));
        $this->assertEquals($expectedResult['D'], $orbitMap->countOrbits('D'));
        $this->assertEquals($expectedResult['L'], $orbitMap->countOrbits('L'));
        $this->assertEquals($expectedResult['all'], $orbitMap->countTotalOrbits());
    }

    protected function loadFileInput($expectedFilePath)
    {
        return file_get_contents($expectedFilePath);
    }

    public function dataProviderForConstructor()
    {
        return [
            [
                __DIR__ . '/input/rawInput.txt',
                [
                    'B' => 'COM',
                    'C' => 'B',
                    'D' => 'C',
                    'E' => 'D',
                    'F' => 'E',
                    'G' => 'B',
                    'H' => 'G',
                    'I' => 'D',
                    'J' => 'E',
                    'K' => 'J',
                    'L' => 'K'
                ]
            ]
        ];
    }

    public function dataProviderForCounter()
    {
        return [
            [
                __DIR__ . '/input/rawInput.txt',
                [
                    'D' => 3,
                    'L' => 7,
                    'all' => 42
                ]
            ],
            [
                __DIR__ . '/input/rawComplexInput.txt',
                [
                    'D' => 3,
                    'L' => 7,
                    'all' => 42
                ]
            ],
            [
                __DIR__ . '/input/largeInput.txt',
                [
                    'D' => 0,
                    'L' => 0,
                    'all' => 227612
                ]
            ]
        ];
    }

}
