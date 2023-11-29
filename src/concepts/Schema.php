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
interface Schema {

    /**
     * Source of the schema
     * @return string
     */
    public function root_source(): string;

    /**
     * Sources in the form of source => properties
     * @return array
     */
    public function sources(): array;

    /**
     * Schema properties
     * @return array
     */
    public function properties(): array;

    /**
     * Foreign sourced properties of the schema, they may require dedicated queries
     * @return array
     */
    public function foreign_sourced_properties(): array;

    /**
     * Local sourced properties of the schema, they should be included in the base query
     * @return array
     */
    public function local_sourced_properties(): array;

    /**
     * Return if the schema in the schema is writeable
     * @return bool
     */
    public function is_writeable(): bool;

    /**
     * The linked source allow a write from this schema
     * @param string $source
     * @return bool
     */
    public function is_cascade_writable(string $source): bool;

    /**
     * Return if the schema has readable data
     * @return bool
     */
    public function is_readable(): bool;

    /**
     * Return if the linked source has readable data
     * @param string $source
     * @return bool
     */
    public function is_cascade_readable(string $source): bool;

    /**
     * Return if data in the schema is cacheable
     * @return bool
     */
    public function is_data_cacheable(): bool;

    /**
     * Return if data in the linked source is also cacheable
     * @return bool
     */
    public function is_data_cascade_cacheable(string $source): bool;

    /**
     * Return if the schema is cacheable
     * @return bool
     */
    public function is_cacheable(): bool;
}
