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
use basin\concepts\Filters;
use basin\concepts\FetchQueryBuilder;

/**
 * Description of SQLRepository
 *
 * @author Alessio
 */
class SQLRepository implements Repository {

    private $driver;
    private $factory;

    public function __construct(SQLDriver $driver, PropertyModelsFactory $factory) {
        $this->driver = $driver;
        $this->factory = $factory;
    }

    private function instance_all(array $records, ReadModel $model): array {
        $instances = [];

        foreach ( $records as $record ) {
            $instances[] = $this->instance( $record, $model );
        }

        return $instances;
    }

    private function instance(array $record, ReadModel $model): object|null {
        $instance = $model->class()->newInstanceWithoutConstructor();

        foreach ( $model->fields() as $property ) {
            $property_model = $this->factory->of( $property->settings[ 'name' ], $property->settings );
        }

        foreach ( $record as $key => $value ) {
            $properties = $model->assignables_from( $key );

            foreach ( $properties as $name ) {
                $attribute = $model->field( $name );

                $converted = $this->driver->convert_to( $value, $attribute->kind, $attribute->settings );

                $property = $model->class()->getProperty( $name );
                $property->setAccessible( true );
                $property->setValue( $instance, $converted );
            }
        }

        return $instance;
    }

    private function bin_fields(array $fields): array {
        $by_table = [];

        foreach ( $fields as $field ) {
            [ $table, $property ] = explode( '.', $field );
            if ( !isset( $by_table[ $table ] ) ) {
                $by_table[ $table ] = [];
            }

            $by_table[ $table ][] = $property;
        }

        return $by_table;
    }

    private function builder_for_fields(array $fields): array {
        $by_table = $this->bin_fields( $fields );

        foreach ( $by_table as $table => $properties ) {

            return [ $table, $this->driver
                        ->get_fetch_query_builder()
                        ->select( $properties )
                        ->from( $table ) ];
        }

        throw new \RuntimeException( 'Missing fields' );
    }

    private function create_condition(array $fields, string $op, mixed $value): array {
        $values = [];
        if ( count( $fields ) === 1 ) {
            $condition = $this->driver->condition_for( $fields[ 0 ], $op );
            $values[] = $value;
        } else {
            if ( !is_array( $value ) ) {
                throw new \IllegalArgumentException( "Condition is composite but passed value is single" );
            }
            $position = 0;
            $conditions = [];
            foreach ( $fields as $field ) {
                if ( isset( $value[ $field ] ) ) {
                    $data = $value[ $field ];
                } else {
                    $data = $value[ $position ];
                }

                $conditions[] = $this->driver->condition_for( $field, '=' );

                $values[] = $data;
                $position++;
            }

            $condition = implode( ' AND ', $conditions );
        }

        return [ $condition, $values ];
    }

    private function builder_from_meta(ReadModel $model): FetchQueryBuilder {
        $root_alias = 't0';

        $selection = [];

        foreach ( $model->fields() as $field ) {
            $selection[] = $root_alias . '.' . $field->settings[ 'name' ];
        }

        $builder = $this
                ->driver
                ->get_fetch_query_builder()
                ->from( $model->root(), $root_alias )
                ->select( ...$selection );

        return $builder;
        //newInstanceWithoutConstructor
    }

    public function fetch(string|array $fields, mixed $id): object|array|null {
        if ( is_array( $fields ) ) {
            [ $table, $builder ] = $this->builder_for_fields( $fields );
            $primary_key = $this->driver->find_primary_key( $table );

            [ $condition, $values ] = $this->create_condition( $primary_key, '=', $id );

            $query = $builder->filter_by( 'primary', $condition, $values )->into_query();

            return $this->driver->fetch( $query );
        }

        $read_model = ReadModel::parse( $fields );

        $builder = $this->builder_from_meta( $read_model );

        [ $condition, $values ] = $this->create_condition( $read_model->primary_key(), '=', $id );

        $query = $builder->filter_by( 'primary', $condition, $values )->into_query();

        $records = $this->driver->fetch( $query );

        if ( count( $records ) === 0 ) {
            return null;
        }

        return $this->instance( $records[ 0 ] );
    }

    public function find_all(string|array $fields, Filters $filters, ?\basin\concepts\Order $order_by): array {

    }

    public function find_next_batch(string|array $fields, Filters $filters, \basin\concepts\Cursor $cursor): array {

    }

    public function find_page(string|array $fields, Filters $filters, \basin\concepts\Page $page): array {

    }

    public function find_query(\basin\concepts\FetchQuery $query): array {

    }

    public function store(object|array $data): object|array {

    }

    public function store_all(array $data): array {

    }

    public function drop(object|array $data, int $policy = 1): bool {

    }
}
