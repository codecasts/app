<?php

namespace Codecasts\Support\Domains\Fractal;

use League\Fractal\Serializer\DataArraySerializer as BaseSerializer;

class DataArraySerializer extends BaseSerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }

        return ['data' => $data];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }

        return ['data' => $data];
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null()
    {
        return null;
    }
}