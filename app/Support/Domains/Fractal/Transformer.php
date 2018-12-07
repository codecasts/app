<?php

namespace Codecasts\Support\Domains\Fractal;

use Illuminate\Contracts\Support\Arrayable;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class Transformer.
 *
 * Abstract/Generic transformer class.
 */
class Transformer extends TransformerAbstract
{
    /**
     * Choose between transform and transformAbstract methods.
     *
     * @param $name
     * @param $arguments
     *
     * @return array|Item|Collection|mixed
     */
    function __call($name, $arguments)
    {
        if ($name == 'transform' && !method_exists($this, 'transform')) {
            $name = 'transformAbstract';
        }
        return $this->$name(...$arguments);
    }

    /**
     * Generic transform method.
     *
     * @param mixed $data
     *
     * @return array
     */
    public function transformAbstract($data)
    {
        if (is_array($data)) {
            return $data;
        }

        if (is_object($data) && $data instanceof Arrayable) {
            return $data->toArray();
        }

        return (array) $data;
    }

    /**
     * Create a fractal item.
     *
     * @param mixed                        $data
     * @param TransformerAbstract|callable $transformer
     * @param string                       $resourceKey
     *
     * @return Item
     */
    protected function item($data, $transformer = null, $resourceKey = null)
    {
        if (!$transformer && method_exists($data, 'getTransformer')) {
            $transformer = $data->getTransformer();
        }

        if (!$transformer) {
            $transformer = new Transformer();
        }

        return new Item($data, $transformer, $resourceKey ?? false);
    }

    /**
     * Create a fractal collection.
     *
     * @param mixed                        $data
     * @param TransformerAbstract|callable $transformer
     * @param string                       $resourceKey
     *
     * @return Collection
     */
    protected function collection($data, $transformer = null, $resourceKey = null)
    {
        if (!$transformer && method_exists($data, 'getTransformer')) {
            $transformer = $data->getTransformer();
        }

        if (!$transformer) {
            $transformer = new Transformer();
        }

        return new Collection($data, $transformer, $resourceKey ?? false);
    }
}
