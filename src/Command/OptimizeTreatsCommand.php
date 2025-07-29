<?php

namespace App\Command;

use App\Zabbix\Collection\TreatSet;
use App\Zabbix\Exception\TreatOptimizationException;
use App\Zabbix\Service\RecursiveTreatOptimizer;
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

    protected function configure(): void
    {
        $this
            ->addArgument('treats', InputArgument::REQUIRED, 'Comma-separated list of treat values');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $raw = $input->getArgument('treats');
        $treats = array_map('intval', explode(',', $raw));

        try {
            $treatSet = new TreatSet($treats);
            $optimizer = new RecursiveTreatOptimizer();
            $max = $optimizer->maximize($treatSet);
            $io->success("Maximum value: $max");
        } catch (TreatOptimizationException $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        } catch (\Throwable $e) {
            $io->error("Unexpected error: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
