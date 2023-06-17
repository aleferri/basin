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
 * Description of Query
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
     * Values in the form [ area => [ ...values ] ]
     * @return array
     */
    public function values(): array;
    
    /**
     * Append a value
     * @param string $target
     * @param mixed $data
     * @return FetchQuery
     */
    public function append_value(string $target, mixed $data): FetchQuery;
    
    /**
     * Chain an existings expression
     * @param string $target
     * @param string $rel
     * @param mixed $data
     * @return FetchQuery
     */
    public function chain_expression(string $target, string $rel, string $expression, mixed ...$data): FetchQuery;
    
    /**
     * Fold an existings expression and then chain the new expression
     * @param string $target
     * @param string $rel
     * @param mixed $data
     * @return FetchQuery
     */
    public function fold_expression(string $target, string $rel, string $expression, mixed ...$data): FetchQuery;
    
    public function group_by(string ...$fields): array;
    
    public function also_group_by(string $field): array;
    
    public function order(): ?Order;
    
    public function limit(): ?int;
    
    public function offset(): ?int;
    
    public function restrict(int $limit, ?int $skip): void;

}
