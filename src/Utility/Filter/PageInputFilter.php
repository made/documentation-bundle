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

namespace Made\DocumentationBundle\Utility\Filter;

use Made\DocumentationBundle\Model\PageInput;

/**
 * Class PageInputFilter
 *
 * @package Made\DocumentationBundle\Utility\Filter
 */
final class PageInputFilter
{
    /**
     * @param array|PageInput[] $all
     * @param string $path
     * @return array|PageInput[]
     */
    public static function filterByPathBeginWith(array $all, string $path): array
    {
        return array_filter($all, function (PageInput $page) use ($path): bool {
            $length = strlen($path);
            return substr($page->getPath(), 0, $length) === $path;
        });
    }

    /**
     * @param array|PageInput[] $all
     * @param string $path
     * @return array|PageInput[]
     */
    public static function filterByPathEndWith(array $all, string $path): array
    {
        return array_filter($all, function (PageInput $page) use ($path): bool {
            $length = strlen($path);
            return 0 === $length || substr($page->getPath(), -$length) === $path;
        });
    }

    /**
     * @param array|PageInput[] $all
     * @param int $level
     * @return array|PageInput[]
     */
    public static function filterByLevelEqual(array $all, int $level): array
    {
        return array_filter($all, function (PageInput $page) use ($level): bool {
            return $level === $page->getLevel();
        });
    }

    /**
     * @param array|PageInput[] $all
     * @param int $level
     * @return array|PageInput[]
     */
    public static function filterByLevelGreaterThanOrEqual(array $all, int $level): array
    {
        return array_filter($all, function (PageInput $page) use ($level): bool {
            return $level <= $page->getLevel();
        });
    }

    /**
     * @param array|PageInput[] $all
     * @param int $level
     * @return array|PageInput[]
     */
    public static function filterByLevelLessThanOrEqual(array $all, int $level): array
    {
        return array_filter($all, function (PageInput $page) use ($level): bool {
            return $level >= $page->getLevel();
        });
    }
}
