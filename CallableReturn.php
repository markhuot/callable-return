<?php

namespace App;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

class CallableReturn implements TypeNodeResolverExtension
{
    public function resolve(TypeNode $typeNode, NameScope $nameScope): ?Type
    {
        if (!$typeNode instanceof GenericTypeNode) {
            return null;
        }

        $typeName = $typeNode->type;
        if ($typeName->name !== 'callable-return') {
            return null;
        }

        return new CallableReturnType($typeNode->genericTypes[0], null, null);

        // return new CallableReturnType($typeNode->type, $this->ancestorClassName, $this->templateTypeName);
        // return new \PHPStan\Type\Accessory\NonEmptyArrayType();

        // return new \PHPStan\Type\StringType();
    }
}
