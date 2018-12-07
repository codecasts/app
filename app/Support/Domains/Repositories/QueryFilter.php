<?php

namespace Codecasts\Support\Domains\Repositories;

use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Class QueryFilter.
 *
 * Abstract query filter class.
 */
abstract class QueryFilter
{
    /**
     * @var Collection
     */
    protected $params;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * MovementsFilterQuery constructor.
     *
     * @param Builder|EloquentBuilder  $query
     * @param array|Collection         $params
     */
    public function __construct($query, $params = null)
    {
        // assign query on instance.
        $this->query = $query;

        // assign parameters, casting as collection if needed.
        $this->params = is_array($params) ? collect($params) : $params;
    }

    /**
     * @return Builder
     */
    abstract public function getQuery();

    /**
     * WHERE.
     *
     * @param string       $fieldName
     * @param mixed|null   $candidate
     * @param string       $condition
     *
     * @return void
     */
    protected function where($fieldName, $candidate = null, $condition = '=')
    {
        // stop if not present.
        if (!$this->params->has($fieldName)) {
            return null;
        }

        // default to params when candidate is not passed as argument.
        if (!$candidate) {
            $candidate = $this->params->get($fieldName);
        }

        // apply where.
        $this->query->where($fieldName, $condition, $candidate);
    }

    /**
     * OR WHERE.
     *
     * @param string       $fieldName
     * @param mixed|null   $candidate
     * @param string       $condition
     *
     * @return void
     */
    protected function orWhere($fieldName, $candidate = null, $condition = '=')
    {
        // stop if not present.
        if (!$this->params->has($fieldName)) {
            return null;
        }

        // default to params when candidate is not passed as argument.
        if (!$candidate) {
            $candidate = $this->params->get($fieldName);
        }

        // apply where.
        $this->query->where($fieldName, $condition, $candidate);
    }

    /**
     * Filter items on a given key.
     *
     * @param $paramKey
     * @param $fieldName
     */
    protected function filterIn($paramKey, $fieldName)
    {
        // get all candidate values from parameters.
        $candidates = (array) $this->params->get($paramKey, []);

        // stop when there are not candidates.
        if (count($candidates) == 0) {
            return;
        }

        // filter records on the provided list.
        $this->query->whereIn($fieldName, $candidates);
    }

    /**
     * Filter a given field by a given range.
     *
     * @param $paramKey
     * @param $fieldName
     * @param bool $ignoreZero
     * @param string $castAs
     */
    protected function filterRange($paramKey, $fieldName, $ignoreZero = true, $castAs = 'integer')
    {
        // get range array.
        $range = (array) $this->params->get($paramKey, []);

        // range must be a two elements array.
        if (count($range) != 2) {
            return;
        }

        // expand min and max values.
        list($min, $max) = $range;

        // if casts is set as integer...
        if ($castAs == 'integer') {
            $min = (int) $min;
            $max = (int) $max;
        }

        // should not be null.
        $this->query->whereNotNull($fieldName);

        // when zero should be considered, or min value is not zero..
        if (!$ignoreZero || $min != 0) {
            // field must be at least $min.
            $this->query->where($fieldName, '>=', $min);
        }

        // when zero should be considered, or max value is not zero..
        if (!$ignoreZero || $max != 0) {
            // field must be at least $min.
            $this->query->where($fieldName, '<=', $max);
        }
    }
}