<?php

namespace Mediadesk\GitLogger;

use Mediadesk\GitLogger\Contracts\LoggingContracts;
use ReflectionClass;

class GitLogger
{

    /**
     * @var array<string, LoggingContracts> $adapters An array of Git logging adapter instances.
     */
     protected $adapters = [
        'bitbucket' => \Mediadesk\GitLogger\Services\BitBucket::class,
    ];


    /**
     * @var LoggingContracts Git logging adapter instance.
     */
    protected $adapter;

    public function __construct(string $service_name)
    {
        if (!isset($this->adapters[$service_name])) {
            throw new \InvalidArgumentException("Invalid git service: {$service_name}");
        }

        $adapter_class = $this->adapters[$service_name];

        $reflection_class = new ReflectionClass($adapter_class);

        $this->adapter = $reflection_class->newInstance(request());
    }

    public function get(): array
    {
        return $this->adapter->get();
    }

}

