<?php

namespace App\OrbitalMap;

use InvalidArgumentException;

class OrbitalMap
{
    const ROUTE_NODE = 'COM';

    protected $map;

    public function __construct(string $inputMap)
    {
        $this->map[self::ROUTE_NODE] = [];
        $holding = [];
        foreach (explode(PHP_EOL, $inputMap) as $k => $orbitalBody) {
            $nodes = explode(')', $orbitalBody);
            if (count($nodes) !== 2) {
                throw new InvalidArgumentException('Invalid Orbital OrbitalMap given');
            }

            $parentNode = $nodes[0];
            $childNode = $nodes[1];
            if (isset($holding[$childNode])) {
                $childNode = [$childNode => $holding[$childNode]];
                unset($holding[$childNode]);
            }

            if ($route = $this->findRouteToNode($this->map, $parentNode)) {
                $this->addToMap($route, $childNode);
            } else {
                $holding[$parentNode] = $childNode;
            }
        }
    }

    protected function addToMap(array $route, string $child): self
    {
        $previousNode = &$this->map;
        foreach ($route as $nodeIndex) {
            $previousNode = &$previousNode[$nodeIndex];
        }

        $previousNode[$child] = [];
        return $this;
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

    public function asArray(): array
    {
        return $this->map;
    }

    public function countOrbits(string $n, bool $includeChildrenCount = true): int
    {
        $route = $this->findRouteToNode($this->map, $n);
        $count = count($route) - 1;
        if (!$includeChildrenCount) {
            return $count;
        }
        foreach ($this->getNode($route) as $childNodeIndex => $childNode) {
            $count += $this->countOrbits($childNodeIndex);
        }
        return $count;
    }

    public function countTotalOrbits(): int
    {
        return $this->countOrbits(self::ROUTE_NODE);
    }

    protected function getNode(array $route): array
    {
        $currentNode = $this->map;
        foreach ($route as $index) {
            $currentNode = $currentNode[$index];
        }
        return $currentNode;
    }
}
