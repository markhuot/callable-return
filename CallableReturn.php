<?php

namespace App;

use PHPStan\Analyser\NameScope;
use PHPStan\Analyser\OutOfClassScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

class CallableReturn implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension
{
    protected TypeNodeResolver $typeNodeResolver;

    public function setTypeNodeResolver(TypeNodeResolver $typeNodeResolver): void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }

    public function resolve(TypeNode $typeNode, NameScope $nameScope): ?Type
    {
        if (!$typeNode instanceof GenericTypeNode) {
            return null;
        }

        $typeName = $typeNode->type;
        if ($typeName->name !== 'callable-return') {
            return null;
        }

        $type = $this->typeNodeResolver->resolve($typeNode->genericTypes[0], $nameScope);
        $variant = ParametersAcceptorSelector::selectSingle($type->getCallableParametersAcceptors(new OutOfClassScope()));
        return $variant->getReturnType();

        // return new CallableReturnType($typeNode->genericTypes[0], null, null);

        // return new CallableReturnType($typeNode->type, $this->ancestorClassName, $this->templateTypeName);
        // return new \PHPStan\Type\Accessory\NonEmptyArrayType();

         // return new \PHPStan\Type\StringType();
    }
}
