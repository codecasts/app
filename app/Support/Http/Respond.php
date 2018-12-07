<?php

namespace Codecasts\Support\Http;

use Illuminate\Http\JsonResponse as Response;
use Codecasts\Support\Domains\Fractal\Manager;

/**
 * Class Respond
 *
 * HTTP response maker.
 */
class Respond
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Respond constructor.
     */
    public function __construct()
    {
        $this->manager = new Manager();
    }

    /**
     * Factory response.
     *
     * @param int $code
     * @param null $data
     * @param string $message
     * @param array $includes
     * @param array $meta
     * @param array $headers
     *
     * @return Response
     */
    public function factory($code = 200, $data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        $transformed = $this->manager->transform($data, $includes);

        $transformed->addMeta(['message' => $message]);

        if (count($meta)) {
            $transformed->addMeta($meta);
        }

        return new Response($transformed, $code, $headers);
    }

    /**
     * Generic response.
     *
     * @param null $data
     * @param string $message
     * @param array $includes
     * @param array $meta
     * @param array $headers
     *
     * @return Response
     */
    public function generic($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->factory(Response::HTTP_OK, $data, $message, $includes, $meta, $headers);
    }

    /**
     * OK response.
     *
     * @param null $data
     * @param string $message
     * @param array $includes
     * @param array $meta
     * @param array $headers
     *
     * @return Response
     */
    public function ok($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->generic($data, $message, $includes, $meta, $headers);
    }

    /**
     * Created response.
     *
     * @param null $data
     * @param string $message
     * @param array $includes
     * @param array $meta
     * @param array $headers
     *
     * @return Response
     */
    public function created($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->factory(Response::HTTP_CREATED, $data, $message, $includes, $meta, $headers);
    }

    /**
     * Accepted response.
     *
     * @param null $data
     * @param string $message
     * @param array $includes
     * @param array $meta
     * @param array $headers
     *
     * @return Response
     */
    public function accepted($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->factory(Response::HTTP_ACCEPTED, $data, $message, $includes, $meta, $headers);
    }

    /**
     * Updated response.
     *
     * @param null $data
     * @param string $message
     * @param array $includes
     * @param array $meta
     * @param array $headers
     *
     * @return Response
     */
    public function updated($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->accepted($data, $message, $includes, $meta, $headers);
    }

    /**
     * Deleted response.
     *
     * @param null $data
     * @param string $message
     * @param array $includes
     * @param array $meta
     * @param array $headers
     *
     * @return Response
     */
    public function deleted($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->accepted($data, $message, $includes, $meta, $headers);
    }

    /**
     * Invalid response (validator).
     *
     * @param array $errors
     * @param string $message
     * @param array $headers
     *
     * @return Response
     */
    public function invalid($errors = [], $message = 'Dados informados são inválidos.', $headers = [])
    {
        return $this->factory(Response::HTTP_UNPROCESSABLE_ENTITY, $errors, $message, $headers);
    }

    /**
     * Forbidden response.
     *
     * @param $message
     * @param array $headers
     *
     * @return Response
     */
    public function forbidden($message, $headers = [])
    {
        return $this->factory(Response::HTTP_FORBIDDEN, [], $message, [], $headers);
    }

    /**
     * Not found response.
     *
     * @param $message
     * @param array $headers
     * @return Response
     */
    public function notFound($message, $headers = [])
    {
        return $this->factory(Response::HTTP_NOT_FOUND, [], $message, [], $headers);
    }

    /**
     * Error response.
     *
     * @param array $data
     * @param string $message
     * @param array $headers
     * @param int $code
     *
     * @return Response
     */
    public function error($data = [], $message = '', $headers = [], $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->factory($code, $data, $message, [], $headers);
    }
}