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

/**
 * Description of MapRelation
 *
 * @author Alessio
 */
class MapRelation implements Relation {

    private $map;

    public function __construct( array $map ) {
        $this->map = $map;
    }

    public function foreign_index( array $data ): ForeignIndex {
        $index = [];

        foreach ( $this->map as $entry ) {
            $kind = $entry[ 1 ];
            $right = $entry[ 2 ];

            if ( $kind === Relation::IS_CONSTANT ) {
                continue;
            }

            $index[] = $data[ $right ];
        }

        return new ForeignIndexNative( $index );
    }

    public function is_constant( string $left ): bool {
        foreach ( $this->map as $entry ) {
            if ( $entry[ 0 ] === $left ) {
                return Relation::IS_CONSTANT == $entry[ 1 ];
            }
        }

        return false;
    }

    public function is_key( string $left ): bool {
        return !$this->is_constant( $left );
    }

    public function map(): array {
        return $this->map;
    }

    public function key_equality(): array {
        $map = [];

        foreach ( $this->map as $entry ) {
            [ $left, $kind, $right ] = $entry;

            if ( $kind === Relation::IS_CONSTANT ) {
                $map[ $left ] = $right;
            }
        }

        return $map;
    }
    
    public function prepare_links(): array {
        $dynamic = [];
        $all = [];

        foreach ( $this->map as $entry ) {
            [ $left, $kind, $right ] = $entry;

            if ( $kind === Relation::IS_CONSTANT ) {
                $all[ $right ] = $left;
            } else {
                $all[ $right ] = [];
                $dynamic[ $left ] = $right;
            }
        }

        return [ $all, $dynamic ];
    }
}
