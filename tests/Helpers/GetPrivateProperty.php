<?php

function get_private_property($object, $property): mixed
{
    $reflection = new ReflectionClass($object);
    $property = $reflection->getProperty($property);
    $property->setAccessible(true);

    return $property->getValue($object);
}
