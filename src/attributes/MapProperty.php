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

namespace basin\attributes;

use basic\concepts\OutLink;

/**
 * Description of MapProperty
 *
 * @author Alessio
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class MapProperty {

    public $context;
    public $out_link;
    public $settings;

    public function __construct(string $context, array $settings = [], ?OutLink $out_link = null) {
        $this->context = $context;
        $this->out_link = $out_link;
        $this->settings = $settings;
    }

}
