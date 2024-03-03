<?php

/*
 * Copyright 2024 Alessio.
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

namespace basin\attributes;

/**
 * Description of MapIdentity
 *
 * @author Alessio
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class MapIdentity {

    public $context;
    public $kind;
    public $settings;

    /**
     * Map primitive type
     * @param string $context serialization context, typically 'SQL'
     * @param string $kind typename, one of 'bool' | 'int' | 'float' | 'string'
     * @param array $settings any settings, like length, defaults, etc
     */
    public function __construct(string $context, string $kind, array $settings = []) {
        $this->context = $context;
        $this->kind = $kind;
        $this->settings = $settings;
    }

}
