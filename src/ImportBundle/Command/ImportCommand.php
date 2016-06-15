<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Command;

use ImportBundle\Exception\RuntimeException;
use ImportBundle\Helper\ConsoleHelper;
use ImportBundle\Helper\ProductData;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ImportCommand
 *
 * @package ImportBundle\Command
 */
class ImportCommand extends ContainerAwareCommand
{
    /**
     * Configure command line properties and default values
     */
    protected function configure()
    {
        $this
            ->setName("import:products") // can be cached
            ->setDescription("SELF-3099 simple console application")
            ->addOption(
                'file', 'f', InputOption::VALUE_OPTIONAL,
                "Path to import file", "vagrant/task/stock.csv"
            ) // default file from package
            ->addOption(
                'test-mode', 't', InputOption::VALUE_NONE,
                "If set, application will not make changes in db"
            ) // deactivated by default
        ;
    }

    /**
     * Command execution
     *
     * @param InputInterface  $input  input interface
     * @param OutputInterface $output output interface
     *
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // init style output
        $io = new SymfonyStyle($input, $output);

        // set general messages
        $io->title('Hello, I am Symfony SELF-3099 test task and now I will try to run :)');
        $io->section(sprintf("Starting..."));
        $io->text(sprintf("Importing file... %s",  $input->getOption('file')));

        // test mode activated, tell user about it
        if ($input->getOption('test-mode')) {
            $io->note("Test mode activated. No real changed in db");
        }

        // get service and try to run import process
        $service = $this->getContainer()->get('service.import_csv_service');

        try {
            $service
                ->setInputFile(new \SplFileObject($input->getOption('file')))
                ->setDebug($input->getOption('test-mode', false))
                ->setHelper(new ProductData())
                ->execute();
        } catch (RuntimeException $ex) {
            $io->error(
                sprintf(
                    "Oops. Something wrong with logic inside bundle. Details: %s",
                    $ex->getMessage()
                )
            );

            return false;
        } catch (\RuntimeException $ex) {
            $io->error(
                sprintf(
                    "Oops. Something wrong. Details: %s",
                    $ex->getMessage()
                )
            );

            return false;
        }

        // pass creation info about actions to small helper
        $helper = new ConsoleHelper(
            $io,
            $service->getReader()->getErrors(),
            $service->getWorkflowResult()->getFiltered(),
            $service->getWorkflowResult()->getExceptions()
        );
        $helper->printInfo();


        // summary info, can be moved to helper if needed in future
        $totalRows = $service->getReader()->count();
        $readerErrors = count($service->getReader()->getErrors());
        $success = $service->getWorkflowResult()->getSuccessCount();
        $exceptions = count($service->getWorkflowResult()->getExceptions());
        $filtered = count($service->getWorkflowResult()->getFiltered());

        $io->success(
            sprintf(
                "Summary -> Rows: total - %s, with errors - %s. " .
                "Filtered: by rules - %s, by exceptions - %s. Inserted - %s",
                $totalRows,
                $readerErrors,
                $filtered,
                $exceptions,
                $success
            )
        );

        $io->text("Have a nice day, bye!");

        return true;
    }
}