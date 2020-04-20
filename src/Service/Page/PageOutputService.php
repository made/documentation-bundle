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

use Help\File;
use Help\Path;
use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Model\PageOutput;

/**
 * Class PageOutputService
 *
 * @package Made\DocumentationBundle\Service\Content
 */
class PageOutputService
{
    const PATH_CONTENT = 'index.html';

    /**
     * @var PageRenderService
     */
    private $pageRenderService;

    /**
     * PageOutputService constructor.
     * @param PageRenderService $pageRenderService
     */
    public function __construct(PageRenderService $pageRenderService)
    {
        $this->pageRenderService = $pageRenderService;
    }

    /**
     * @param Configuration $configuration
     * @param PageOutput $pageOutput
     * @return bool
     */
    public function write(Configuration $configuration, PageOutput $pageOutput): bool
    {
        $pathRelative = $pageOutput->getPath();

        $path = $configuration->getPathTo();
        $pathAbsolute = Path::join(...[
            $path,
            $pathRelative,
        ]);

        $pathAbsoluteContent = Path::join(...[
            $pathAbsolute,
            static::PATH_CONTENT,
        ]);

        if (!is_dir($pathAbsolute) && !mkdir($pathAbsolute, 0775)) {
            return false;
        }

        $content = $this->pageRenderService
            ->render($configuration, $pageOutput);

        File::write($pathAbsoluteContent, $content);

        $pageList = $pageOutput->getChildPageList();
        return is_file($pathAbsoluteContent) && (empty($pageList) || array_reduce($pageList, function (bool $carry, PageOutput $pageOutput) use ($configuration): bool {
                    return $this->write($configuration, $pageOutput) && $carry;
                }, true)
            );
    }
}
