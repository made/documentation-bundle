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

use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Model\PageOutput;
use RuntimeException;
use Twig\Environment;

/**
 * Class TemplateResolver
 *
 * @package Made\DocumentationBundle\Service\Template
 */
class TemplateResolver implements TemplateResolverInterface
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * TemplateResolver constructor.
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @inheritDoc
     * @throws RuntimeException
     */
    public function resolve(Configuration $configuration, PageOutput $page): string
    {
        $level = $page->getLevel();
        $level = $level > 0 ? $level : 1;

        for (; $level >= 0; $level--) {
            $template = $this->getTemplate($level, $configuration->getTemplateNamespace());

            if ($this->checkTemplate($template)) {
                return $template;
            }
        }

        throw new RuntimeException('Could not resolve template.');
    }

    /**
     * @param string $template
     * @return bool
     */
    private function checkTemplate(string $template): bool
    {
        $loader = $this->environment
            ->getLoader();

        return $loader->exists($template);
    }

    /**
     * @param int $level
     * @param string|null $templateNamespace
     * @return string
     */
    private function getTemplate(int $level, ?string $templateNamespace = null): string
    {
        $template = "page-level-{$level}.html.twig";

        if (null !== $templateNamespace) {
            $template = "{$templateNamespace}/{$template}";
        }

        return $template;
    }
}
