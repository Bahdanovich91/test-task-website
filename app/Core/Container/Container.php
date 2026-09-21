<?php

declare(strict_types=1);

namespace App\Core\Container;

use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

final class Container
{
    private array $instances = [];

    /**
     * @throws ReflectionException
     */
    public function get(string $class): object
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return $this->instances[$class] = new $class();
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ReflectionException(
                    "Cannot resolve dependency: {$parameter->getName()}"
                );
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $this->instances[$class] = $reflection->newInstanceArgs($dependencies);
    }
}
