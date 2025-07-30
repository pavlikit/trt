<?php

namespace App\Command;

use App\Zabbix\Collection\TreatSet;
use App\Zabbix\Exception\TreatOptimizationException;
use App\Zabbix\Interface\TreatOptimizerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'app:optimize-treats',
    description: 'Compute max treat value using recursive programming'
)]
class OptimizeTreatsCommand extends Command
{
    private TreatOptimizerInterface $optimizer;

    public function __construct(TreatOptimizerInterface $optimizer)
    {
        parent::__construct();
        $this->optimizer = $optimizer;
    }

    protected function configure(): void
    {
        $this->addArgument(
            'treats',
            InputArgument::REQUIRED,
            'Comma-separated list of treat values (e.g., "1,2,3,4")'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $treatsInput = $input->getArgument('treats');
            $treatValues = $this->parseTreats($treatsInput);

            $treatSet = new TreatSet($treatValues);
            $maxValue = $this->optimizer->maximize($treatSet);

            $io->success("Maximum achievable value: $maxValue");
            return Command::SUCCESS;

        } catch (TreatOptimizationException $e) {
            $io->error("Optimization error: " . $e->getMessage());
            return Command::FAILURE;

        } catch (\Throwable $e) {
            $io->error("Unexpected error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Parses the input treat string into an array of integers.
     *
     * @param string $input Comma-separated treat values
     * @return int[]
     */
    private function parseTreats(string $input): array
    {
        return array_map('intval', array_filter(explode(',', $input), fn($val) => $val !== ''));
    }
}
