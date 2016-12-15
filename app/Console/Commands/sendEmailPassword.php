<?php

namespace App\Console\Commands;

use App\User;
use App\UserEmailPassword;
use Illuminate\Console\Command;

class sendEmailPassword extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email password to users after created';

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
        $emails = UserEmailPassword::where('status', '=', 0)->get();

        if (count($emails) == 0) {
            $this->info('There was no email to send!');

            return;
        }

        foreach ($emails as $email) {
            $user = User::where('id', '=', $email->user_id)->first();
            if (is_null($user)) {
                $email->status = 1;
                $email->save();

                return;
            }

            $user->sendPasswordOnEmail(decrypt($email->password));
            $email->status = 1;
            $email->save();
        }

        $this->info('Finish sending email to users');
    }
}
