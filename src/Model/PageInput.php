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

namespace Made\DocumentationBundle\Model;

/**
 * Class PageInput
 *
 * @package Made\DocumentationBundle\Model
 */
class PageInput
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $title;

    /**
     * @var array|PageInput[]
     */
    private $childPageList;

    /**
     * @var null|PageInput
     */
    private $parentPage;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return PageInput
     */
    public function setPath(string $path): PageInput
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return PageInput
     */
    public function setLevel(int $level): PageInput
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return PageInput
     */
    public function setContent(string $content): PageInput
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PageInput
     */
    public function setTitle(string $title): PageInput
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return PageInput[]|array
     */
    public function getChildPageList()
    {
        return $this->childPageList;
    }

    /**
     * @param PageInput[]|array $childPageList
     * @return PageInput
     */
    public function setChildPageList($childPageList)
    {
        $this->childPageList = $childPageList;
        return $this;
    }

    /**
     * @return PageInput|null
     */
    public function getParentPage(): ?PageInput
    {
        return $this->parentPage;
    }

    /**
     * @param PageInput|null $parentPage
     * @return PageInput
     */
    public function setParentPage(?PageInput $parentPage): PageInput
    {
        $this->parentPage = $parentPage;
        return $this;
    }
}
