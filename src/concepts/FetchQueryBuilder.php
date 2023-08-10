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
 * @author Alessio
 */
interface FetchQueryBuilder {

    /**
     * Select some fields
     * @param string $fields
     * @return self
     */
    public function select(string ...$fields): self;

    /**
     * From some fields
     * @param string $origin
     * @param string|null $alias
     * @return self
     */
    public function from(string $origin, ?string $alias = null): self;

    /**
     * left join with map
     * @param string $right
     * @param array $map
     * @return self
     */
    public function left_join(string $right, array $map): self;

    /**
     * Right join with map
     * @param string $right
     * @param array $map
     * @return self
     */
    public function right_join(string $right, array $map): self;

    /**
     * Inner join with map
     * @param string $right
     * @param array $map
     * @return self
     */
    public function inner_join(string $right, array $map): self;

    /**
     * Prepend another table, in other joins the result is ($CONSOLIDATED JOIN $table ON $map), but in this case
     * the result is ($table JOIN ($CONSOLIDATED) ON $map)
     * @param string $left
     * @param array $map
     * @return self
     */
    public function prepend_left_join(string $left, array $map): self;

    /**
     * Filter by the specified condition
     * @param string $id string id of the condition
     * @param string $condition
     * @param mixed $values
     * @return self
     */
    public function filter_by(string $id, string $condition, mixed ...$values): self;

    /**
     * Add filter to the left of the combined condition
     * @param string $id
     * @param string $rel
     * @param string $condition
     * @param mixed $values
     * @return self
     */
    public function add_filter_by_left(string $id, string $rel, string $condition, mixed ...$values): self;

    /**
     * Add filter to the right of the combined condition
     * @param string $id
     * @param string $rel
     * @param string $condition
     * @param mixed $values
     * @return self
     */
    public function add_filter_by_right(string $id, string $rel, string $condition, mixed ...$values): self;

    /**
     * Fold a filter, so enclose the filter in a set of parent
     * @param string $id
     * @return self
     */
    public function fold_filter(string $id): self;

    /**
     * Reset the "group by" and add to it the speficied fields
     * @param string $fields
     * @return self
     */
    public function group_by(string ...$fields): self;

    /**
     * Add some fields in the "group by" clause
     * @param string $fields
     * @return self
     */
    public function also_group_by(string ...$fields): self;

    /**
     * Reset the "order by" and add the specified fields
     * @param string $fields
     * @return self
     */
    public function order_by(string ...$fields): self;

    /**
     * Add some fields in the "order by" clause
     * @param string $fields
     * @return self
     */
    public function also_order_by(string ...$fields): self;

    /**
     * Skip the first $number results
     * @param int $number
     * @return self
     */
    public function skip_firsts(int $number): self;

    /**
     * Take at most $number results
     * @param int $number
     * @return self
     */
    public function take_at_most(int $number): self;

    /**
     * Create a query from builder data
     * @return FetchQuery
     */
    public function into_query(): FetchQuery;
}
