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

    public function select(Field ...$fields): self;

    public function from(string $origin, ?string $alias = null): self;

    public function left_join(string $right, array $map): self;

    public function right_join(string $right, array $map): self;

    public function inner_join(string $right, array $map): self;

    public function prepend_left_join(string $left, array $map): self;

    public function filter_by(string $id, string $condition, mixed ...$values): self;

    public function add_filter_by_left(string $id, string $rel, string $condition, mixed ...$values): self;

    public function add_filter_by_right(string $id, string $rel, string $condition, mixed ...$values): self;

    public function fold_filter(string $id): self;

    public function group_by(string ...$fields): self;

    public function also_group_by(string ...$fields): self;

    public function order_by(string ...$fields): self;

    public function also_order_by(string ...$fields): self;

    public function skip_firsts(int $number): self;

    public function take_firsts(int $number): self;

    public function into_query(): FetchQuery;

}
