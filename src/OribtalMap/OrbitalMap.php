<?php

namespace App\OrbitalMap;

use InvalidArgumentException;

class OrbitalMap
{
    const ROUTE_NODE = 'COM';

    protected $map;
    protected $orbitalBodies;

    public function __construct(string $inputMap)
    {
        $this->map = [];
        $this->orbitalBodies = [];
        foreach (explode(PHP_EOL, $inputMap) as $k => $orbitalBody) {
            $nodes = explode(')', $orbitalBody);
            if (count($nodes) !== 2) {
                throw new InvalidArgumentException('Invalid Orbital OrbitalMap given');
            }

            $planetoid = $nodes[0];
            $satellite = $nodes[1];

            $this->map[$satellite] = $planetoid;
            $this->orbitalBodies[] = $planetoid;
            $this->orbitalBodies[] = $satellite;
        }
        $this->orbitalBodies = array_unique($this->orbitalBodies);
    }

    protected function getRouteToNode($n)
    {
        $route = [];
        $holdValue = $this->map[$n] ?? null;
        while (!is_null($holdValue)) {
            $route[] = $holdValue;
            $holdValue = $this->map[$holdValue] ?? null;
        }
        return $route;
    }

    public function asArray(): array
    {
        return $this->map;
    }

    public function countOrbits(string $n): int
    {
        return count($this->getRouteToNode($n));
    }

    public function countTotalOrbits(): int
    {
        $count = 0;
        foreach($this->orbitalBodies as $orbitalBody){
            $count += $this->countOrbits($orbitalBody);
        }
        return $count;
    }

    public function getShortestPath($node1, $node2)
    {
        $route1 = $this->getRouteToNode($node1);
        $route2 = $this->getRouteToNode($node2);
        $unsharedNodes = array_merge(array_diff($route1, $route2), array_diff($route2, $route1));
        return count($unsharedNodes);
    }
}
