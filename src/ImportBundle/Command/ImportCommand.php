<?php

namespace ImportBundle\Command;

use Ddeboer\DataImport\Filter\CallbackFilter;
use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use Ddeboer\DataImport\ItemConverter\MappingItemConverter;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\ArrayWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
       $this
            ->setName("import:do")
            ->setDescription("SELF-3099 simple console application")
            ->addOption(
                'file', 'f', InputOption::VALUE_OPTIONAL,
                "Path to import file", "vagrant/task/stock.csv")
            ->addOption(
                'test-mode', 't', InputOption::VALUE_NONE,
                "If set, application will not make changes in db");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists($input->getOption('file'))) {
            throw new RuntimeException(sprintf("File %s doesn't exists", $input->getOption('file')));
        }

        $file = new \SplFileObject($input->getOption('file'));
        $reader = new CsvReader($file);

        $output->writeln(sprintf("Importing %s...", $file->getBasename()));

        $reader->setHeaderRowNumber(0);

        $workflow = new Workflow($reader);

        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        if ($input->getOption('test-mode')) {
            $testData = array();

            $writer = new ArrayWriter($testData);
        } else {
            $writer = new DoctrineWriter($entityManager, 'ImportBundle:Tblproductdata');
        }

        $workflow->addWriter($writer);

        $converter = new MappingItemConverter();
        $converter
            ->addMapping('Product Code', 'strproductcode')
            ->addMapping('Product Name', 'strproductname')
            ->addMapping('Product Description', 'strproductdesc')
            ->addMapping('Stock', 'intstock')
            ->addMapping('Cost in GBP', 'floatcostingbp')
            ->addMapping('Discontinued', 'dtmdiscontinued');

        $workflow->addItemConverter($converter);
        $workflow->setSkipItemOnFailure(true);

        $converter = new CallbackItemConverter(function ($item) {
            $item['dtmadded'] = new \DateTime();
            $item['stmtimestamp'] = new \DateTime();

            return $item;
        });

        $skipped = array();

        $workflow->addFilter(
            new CallbackFilter(function ($data) use (&$skipped, $reader) {
                if (is_numeric($data['Cost in GBP'])
                    && is_numeric($data['Stock'])
                    && ($data['Cost in GBP'] > 5 && $data['Cost in GBP'] < 1000)
                    && $data['Stock'] > 10
                ) {
                    return true;
                }

                array_push($skipped, $reader->current());
                return false;
            })
        );

        $workflow->addItemConverter($converter);

        $workflow->addValueConverter(
            "dtmdiscontinued", new CallbackValueConverter(function ($item) {
                if (empty($item)) {
                    return null;
                }

                return new \DateTime();
            })
        );

        $result = $workflow->process();

        if ($skipped) {
            foreach ($skipped as $data) {
                $output->writeln(sprintf("[Skipped]: %s", implode(":", $data)));
            }
        }

        $output->writeln(
            sprintf(
                "Done: Total - %s, Success: %s, Skipped: %s",
                $reader->count(),
                $result->getSuccessCount(),
                $reader->count() - $result->getSuccessCount()
            )
        );
    }
}