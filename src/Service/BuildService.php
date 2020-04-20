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

namespace Made\DocumentationBundle\Service;

use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Repository\PageOutputRepositoryInterface;
use Made\DocumentationBundle\Service\Page\PageOutputService;

/**
 * Class BuildService
 *
 * @package Made\DocumentationBundle\Service
 */
class BuildService
{
    /**
     * @var PageOutputRepositoryInterface
     */
    private $pageOutputRepository;

    /**
     * @var PageOutputService
     */
    private $pageOutputService;

    /**
     * BuildService constructor.
     * @param PageOutputRepositoryInterface $pageOutputRepository
     * @param PageOutputService $pageOutputService
     */
    public function __construct(PageOutputRepositoryInterface $pageOutputRepository, PageOutputService $pageOutputService)
    {
        $this->pageOutputRepository = $pageOutputRepository;
        $this->pageOutputService = $pageOutputService;
    }

    /**
     * @param Configuration $configuration
     * @return bool
     */
    public function execute(Configuration $configuration): bool
    {
        $pageOutput = $this->pageOutputRepository
            ->getRoot($configuration);

        return $this->pageOutputService
            ->write($configuration, $pageOutput);
    }
}
