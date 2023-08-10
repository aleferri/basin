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
interface FieldsResolver {
    
    /**
     * Id of the resolver
     * @return string
     */
    public function id(): string;

    /**
     * Fields to be resolved
     * @return array
     */
    public function fields(): array;

    /**
     * build a query for the component
     * @param array<array> $records list of records
     * @return array{FetchQuery, array}
     */
    public function to_query(array ...$records): array;

    /**
     * Resolve specified fields in the list of results
     * @param Repository $repository repository that contains the required data
     * @param FetchPlan $plan plan to be executed
     * @param array $data list of fetched data
     * @return array data with the integration of specified fields
     */
    public function resolve(Repository $repository, FetchPlan $plan, array $data): array;

}
