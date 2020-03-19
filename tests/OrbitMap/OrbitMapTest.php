<?php

namespace App\Tests\OrbitMap;

use App\OrbitCounter\OrbitMap;
use PHPUnit\Framework\TestCase;

class OrbitMapTest extends TestCase
{
    /**
     * @dataProvider dataProviderForConstructor
     */
    public function testOrbitCounterConstructor($input, $expectedResult)
    {
        $orbitMap = new OrbitMap($this->loadFileInput($input));
        $this->assertEquals($expectedResult, $orbitMap->asArray());
    }

    /**
     * @dataProvider dataProviderForCounter
     * @depends testOrbitCounterConstructor
     */
    public function testOrbitCount($input, $expectedResult)
    {
        $orbitMap = new OrbitMap($this->loadFileInput($input));
        $this->assertEquals($expectedResult['D'], $orbitMap->countOrbits('D'));
        $this->assertEquals($expectedResult['L'], $orbitMap->countOrbits('L'));
        $this->assertEquals($expectedResult['all'], $orbitMap->countOrbits());
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
                    'COM' => [
                        'B' => [
                            'C' => [
                                'D' => [
                                    'E' => [
                                        'F' => [],
                                        'J' => [
                                            'K' => [
                                                'L' => []
                                            ]
                                        ]
                                    ],
                                    'I' => []
                                ]
                            ],
                            'G' => [
                                'H' => []
                            ]
                        ]
                    ]
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
            ]
        ];
    }

}
