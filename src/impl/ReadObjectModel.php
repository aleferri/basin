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
 * Description of ReadModel
 *
 * @author Alessio
 */
class ReadObjectModel implements DataModel {

    /**
     * Parse a class
     * @param string $classname
     * @return self
     * @throws \RuntimeException
     */
    public static function parse(string $classname): self {
        $class = new \ReflectionClass( $classname );

        $properties = $class->getProperties();

        $tables = $class->getAttributes( \basin\attributes\MapTable::class );
        if ( count( $tables ) < 1 ) {
            throw new \RuntimeException( 'no source table to start with' );
        }

        $root = $tables[ 0 ];

        $fields = [];
        $assign_from = [];

        $primary_key = [];

        foreach ( $properties as $property ) {
            $attributes = $property->getAttributes( \basin\attributes\MapPrimitive::class );

            if ( count( $attributes ) < 1 ) {
                continue;
            }

            $map = $attributes[ 0 ];
            $map->settings[ 'name' ] = $map->settings[ 'name' ] ?? $property->getName();
            $map->settings[ 'property' ] = $property->getName();

            if ( isset( $map->settings[ 'primary' ] ) ) {
                $primary_key[] = $map->settings[ 'name' ];
            }

            $assign_from[ $map->settings[ 'property' ] ] = $map->settings[ 'name' ];

            $fields[] = $map;
        }

        return new self( $class, $root->root, $fields, $assign_from, $primary_key );
    }

    private $class;
    private $root;
    private $fields;
    private $assign_from;
    private $primary_key;

    public function __construct(\ReflectionClass $class, string $root, array $fields, array $assign_from, array $primary_key) {
        $this->class = $class;
        $this->root = $root;
        $this->fields = $fields;
        $this->assign_from = $assign_from;
        $this->primary_key = $primary_key;
    }

    public function class(): \ReflectionClass {
        return $this->class;
    }

    public function root(): string {
        return $this->root;
    }

    public function fields(): array {
        return $this->fields;
    }

    public function field(string $name): object {
        foreach ( $this->fields as $field ) {
            if ( $field->settings[ 'name' ] === $name ) {
                return $field;
            }
        }

        throw new \RuntimeException( 'missing field ' . $name );
    }

    public function assignables_from(string $key): array {
        $list = [];
        foreach ( $this->assign_from as $property => $field ) {
            if ( $field === $key ) {
                $list[] = $property;
            }
        }

        return $list;
    }

    public function primary_key(): array {
        return $this->primary_key;
    }
}
