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

namespace basin\concepts\query;

/**
 * Description of an immutable FetchQuery, usually built by a query builder
 * the process of fetching a complex resource is the following:
 * Classname
 *      -> meta gathering
 *      -> creating fetch plan
 *      -> queueing lowered properties into multiple queries
 *      -> gathering results
 *      -> reconstructing properties
 *      -> creating the object
 *
 * @author Alessio
 */
interface FetchQuery {

    /**
     * Query selection
     * @return Selection
     */
    public function selection(): Selection;

    /**
     * From expression
     * @return string
     */
    public function from(): string;

    /**
     * List of filters group in the form [ id -> string ]
     * @param string $id location id (per_row/per_group/range)
     * @return array
     */
    public function filters(): array;

    /**
     * Group by
     * @return array
     */
    public function group_by(): array;

    /**
     * Order by if present
     * @return Order|null
     */
    public function order_by(): ?Order;

    /**
     * Limit if present
     * @return int|null
     */
    public function limit(): ?int;

    /**
     * Offset if present
     * @return int|null
     */
    public function offset(): ?int;

    /**
     * Values in the form [ area => [ ...values ] ]
     * @return array
     */
    public function values(?string $id = null): array;
}
