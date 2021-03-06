<?php
/**
 * Made Documentation
 * Copyright (c) 2019-2020 Made
 *
 * This program  is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Made\DocumentationBundle\DependencyInjection\Factory;

use Parsedown;

/**
 * Class ParsedownFactory
 *
 * @package Made\DocumentationBundle\DependencyInjection\Factory
 */
class ParsedownFactory
{
    /**
     * @return Parsedown
     */
    public static function create(): Parsedown
    {
        return new Parsedown();
    }
}
