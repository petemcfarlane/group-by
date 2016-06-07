<?php

namespace PeteMc\GroupBy;

/**
 * Group an array of items by key.
 *
 * @param array $items
 * @param string|callable $key
 *
 * @return array[]
 */
function groupBy(array $items, $key)
{
    if (is_string($key)) {
        return array_reduce($items, function ($acc, $item) use ($key) {
            $acc[$item[$key]][] = $item;
            return $acc;
        }, []);
    }

    if (is_callable($key)) {
        return array_reduce($items, function ($acc, $item) use ($key) {
            $acc[$key($item)][] = $item;
            return $acc;
        }, []);
    }

    throw new \InvalidArgumentException("$key must be string or callable");
}
