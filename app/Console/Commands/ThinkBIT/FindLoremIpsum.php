<?php

declare(strict_types=1);

namespace App\Console\Commands\ThinkBIT;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Str;

class FindLoremIpsum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thinkbit:find_lorem_ipsum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find lorem ipsum in files';

    private $matches = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->findMatches();
        $matchesCount = count($this->matches);

        if ($matchesCount > 0) {
            $fileString = Str::plural('paths', $matchesCount);
            $header = 'Pathname with Placeholder';
            $table = [];

            foreach ($this->matches as $match) {
                $table[] = [$header => $match];
            }

            $this->table([$header], $table);
            $this->error("[ERROR] ${matchesCount} ${fileString} have at least 1 placeholder");

            return 1; // Exit code
        }

        $this->info('[OK] All pathnames have no placeholders');
    }

    private function findMatches()
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./'));
        $bar = $this->output->createProgressBar(iterator_count($rii));
        $bar->start();

        foreach ($rii as $file) {
            if ($this->shouldSkip($file)) {
                $bar->advance();

                continue;
            }

            $this->findMatch($file);
            $bar->advance();
        }

        $bar->finish();
        $this->line(''); // Adds a new line from the progress bar to the messages below

        return $this->matches;
    }

    private function shouldSkip($file)
    {
        if ($file->isDir()) {
            return true;
        }

        if ($file->getRealPath() === __FILE__) {
            return true;
        }

        if (Str::startsWith($file->getPathname(), [
            './.git',
            './resources/docs',
            './storage/logs',
            './vendor',
            './.gitlab-ci.',
        ])) {
            return true;
        }
    }

    private function findMatch($file)
    {
        $contents = file_get_contents($file->getPathname());

        if (Str::contains($contents, ['lorem', 'ipsum'])) {
            $this->matches[] = $file->getPathname();
        }
    }
}
