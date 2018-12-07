<?php

namespace Codecasts\Support\Domains\Fractal;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

/**
 * Class Manager.
 *
 * Fractal / Data manager.
 */
class Manager
{
    /**
     * Transform a given resource.
     *
     * @param $resource
     * @param array $includes
     * @param TransformerAbstract|null $transformer
     *
     * @return Fractal
     */
    public function transform($resource = [], $includes = [], TransformerAbstract $transformer = null)
    {
        // guess a transformer if none was explicitly provided.
        if (!$transformer) {
            $transformer = $this->extractTransformer($resource);
        }

        // if the resource is paginated, transform with pagination.
        if ($this->isPaginated($resource)) {
            return \fractal()->collection($resource, $transformer)
                ->paginateWith(new IlluminatePaginatorAdapter($resource))
                ->parseIncludes($includes);
        }

        // if non paginated collection, transform as it is.
        if ($this->isCollection($resource)) {
            return \fractal()->collection($resource, $transformer)->parseIncludes($includes);
        }

        // transform as item if no collection or paginated collection.
        return \fractal()->item($resource, $transformer)->parseIncludes($includes);
    }

    /**
     * Collection type check.
     *
     * @param $resource
     *
     * @return bool
     */
    protected function isCollection($resource)
    {
        return $resource instanceof Collection;
    }

    /**
     * Pagination type check.
     *
     * @param $resource
     *
     * @return bool
     */
    protected function isPaginated($resource)
    {
        return $resource instanceof LengthAwarePaginator;
    }

    /**
     * Object type check.
     *
     * @param $resource
     *
     * @return bool
     */
    protected function isObject($resource)
    {
        return is_object($resource);
    }

    /**
     * Model type check.
     *
     * @param $resource
     *
     * @return bool
     */
    protected function isModel($resource)
    {
        return $resource instanceof Model;
    }


    /**
     * Extract first item on a collection to guess it's type.
     *
     * @param $resource
     *
     * @return mixed
     */
    public function extractFirst($resource)
    {
        if ($this->isPaginated($resource) || $this->isCollection($resource)) {
            return $resource->first();
        }

        return $resource;
    }

    /**
     * Extract / detect transformer to use.
     *
     * @param $resource
     *
     * @return Transformer|null
     */
    public function extractTransformer($resource)
    {
        // start with no transformer.
        $transformer = null;

        // extract first item or use single if not collection.
        $mayTransform = $this->extractFirst($resource);

        // try extracting the transformer for the resource.
        if ($mayTransform && $this->isObject($mayTransform) && method_exists($mayTransform, 'getTransformer')) {
            // if transformable, get the transformer instance.
            $transformer = $mayTransform->getTransformer();
        }

        // use extracted transformer, or use generic one.
        return $transformer ?? new Transformer();
    }
}