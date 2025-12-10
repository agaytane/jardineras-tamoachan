<?php
namespace App;

use Exception;
use ReflectionClass;

class Container {
    private $bindings = [];

    /**
     * Registrar una dependencia (binding).
     * @param string $id Identificador (Clase o Interfaz)
     * @param callable $factory Función que retorna la instancia
     */
    public function set($id, callable $factory)
    {
        $this->bindings[$id] = $factory;
    }

    /**
     * Obtener una dependencia registrada.
     */
    public function get($id)
    {
        if (!isset($this->bindings[$id])) {
            throw new Exception("Dependencia no encontrada: {$id}");
        }

        // Ejecutar el factory para obtener la instancia
        return $this->bindings[$id]($this);
    }

    /**
     * Resolver (Auto-wire) una clase automáticamente
     */
    public function resolve($class)
    {
        // 1. Si ya está registrada explícitamente, úsala
        if (isset($this->bindings[$class])) {
            return $this->get($class);
        }

        // 2. Usar Reflection para inspeccionar la clase
        $reflector = new ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new Exception("La clase {$class} no se puede instanciar.");
        }

        // 3. Inspeccionar el constructor
        $constructor = $reflector->getConstructor();

        // Si no hay constructor, instanciar y listo
        if (is_null($constructor)) {
            return new $class;
        }

        // 4. Inspeccionar los parámetros del constructor
        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                // Es una clase/interfaz -> Resolver recursivamente
                $dependencies[] = $this->resolve($type->getName());
            } else {
                // Es un primitivo o no tiene tipo -> No podemos resolverlo automáticamente
                // (Podríamos agregar lógica para parámetros por defecto aquí)
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("No se puede resolver la dependencia '{$parameter->getName()}' en la clase '{$class}'");
                }
            }
        }

        // 5. Crear la instancia con las dependencias resueltas
        return $reflector->newInstanceArgs($dependencies);
    }
}
