<?php

namespace ImportBundle\Command;

//use Ddeboer\DataImport\Filter\CallbackFilter;
use Ddeboer\DataImport\ItemConverter\MappingItemConverter;
use Ddeboer\DataImport\Reader\CsvReader;
//use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
//use Ddeboer\DataImport\Workflow;
//use Ddeboer\DataImport\Writer\ArrayWriter;
use Ddeboer\DataImport\Result;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
//use ForceUTF8\Encoding;
use ImportBundle\Exception\FilterException;
use ImportBundle\Exception\RuntimeException;
use ImportBundle\Filters\CostAndStockFilter;
//use ImportBundle\Helper\DateTime;
use ImportBundle\Helper\ProductData;
use ImportBundle\ItemConverter\DiscontinuedConverter;
// use ImportBundle\Services\Import;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

//use Symfony\Component\Filesystem\Filesystem;
//use Symfony\Component\Validator\Validator;

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
                "If set, application will not make changes in db")
       ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Hello, I am Symfony SELF-3099 test task and now I will try to run :)');

        $io->section(sprintf("Starting..."));

        $io->text(sprintf("Importing file... %s",  $input->getOption('file')));

        if ($input->getOption('test-mode')) {
            $io->note("Test mode activated. No real changed in db");
        }

        $service = $this->getContainer()->get('service.import_csv_service');

        try {
            $service
                ->setInputFile(new \SplFileObject($input->getOption('file')))
                ->setDebug($input->getOption('test-mode', false))
                ->setHelper(new ProductData())
                ->execute();
        } catch (FilterException $ex) {
            $io->error(sprintf("Oops. Something wrong in filters. Details: %s", $ex->getMessage()));

            return false;
        }

        if ($errors = $service->getReader()->getErrors()) {
            $io->section("Reader errors:");

            foreach ($errors as $row => $error) {
                $io->text(
                    sprintf(
                        "Row %3s: Error during reading, row data: %s",
                        $row,
                        json_encode($error))
                );
            }
        }

        if ($filtered = $service->getWorkflowResult()->getFiltered()) {
            $io->section("Not accepted rows by filters:");

            foreach ($filtered as $row => $reason) {
                $io->text(sprintf("Row %3s: [Filtered] %s", $row, $reason));
            }
        }

        if ($exceptions = $service->getWorkflowResult()->getExceptions()) {
            $io->section("Filter's Exceptions:");

            /**
             * @var $exception \Exception
             */
            foreach ($exceptions as $row => $exception) {
                $io->text(sprintf("Row %3s: [Exception] %s", $row, $exception->getMessage()));
            }
        }

        $totalRows = $service->getReader()->count();
        $readerErrors = count($service->getReader()->getErrors());
        $success = $service->getWorkflowResult()->getSuccessCount();
        $exceptions = count($service->getWorkflowResult()->getExceptions());
        $filtered = $totalRows - $readerErrors - $success - $exceptions;

        $io->success(sprintf(
            "Summary -> Rows: total - %s, with errors - %s. Filtered: by rules - %s, by exceptions - %s. Inserted - %s",
                $totalRows,
                count($service->getReader()->getErrors()),
                $filtered,
                $exceptions,
                $success
            )
        );

        $io->text("Have a nice day, bye!");
    }
}