<?php

namespace App\Tests\OrbitCounter;

use App\OrbitCounter\OrbitCounter;
use PHPUnit\Framework\TestCase;

class OrbitCounterTest extends TestCase
{

    /**
     * @dataProvider dataProviderForConstructor
     */
    public function testOrbitCounterConstructor($input, $expectedResult)
    {
        $orbitCounter = new OrbitCounter($this->loadFileInput($input));
        $this->assertEquals($expectedResult, $orbitCounter->getOrbitalMap());
    }

    /**
     * @dataProvider dataProviderForCounter
     * @depends testOrbitCounterConstructor
     */
    public function testOrbitCount($input, $expectedResult)
    {
        $orbitCounter = new OrbitCounter($this->loadFileInput($input));
        $this->assertEquals($expectedResult['D'], $orbitCounter->countOrbits('D'));
        $this->assertEquals($expectedResult['L'], $orbitCounter->countOrbits('L'));
        $this->assertEquals($expectedResult['all'], $orbitCounter->countOrbits());
    }

    protected function loadFileInput($expectedFilePath)
    {
        return file_get_contents($expectedFilePath);
    }

    public function dataProviderForConstructor()
    {
        return [
            [
                __DIR__ . '/input/orbitalMap.txt',
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
                __DIR__ . '/input/orbitalMap.txt',
                [
                    'D' => 3,
                    'L' => 7,
                    'all' => 42
                ]
            ]
        ];
    }

}
