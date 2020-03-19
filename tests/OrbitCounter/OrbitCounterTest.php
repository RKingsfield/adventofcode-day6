<?php

namespace App\Tests\OrbitCounter;

use PHPUnit\Framework\TestCase;

class OrbitCounterTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testOrbitCounterConstructor($input, $expectedResult)
    {
        $orbitCounter = new OrbitCounter($this->loadFileInput($input));
        $this->assertEquals($expectedResult, $orbitCounter->getOrbitalMap());
    }

    /**
     * @dataProvider dataProvider
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

    public function dataProvider()
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
            ],
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
