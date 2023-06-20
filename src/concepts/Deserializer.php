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
 * Description of Deserializer
 *
 * @author Alessio
 */
interface Deserializer {

    /**
     * List of selected fields
     * @return array<Field>
     */
    public function fields_descriptors(): array;

    /**
     * List of sources
     * @return array
     */
    public function sources(): array;

    /**
     * Fit a given row to the required datatype
     * @param array $row
     * @return array
     */
    public function fit(array $row): array;

    /**
     * Instance the correct object type
     * @param array $row row of object
     * @return object|array the corrent object of multiple associated object if so is required
     */
    public function instance(array $row, bool $prefitted = false): object|array;

    /**
     * Instance all the correct objects
     * @param array $data result set of the query
     * @return array list of objects instances, keep associated object in a per row array
     */
    public function instance_all(array $data, bool $prefitted = false): array;

}
