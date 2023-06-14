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
interface Repository {

    /**
     * Fetch a single entity
     * @param string|array $fields
     * @param mixed $id
     * @return object|array
     */
    public function fetch(string|array $fields, mixed $id): object|array;

    /**
     * Find all matching entities
     * @param string|array $fields
     * @param Filters $filters
     * @param Order|null $order_by
     * @return array
     */
    public function find_all(string|array $fields, Filters $filters, ?Order $order_by): array;

    /**
     * Find a page of matching entities
     * @param string|array $fields
     * @param Filters $filters
     * @param Page $page
     * @return array
     */
    public function find_page(string|array $fields, Filters $filters, Page $page): array;

    /**
     * Find next batch of entities
     * @param string|array $fields
     * @param Filters $filters
     * @param Cursor $cursor
     */
    public function find_next_batch(string|array $fields, Filters $filters, Cursor $cursor);

    /**
     * Store data
     * @param object|array $data
     * @return object|array
     */
    public function store(object|array $data): object|array;

    /**
     * Store all data
     * @param array $data
     * @return array
     */
    public function store_all(array $data): array;

    /**
     * Drop data
     * @param object|array $data
     * @param int $policy
     * @return bool
     */
    public function drop(object|array $data, int $policy = 1): bool;

}
