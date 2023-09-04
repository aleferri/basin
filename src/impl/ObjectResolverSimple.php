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
 * Description of ObjectResolverSingle
 *
 * @author Alessio
 */
class ObjectResolverSimple implements FieldsResolver {

    private $id;
    private $name;
    private $fields;
    private $relation;
    private $deserializer;
    private $source;

    public function __construct(string $id, string $name, string $fields, string $source, Relation $relation, Deserializer $deserializer) {
        $this->id = $id;
        $this->name = $name;
        $this->fields = $fields;
        $this->relation = $relation;
        $this->source = $source;
        $this->deserializer = $deserializer;
    }
    
    public function id(): string {
        return $this->id;
    }

    public function fields(): array {
        return [ $this->name ];
    }

    public function resolve(Repository $repository, FetchPlan $plan, array $data): array {
        [ $query, $processed ] = $this->to_query( ...$data );
        $associated = $repository->find_query( $query );

        $fk_name = '__fk_' . $this->id;

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
        [ $by_req, $map ] = $this->relation->prepare_links();

        $fk_name = '__fk_' . $this->name;

        foreach ( $records as &$record ) {
            $index = [];

            foreach ( $map as $left => $right ) {
                $by_req[ $right ][] = $record[ $left ];
                $index[] = $by_req[ $right ];
            }

            $record[ $fk_name ] = new ForeignIndexNative( $index );
        }
        
        unset( $record );

        return [ null, $records ];
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
