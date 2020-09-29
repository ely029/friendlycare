<?php

declare(strict_types=1);

namespace App\Console\Commands\ThinkBIT;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Str;

class CheckPathnames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thinkbit:check_pathnames';

    /**
     * The console command description.
     * This prevents `ERROR: gcloud crashed (UnicodeDecodeError): 'ascii' codec can't decode byte 0xc3 in position 19: ordinal not in range(128)` when deploying to GCP.
     *
     * @var string
     */
    protected $description = 'Check pathnames for proper encoding';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = [];
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./'));
        $bar = $this->output->createProgressBar(iterator_count($rii));
        $bar->start();

        foreach ($rii as $file) {
            if ($file->isDir()) {
                $bar->advance();

                continue;
            }

            $files[] = $file->getPathname();
            $bar->advance();
        }

        $bar->finish();
        $this->line(''); // Adds a new line from the progress bar to the messages below
        $this->processFiles($files);
    }

    private function processFiles($files)
    {
        $matches = preg_grep('/[^[:ascii:]]+/', $files);
        $matchesCount = count($matches);

        if ($matchesCount > 0) {
            $header = 'Invalid pathname';
            $table = [];

            foreach ($matches as $match) {
                $table[] = [$header => $match];
            }

            $this->table([$header], $table);

            $fileString = Str::plural('path', $matchesCount);
            $this->error("[ERROR] ${matchesCount} ${fileString} have non-ASCII pathnames");
        } else {
            $this->info('[OK] All pathnames are ASCII');
        }
    }
}
