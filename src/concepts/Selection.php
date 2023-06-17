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
interface Selection {
    
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
     * Postprocess the row
     * @param array $row
     * @return array
     */
    public function postprocess_row(array $row): array;
    
    /**
     * Postprocess the result set
     * @param array $data
     * @return arrayù
     */
    public function postprocess(array $data): array;
    
    /**
     * Instance the correct object type
     * @param array $row row of object
     * @return object|array the corrent object of multiple associated object if so is required
     */
    public function instance(array $row): object|array;
    
    /**
     * Instance all the correct objects
     * @param array $data result set of the query
     * @return array list of objects instances, keep associated object in a per row array
     */
    public function instance_all(array $data): array;
}
