<?php

/*
 * Copyright 2023 Alessio.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace basin\impl;

use basin\concepts\Repository;
use basin\concepts\FetchPlan;
use basin\concepts\FieldsResolver;
use basin\concepts\Deserializer;

/**
 * Description of ObjectFetcher
 *
 * @author Alessio
 */
class ObjectResolverMultiComponents implements FieldsResolver {

    private $id;
    private $name;
    private $deserializer;

    /**
     *
     * @var FieldsResolver
     */
    private $primary;

    /**
     *
     * @var array<FieldsResolver>
     */
    private $resolvers;

    public function __construct(string $id, string $name, Deserializer $deserializer, FieldsResolver $primary, array $resolvers) {
        $this->name = $name;
        $this->deserializer = $deserializer;
        $this->primary = $primary;
        $this->resolvers = $resolvers;
    }
    
    public function id(): string {
        return $this->id;
    }

    public function fields(): array {
        return [ $this->name ];
    }

    public function resolve(Repository $repository, FetchPlan $plan, array $data): array {
        [ $query, $processed ] = $this->primary->to_query( ...$data );
        $associated = $repository->find_query( $query );

        foreach ( $this->resolvers as $resolver ) {
            $associated = $resolver->resolve( $this->repository, $plan, $associated );
        }

        $fk_name = '__fk_' . $this->primary->id();

        foreach ( $processed as &$record ) {
            $fk = $record[ $fk_name ];
            $linked = $this->find_index( $associated, $fk_name, $fk );

            if ( $linked === null ) {
                $record[ $this->name ] = null;
            } else {
                $record[ $this->name ] = $this->deserializer->instance( $linked );
            }
        }

        return $processed;
    }

    public function to_query(...$records): array {
        return $this->primary->to_query( ...$records );
    }

    private function find_index(array $list, string $index_name, ForeignIndex $index): ?array {
        foreach ( $list as $elem ) {
            if ( $index == $elem[ $index_name ] ) {
                return $elem;
            }
        }

        return null;
    }

}
