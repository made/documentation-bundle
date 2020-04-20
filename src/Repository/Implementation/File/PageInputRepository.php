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

namespace Made\DocumentationBundle\Repository\Implementation\File;

use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Model\PageInput;
use Made\DocumentationBundle\Repository\PageInputRepositoryInterface;
use Made\DocumentationBundle\Service\Page\PageInputService;

/**
 * Class PageInputRepository
 *
 * @package Made\DocumentationBundle\Repository\Implementation\File
 */
class PageInputRepository implements PageInputRepositoryInterface
{
    /**
     * @var PageInput|null
     */
    private $tree;

    /**
     * @var array|PageInput[]
     */
    private $list;

    /**
     * @var PageInputService
     */
    private $pageInputService;

    /**
     * @var string|null
     */
    private $path;

    /**
     * PageRepository constructor.
     * @param PageInputService $pageInputService
     */
    public function __construct(PageInputService $pageInputService)
    {
        $this->tree = null;
        $this->list = [];
        $this->pageInputService = $pageInputService;
        $this->path = null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(Configuration $configuration): array
    {
        $path = $configuration->getPathFrom();
        $this->setPath($path);

        if (null === $this->tree) {
            $this->getRoot($configuration);

            $this->clear();
        }

        if (empty($this->list)) {
            $this->walk($this->tree);
        }

        return $this->list;
    }

    /**
     * @inheritDoc
     */
    public function getRoot(Configuration $configuration): PageInput
    {
        $path = $configuration->getPathFrom();
        $this->setPath($path);

        if (null === $this->tree) {
            $this->tree = $this->pageInputService
                ->read($configuration);
        }

        return $this->tree;
    }

    private function clear(): void
    {
        $this->list = [];
    }

    /**
     * @param PageInput $page
     */
    private function walk(PageInput $page): void
    {
        $this->list[] = $page;

        /** @var array|PageInput[] $childPageList */
        $childPageList = $page->getChildPageList();

        if (empty($childPageList)) {
            return;
        }

        foreach ($childPageList as $childPage) {
            // TODO: Check if page was already added.

            $this->walk($childPage);
        }
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return PageInputRepository
     */
    public function setPath(?string $path): PageInputRepository
    {
        if ($path !== $this->path) {
            $this->tree = null;
        }

        $this->path = $path;
        return $this;
    }
}
