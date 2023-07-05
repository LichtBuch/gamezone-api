<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

class DeletedExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface {

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void {
        $this->addWhere($queryBuilder, $resourceClass, $context);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void {
        $this->addWhere($queryBuilder, $resourceClass, $context);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass, array $context): void {
        if (!is_a($resourceClass, IDeleted::class, true)) {
            return;
        }

        if (isset($context['filter']['deleted'])) {
            return;
        }

        [$rootAlias] = $queryBuilder->getRootAliases();
        $queryBuilder->andWhere("$rootAlias.deleted = :deleted");
        $queryBuilder->setParameter('deleted', false);
    }

}
