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

namespace basin\concepts;

/**
 *
 * Fetch plan for an entity, suppose we want to fetch a complex object in the form Order{id, order_number, billing_data, shipment_data, items, fees):
 * we group properties in the tables and deconstruct inline objects:
 * id, order_number, billing_data{...}, shipment_data{...} from orders;
 * items from orders_lines {order_id = id, kind = 'item'}
 * fees from orders_lines {order_id = id, kind = 'fee'}
 * then we build the query in order:
 * $plan->ensure_query( 'main', 'orders', 0 )->select( 'id', 'order_number', ... )...
 * $query = $plan->build_query( 'main' )
 * $results = run( $query )
 * $linked = component( 'items' )->find_link( $results )
 * $items_query = $plan->select_children( 'items', 'orders_lines', [ 'order_id' => $linked, 'kind' => 'item ] )->build_query( 'items' )
 * $items = run( $items_query )
 * $fees_query = $plan->select_children( 'fees', 'orders_lines', [ 'order_id' => $linked, 'kind' => 'fee' ] )->build_query( 'fee' )
 * $fees = run( $fees_query )
 * each( $results as $result ) -> { new Order( ...$result, select_related( $result, $items ), select_releated( $result, $fees )
 *
 * @author Alessio
 */
interface FetchPlan {

    public function ensure_query(string $id, string $target, ?int $priority = null): FetchQueryBuilder;

    public function build_query(string $id): FetchQuery;

    public function fetch_peers(string $id, string $target, array $rel): self;

    public function fetch_children(string $id, string $target, array $rel): self;

    public function priority(): array;

}
