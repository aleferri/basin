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
 * Description of SimpleObjectResolver
 *
 * @author Alessio
 */
class SimpleObjectResolver implements FieldsResolver {

    private $name;
    private $fields;
    private $relation;
    private $deserializer;
    private $source;

    public function __construct(string $name, string $fields, string $source, Relation $relation, Deserializer $deserializer) {
        $this->name = $name;
        $this->fields = $fields;
        $this->relation = $relation;
        $this->source = $source;
        $this->deserializer = $deserializer;
    }

    public function fields(): array {
        return [ $this->name ];
    }

    public function resolve(Repository $repository, FetchPlan $plan, array $data): array {
        [ $query, $processed ] = $this->to_query( ...$data );
        $associated = $repository->find_query( $query );

        $fk_name = '__fk_' . $this->name;

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
        $by_req = [];

        $test = [];
        foreach ( $this->relation->map() as $entry ) {
            [ $left, $kind, $right ] = $entry;

            if ( $kind === Relation::IS_CONSTANT ) {
                $by_req[ $right ] = $left;
            } else {
                $by_req[ $right ] = [];
                $test[ $left ] = $right;
            }
        }

        $fk_name = '__fk_' . $this->name;

        foreach ( $records as &$record ) {
            $index = [];

            foreach ( $test as $left => $right ) {
                $by_req[ $right ][] = $record[ $left ];
                $index[] = $by_req[ $right ];
            }

            $record[ $fk_name ] = new ForeignIndexNative( $index );
        }

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
