<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateSubmisi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Update:Submisi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Submission when the submisi expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Update All Submisi Expired
        $sql = array(
            DB::raw('t_submissions.submisi_id'),
            DB::raw('t_submissions.submisi_expired_at'),
        );
        $submissions = DB::table('t_submissions')->select($sql)->whereRaw('DATEDIFF(submisi_expired_at, now()) < 0')->get(); 
        foreach ($submissions as $submission) {
            DB::table('t_submissions')
                ->where('submisi_id', $submission->submisi_id)
                ->update([
                    'submisi_is_active' => "0"
                ]);
        }
    }
}
