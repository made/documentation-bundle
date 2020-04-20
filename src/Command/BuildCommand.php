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

namespace Made\DocumentationBundle\Command;

use Made\DocumentationBundle\Model\Configuration;
use Made\DocumentationBundle\Service\BuildService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BuildCommand
 *
 * @package Made\DocumentationBundle\Command
 */
class BuildCommand extends Command
{
    protected static $defaultName = 'documentation:build';

    /**
     * @var BuildService
     */
    private $buildService;

    /**
     * BuildCommand constructor.
     * @param BuildService $buildService
     */
    public function __construct(BuildService $buildService)
    {
        parent::__construct();

        $this->buildService = $buildService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate static documentation from markdown files.')
            ->addArgument('path-from', InputArgument::REQUIRED, 'Path to the content', null)
            ->addArgument('path-to', InputArgument::REQUIRED, 'Path to the content output', null)
            ->addOption('template-namespace', 't', InputOption::VALUE_REQUIRED, 'Template namespace', null)
            ->addOption('link-base', 'l', InputOption::VALUE_REQUIRED, 'Link base of the content', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pathFrom = $input->getArgument('path-from');
        $pathTo = $input->getArgument('path-to');

        $configuration = new Configuration($pathFrom, $pathTo);

        if (null !== ($templateNamespace = $input->getOption('template-namespace'))) {
            $configuration->setTemplateNamespace($templateNamespace);
        }

        if (null !== ($linkBase = $input->getOption('link-base'))) {
            $configuration->setLinkBase($linkBase);
        }

        $output->writeln('Build:');

        $output->writeln('# path-from          = ' . $configuration->getPathFrom());
        $output->writeln('# path-to            = ' . $configuration->getPathTo());
        $output->writeln('# template-namespace = ' . ($configuration->getTemplateNamespace() ?: 'null'));
        $output->writeln('# link-base          = ' . ($configuration->getLinkBase() ?: 'null'));

        $output->writeln('');

        $result = (int)$this->buildService
            ->execute($configuration);

        $output->writeln('Done.');

        return $result;
    }
}
