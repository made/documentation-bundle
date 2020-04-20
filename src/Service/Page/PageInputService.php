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

namespace Made\DocumentationBundle\Service\Page;

use Help\Directory;
use Help\File;
use Help\Path;
use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Model\PageInput;

/**
 * Class PageInputService
 *
 * @package Made\DocumentationBundle\Service\Content
 */
class PageInputService
{
    const PATH_CONTENT = 'content.md';

    const PATTERN_HEADLINE = '/^#\s*(.*)\s+$/m';

    const MATCH_FULL = 'full';
    const MATCH_HEADLINE = 'headline';

    /**
     * @var int
     */
    private $level = 0;

    /**
     * @param Configuration $configuration
     * @param string $pathRelative
     * @return PageInput|null
     */
    public function read(Configuration $configuration, ?string $pathRelative = null): ?PageInput
    {
        $pathRelative = $pathRelative ?: '/';

        $path = $configuration->getPathFrom();
        $pathAbsolute = Path::join(...[
            $path,
            $pathRelative,
        ]);

        $pathAbsoluteContent = Path::join(...[
            $pathAbsolute,
            static::PATH_CONTENT,
        ]);

        if (!is_file($pathAbsoluteContent)) {
            return null;
        }

        /** @var array|string[] $entryList */
        $entryList = Directory::listCallback($pathAbsolute, function (string $entry): bool {
            if ($entry === '.' || $entry === '..') {
                return false;
            }

            return true;
        });

        ++$this->level;
        {
            $level = $this->level;
            $content = File::read($pathAbsoluteContent);
            $title = $this->parseFirstHeadline($content);

            /** @var array|PageInput[] $pageList */
            $pageList = array_map(function (string $entry) use ($configuration, $pathRelative): ?PageInput {
                $pathRelative = Path::join(...[
                    $pathRelative,
                    $entry,
                ]);

                return $this->read($configuration, $pathRelative);
            }, $entryList);
            $pageList = array_filter($pageList, function (?PageInput $page): bool {
                return $page !== null;
            });
        }
        --$this->level;

        return (new PageInput())
            ->setPath($pathRelative)
            ->setLevel($level)
            ->setContent($content)
            ->setTitle($title)
            ->setChildPageList($pageList);
    }

    /**
     * Parse the first headline from a given content string.
     *
     * @param string $content
     * @return string
     */
    private function parseFirstHeadline(string $content): string
    {
        // TODO: Use Help\Preg::match() when available.

        $identifier = [
            self::MATCH_FULL,
            self::MATCH_HEADLINE,
        ];

        $match = [];

        preg_match(static::PATTERN_HEADLINE, $content, $match, PREG_UNMATCHED_AS_NULL);
        while (count($match) < count($identifier)) {
            $match[] = null;
        }

        /** @var array $result */
        $result = array_combine($identifier, $match) ?: [];

        return $result[self::MATCH_HEADLINE] ?? '';
    }
}
