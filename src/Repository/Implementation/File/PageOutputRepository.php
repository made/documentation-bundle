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
use Made\DocumentationBundle\Model\PageOutput;
use Made\DocumentationBundle\Repository\PageInputRepositoryInterface;
use Made\DocumentationBundle\Repository\PageOutputRepositoryInterface;
use Made\DocumentationBundle\Service\Page\PageConversionService;

/**
 * Class PageOutputRepository
 *
 * @package Made\DocumentationBundle\Repository\Implementation\File
 */
class PageOutputRepository implements PageOutputRepositoryInterface
{
    /**
     * @var PageOutput|null
     */
    private $tree;

    /**
     * @var array
     */
    private $list;

    /**
     * @var PageInputRepositoryInterface
     */
    private $pageInputRepository;

    /**
     * @var PageConversionService
     */
    private $pageConversionService;

    /**
     * @var string|null
     */
    private $path;

    /**
     * PageOutputRepository constructor.
     * @param PageInputRepositoryInterface $pageInputService
     * @param PageConversionService $pageConversionService
     */
    public function __construct(PageInputRepositoryInterface $pageInputService, PageConversionService $pageConversionService)
    {
        $this->tree = null;
        $this->list = [];
        $this->pageInputRepository = $pageInputService;
        $this->pageConversionService = $pageConversionService;
        $this->path = null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(Configuration $configuration): array
    {
        $path = $configuration->getPathTo();
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
    public function getRoot(Configuration $configuration): PageOutput
    {
        $path = $configuration->getPathTo();
        $this->setPath($path);

        if (null === $this->tree) {
            $pageInput = $this->pageInputRepository
                ->getRoot($configuration);

            $this->tree = $this->pageConversionService
                ->convert($configuration, $pageInput);
        }

        return $this->tree;
    }

    private function clear(): void
    {
        $this->list = [];
    }

    /**
     * @param PageOutput $page
     */
    private function walk(PageOutput $page): void
    {
        $this->list[] = $page;

        /** @var array|PageOutput[] $childPageList */
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
     * @return PageOutputRepository
     */
    public function setPath(?string $path): PageOutputRepository
    {
        if ($path !== $this->path) {
            $this->tree = null;
        }

        $this->path = $path;
        return $this;
    }
}
