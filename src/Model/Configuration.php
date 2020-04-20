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
 * Class Configuration
 *
 * @package Made\DocumentationBundle\Model
 */
class Configuration
{
    /**
     * @var string
     */
    private $pathFrom;

    /**
     * @var string
     */
    private $pathTo;

    /**
     * @var string|null
     */
    private $templateNamespace;

    /**
     * @var string|null
     */
    private $linkBase;

    /**
     * Configuration constructor.
     * @param string $pathFrom
     * @param string $pathTo
     */
    public function __construct(string $pathFrom, string $pathTo)
    {
        $this->pathFrom = $pathFrom;
        $this->pathTo = $pathTo;
    }

    /**
     * @return string
     */
    public function getPathFrom(): string
    {
        return $this->pathFrom;
    }

    /**
     * @param string $pathFrom
     * @return Configuration
     */
    public function setPathFrom(string $pathFrom): Configuration
    {
        $this->pathFrom = $pathFrom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathTo(): string
    {
        return $this->pathTo;
    }

    /**
     * @param string $pathTo
     * @return Configuration
     */
    public function setPathTo(string $pathTo): Configuration
    {
        $this->pathTo = $pathTo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemplateNamespace(): ?string
    {
        return $this->templateNamespace;
    }

    /**
     * @param string|null $templateNamespace
     * @return Configuration
     */
    public function setTemplateNamespace(?string $templateNamespace): Configuration
    {
        $this->templateNamespace = $templateNamespace;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinkBase(): ?string
    {
        return $this->linkBase;
    }

    /**
     * @param string|null $linkBase
     * @return Configuration
     */
    public function setLinkBase(?string $linkBase): Configuration
    {
        $this->linkBase = $linkBase;
        return $this;
    }
}
