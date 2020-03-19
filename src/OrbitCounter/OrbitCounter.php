<?php

namespace App\OrbitCounter;

use InvalidArgumentException;

class OrbitMap
{
    protected $map;

    public function __construct(string $inputMap)
    {
        $map['COM'] = [];
        $holding = [];
        foreach (explode(PHP_EOL, $inputMap) as $k => $orbitalBody) {
            $nodes = explode(')', $orbitalBody);
            if (count($nodes) !== 2) {
                throw new InvalidArgumentException('Invalid Orbital Map given');
            }

            $parentNode = $nodes[0];
            $childNode = $nodes[1];
            if (isset($holding[$childNode])) {
                $childNode = [$childNode => $holding[$childNode]];
                unset($holding[$childNode]);
            }

            if ($route = $this->findRouteToNode($map, $parentNode)) {
                $map = $this->addToMap($map, $route, $childNode);
            } else {
                $holding[$parentNode] = $childNode;
            }
        }
        $this->map = $map;
    }

    protected function addToMap(array $map, array $route, string $child): array
    {
        $previousNode = &$map;
        foreach ($route as $nodeIndex) {
            $previousNode = &$previousNode[$nodeIndex];
        }

        $previousNode[$child] = [];
        return $map;
    }

    protected function findRouteToNode(array $map, string $nodeToFind): ?array
    {
        if (isset($map[$nodeToFind])) {
            return [$nodeToFind];
        }

        foreach ($map as $currentNode => $subMap) {
            if ($route = $this->findRouteToNode($subMap, $nodeToFind)) {
                array_unshift($route, $currentNode);
                return $route;
            }
        }

        return null;
    }

    public function getOrbitalMap(): array
    {
        return $this->map;
    }
}
