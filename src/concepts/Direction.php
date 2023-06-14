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
 * Description of Direction
 *
 * @author Alessio
 */
class Direction {

    private static $desc = null;
    private static $asc = null;

    public static function desc(): self {
        if ( self::$desc === null ) {
            self::$desc = new Direction( "DESC" );
        }
        return self::$desc;
    }

    public static function asc(): self {
        if ( self::$asc === null ) {
            self::$asc = new Direction( "ASC" );
        }
        return self::$asc;
    }

    private $name;

    private function __construct(string $name) {
        $this->name = $name;
    }

    public function name(): string {
        return $this->name;
    }

}
