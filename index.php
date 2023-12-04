<?php

class AnInvokableClass
{
    public function __invoke(): string
    {
        return 'foo';
    }
}

/**
 * @template T
 * @param class-string<T> $class
 * @return callable-return<T>
 */
function invoke(string $class): mixed
{
    return (new $class)();
}

$foo = invoke(AnInvokableClass::class);
\PHPStan\dumpType($foo);
