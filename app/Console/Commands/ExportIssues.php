<?php

namespace App\Console\Commands;

use App\Models\Issue;
use Illuminate\Console\Command;

class ExportIssues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:issues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports issues to JIRA.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var \Maatwebsite\Excel\Excel $excel */
        $excel = app('excel');

        $excel->create('issues', function ($excel) {
            $excel->sheet('issues', function ($sheet) {
                $issues = Issue::all();

                $headers = [
                    'title',
                    'description',
                    'resolution',
                ];

                $row = 1;

                $sheet->row($row, $headers);

                foreach ($issues as $issue) {
                    $row++;

                    $resolution = $issue->findCommentResolution();

                    $sheet->row($row, [
                        $issue->title,
                        $issue->description,
                        ($resolution ? $resolution->content : null),
                    ]);
                }
            });
        })->store('xls');
    }
}
