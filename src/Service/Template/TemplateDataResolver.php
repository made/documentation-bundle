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

namespace Made\DocumentationBundle\Service\Template;

use DateTime;
use Help\Path;
use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Model\PageInput;
use Made\DocumentationBundle\Model\PageOutput;
use Made\DocumentationBundle\Repository\PageOutputRepositoryInterface;
use Made\DocumentationBundle\Utility\Filter\PageOutputFilter;

/**
 * Class TemplateDataResolver
 *
 * @package Made\DocumentationBundle\Service\Template
 */
class TemplateDataResolver implements TemplateDataResolverInterface
{
    /**
     * @var PageOutputRepositoryInterface
     */
    private $pageOutputRepository;

    /**
     * TemplateDataResolver constructor.
     * @param PageOutputRepositoryInterface $pageOutputRepository
     */
    public function __construct(PageOutputRepositoryInterface $pageOutputRepository)
    {
        $this->pageOutputRepository = $pageOutputRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Configuration $configuration, PageOutput $pageOutput): array
    {
        $root = $this->pageOutputRepository
            ->getRoot($configuration);
        $otherVersionList = $this->getVersionList($configuration, $pageOutput);

        return [
            'date' => (new DateTime()),
            'root' => $root,
            'page' => $pageOutput,
            'other_version_list' => $otherVersionList,
        ];
    }

    /**
     * @param Configuration $configuration
     * @param PageOutput $pageOutput
     * @return array|PageInput[]
     */
    private function getVersionList(Configuration $configuration, PageOutput $pageOutput): array
    {
        $level = $pageOutput->getLevel();

        if (2 > $level) {
            return [];
        }

        $all = $this->pageOutputRepository
            ->getAll($configuration);

        $path = $pageOutput->getPath();

        $segmentList = explode('/', $path);
        $segmentList = array_slice($segmentList, 2);

        $path = Path::join(...$segmentList);

        if (2 === $level) {
            $all = PageOutputFilter::filterByLevelEqual($all, 2);
        } else {
            $all = PageOutputFilter::filterByLevelGreaterThanOrEqual($all, 2);
            $all = PageOutputFilter::filterByPathEndWith($all, $path);
        }

        return $all;
    }
}
