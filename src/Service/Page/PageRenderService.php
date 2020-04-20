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

use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Model\PageOutput;
use Made\DocumentationBundle\Service\Template\TemplateDataResolverInterface;
use Made\DocumentationBundle\Service\Template\TemplateResolverInterface;
use RuntimeException;
use Twig\Environment;
use Twig\Error\Error;

/**
 * Class PageRenderService
 *
 * @package Made\DocumentationBundle\Service\Content
 */
class PageRenderService
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var TemplateResolverInterface
     */
    private $templateResolver;

    /**
     * @var TemplateDataResolverInterface
     */
    private $templateDataResolver;

    /**
     * PageRenderService constructor.
     * @param Environment $environment
     * @param TemplateResolverInterface $templateResolver
     * @param TemplateDataResolverInterface $templateDataResolver
     */
    public function __construct(Environment $environment, TemplateResolverInterface $templateResolver, TemplateDataResolverInterface $templateDataResolver)
    {
        $this->environment = $environment;
        $this->templateResolver = $templateResolver;
        $this->templateDataResolver = $templateDataResolver;
    }

    /**
     * @param Configuration $configuration
     * @param PageOutput $pageOutput
     * @return string
     */
    public function render(Configuration $configuration, PageOutput $pageOutput): string
    {
        $template = $this->templateResolver
            ->resolve($configuration, $pageOutput);
        $context = $this->templateDataResolver
            ->resolve($configuration, $pageOutput);

        try {
            $content = $this->environment
                ->render($template, $context);
        } catch (Error $error) {
            throw new RuntimeException('Could not render template.', 0, $error);
        }

        return $content;
    }
}
