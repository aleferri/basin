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
interface Cursor extends FetchQueryComponent {

    /**
     * Numerical limit, like limit to n results
     * @return int|null
     */
    public function limit(): ?int;

    /**
     * Symbolic from, like restart after id 60 or year 2013
     * @return array
     */
    public function from(): array;

    /**
     * Symbolic limit, like fetch until id 250 or year 2017
     * @return array
     */
    public function to(): array;

    /**
     * Fields for the cursor (num_row, id, updated_at, etc)
     * @return array list of scrolled fields
     */
    public function cursor(): array;

    /**
     * Order all fields, at minimun the fields specified in cursor
     * @return Order
     */
    public function order(): Order;

    /**
     * Apply to query
     * @param FetchQuery $query
     * @return void
     */
    public function apply_to(FetchQuery $query): void;

}
