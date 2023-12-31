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
 *
 * @author Alessio
 */
interface Relation {

    public const IS_CONSTANT = 1;

    public function map(): array;

    public function is_constant(string $left): bool;

    public function is_key(string $left): bool;

    public function foreign_index(array $data): ForeignIndex;
    
    /**
     * 
     * @return array{test, link}
     */
    public function prepare_links(): array;

}
