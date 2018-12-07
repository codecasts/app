<?php

namespace Codecasts\Support\Domains;

use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
use Spatie\Fractal\Fractal;
use Codecasts\Support\Domains\Fractal\Transformer;

/**
 * Class Model.
 *
 * Abstract model to use when inheriting on domains.
 */
abstract class Model extends EloquentModel
{
    /**
     * @var string|null Transformer class name.
     */
    protected $transformerClass = Transformer::class;

    /**
     * @var bool MongoDB embeddable toggle.
     */
    protected $embeddable = false;

    /**
     * @return string
     */
    public function getTransformerClass()
    {
        return $this->transformerClass;
    }

    /**
     * @return Fractal
     *
     * @throws
     */
    public function transform()
    {
        return fractal()->item($this, $this->getTransformer())->getResource();
    }

    /**
     * @return Transformer
     */
    public function getTransformer()
    {
        $className = $this->getTransformerClass();

        if (!$className) {
            $className = Transformer::class;
        }

        return app()->make($className);
    }

    /**
     * Embeddable MongoDB model check.
     *
     * @return bool
     */
    public function isEmbeddable()
    {
        return $this->embeddable == true;
    }
}