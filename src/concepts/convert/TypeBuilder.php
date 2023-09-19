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

namespace basin\concepts\convert;

/**
 *
 * @author Alessio
 */
interface TypeBuilder {

    /**
     * Instance a new object with data and defaults fields
     * @param array $data data from database in the form field => value
     * @return object instances object
     */
    public function instance(array $data): object|array;

    /**
     * Instance an array of new objects with data from record and defaults fields
     * @param array $records data from the database in the form of array of records in field => value
     * @return array of instances of objects
     */
    public function instance_all(array $records): array;
}
