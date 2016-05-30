<?php

namespace ImportBundle\Command;

use Ddeboer\DataImport\Filter\CallbackFilter;
use Ddeboer\DataImport\Filter\ValidatorFilter;
use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use Ddeboer\DataImport\ItemConverter\MappingItemConverter;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\ValueConverter\ArrayValueConverterMap;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Ddeboer\DataImport\ValueConverter\MappingValueConverter;
use Ddeboer\DataImport\ValueConverter\StringToObjectConverter;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\ConsoleTableWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator;

class ImportCommand extends ContainerAwareCommand
{
    protected $debug = false;

    protected $testMode = false;

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
                "If set, application will not make changes in db")
            ->addOption('debug', 'd', InputOption::VALUE_NONE,
                "Debug mode will show you what's really happen");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('debug')) {
            $this->debug = true;
        }

        if (!file_exists($input->getOption('file'))) {
            throw new RuntimeException(sprintf("File %s doesn't exists", $input->getOption('file')));
        }

        $output->writeln("Hello, I'm a first console application");

        $file = new \SplFileObject($input->getOption('file'));
        $reader = new CsvReader($file);

        $reader->setHeaderRowNumber(0);

        $workflow = new Workflow($reader);

        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $doctrineWriter = new DoctrineWriter($entityManager, 'ImportBundle:Tblproductdata');
        $workflow->addWriter($doctrineWriter);

        /*$output = new ConsoleOutput();

        $consoleWriter = new ConsoleTableWriter($output, new Table($output));



        $workflow->addWriter($consoleWriter);*/

        $converter = new MappingItemConverter();
        $converter
            ->addMapping('Product Code', 'strproductcode')
            ->addMapping('Product Name', 'strproductname')
            ->addMapping('Product Description', 'strproductdesc')
            ->addMapping('Stock', 'intstock')
            ->addMapping('Cost in GBP', 'floatcostingbp')
            ->addMapping('Discontinued', 'dtmDiscontinued');

        $workflow->addItemConverter($converter);
        $workflow->setSkipItemOnFailure(true);

        $converter = new CallbackItemConverter(function ($item) {
            $item['dtmadded'] = new \DateTime();
            $item['stmtimestamp'] = new \DateTime();

            /*if (!empty($item['dtmDiscontinued'])) {
                $item['dtmDiscontinued'] = new \DateTime();
            } else {
                $item['dtmDiscontinued'] = null;
            }*/

            return $item;
        });

       $workflow->addFilter(
            new CallbackFilter(function ($data) {
                return is_numeric($data['Cost in GBP']);
            })
        );

        $workflow->addFilter(
            new CallbackFilter(function ($data) {
                return $data['Cost in GBP'] > 5  && $data['Stock'] > 10;
            })
        );

        $workflow->addFilter(
            new CallbackFilter(function ($data) {
                return $data['Cost in GBP'] < 1000;
            })
        );

        $dt = new DateTimeValueConverter('\y\e\s', 'Y-m-d');

        $workflow->addValueConverter("dtmDiscontinued", $dt);
            /*new CallbackValueConverter(function ($item) {
                return date("Y-m-d", time());
            }));*/

        $workflow->addItemConverter($converter);

        







        $workflow->process();
    }
}