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

use basin\concepts\FetchQuery;
use basin\concepts\FetchQueryBuilder;

/**
 *
 * @author Alessio
 */
interface SQLDriver {

    /**
     * Execute a fetch query
     * @param FetchQuery $query
     * @return array
     */
    public function fetch(FetchQuery $query): array;

    /**
     *
     * @param string $table
     * @return array
     */
    public function find_primary_key(string $table): array;

    /**
     * Create condition with placeholder
     * @param string $field
     * @param string $op
     * @return string
     */
    public function condition_for(string $field, string $op): string;

    public function get_fetch_query_builder(): FetchQueryBuilder;

    public function convert_to(mixed $value, string $kind, array $settings): mixed;
}
