<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GamCampaingsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamcampains:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl, [
            CURLOPT_URL => env('URL_END_POINT_GAM_API_CAMPAIGN'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"]
        );

            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;
            /* $values = (json_decode($response,true));
            print_r($values); */
    }
}
