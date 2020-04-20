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

use Help\Path;
use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Model\PageInput;
use Made\DocumentationBundle\Model\PageOutput;
use Parsedown;

/**
 * Class PageConversionService
 *
 * @package Made\DocumentationBundle\Service\Content
 */
class PageConversionService
{
    /**
     * @var Parsedown
     */
    private $parsedown;

    /**
     * PageConversionService constructor.
     * @param Parsedown $parsedown
     */
    public function __construct(Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    /**
     * @param Configuration $configuration
     * @param PageInput $pageInput
     * @return PageOutput
     */
    public function convert(Configuration $configuration, PageInput $pageInput): PageOutput
    {
        $path = $pageInput->getPath();
        $link = Path::join(...[
            $configuration->getLinkBase() ?: '',
            $pageInput->getPath(),
        ]);
        $level = $pageInput->getLevel();

        $content = $pageInput->getContent();
        $content = $this->render($content);

        $title = $pageInput->getTitle();

        /** @var array|PageInput[] $childPageList */
        $childPageList = $pageInput->getChildPageList();
        /** @var array|PageOutput[] $childPageList */
        $childPageList = array_map(function (PageInput $pageInput) use ($configuration): PageOutput {
            return $this->convert($configuration, $pageInput);
        }, $childPageList);

        return (new PageOutput())
            ->setPath($path)
            ->setLink($link)
            ->setLevel($level)
            ->setContent($content)
            ->setTitle($title)
            ->setChildPageList($childPageList);
    }

    /**
     * @param string $content
     * @return string
     */
    private function render(string $content): string
    {
        return $this->parsedown
            ->text($content);
    }
}
