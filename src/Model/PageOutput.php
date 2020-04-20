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
 * Class PageOutput
 *
 * @package Made\DocumentationBundle\Model
 */
class PageOutput
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $link;

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
     * @var array|PageOutput[]
     */
    private $childPageList;

    /**
     * @var null|PageOutput
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
     * @return PageOutput
     */
    public function setPath(string $path): PageOutput
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return PageOutput
     */
    public function setLink(string $link): PageOutput
    {
        $this->link = $link;
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
     * @return PageOutput
     */
    public function setLevel(int $level): PageOutput
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
     * @return PageOutput
     */
    public function setContent(string $content): PageOutput
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
     * @return PageOutput
     */
    public function setTitle(string $title): PageOutput
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return PageOutput[]|array
     */
    public function getChildPageList()
    {
        return $this->childPageList;
    }

    /**
     * @param PageOutput[]|array $childPageList
     * @return PageOutput
     */
    public function setChildPageList($childPageList)
    {
        $this->childPageList = $childPageList;
        return $this;
    }

    /**
     * @return PageOutput|null
     */
    public function getParentPage(): ?PageOutput
    {
        return $this->parentPage;
    }

    /**
     * @param PageOutput|null $parentPage
     * @return PageOutput
     */
    public function setParentPage(?PageOutput $parentPage): PageOutput
    {
        $this->parentPage = $parentPage;
        return $this;
    }
}
