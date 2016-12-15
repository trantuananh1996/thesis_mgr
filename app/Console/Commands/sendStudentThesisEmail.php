<?php

namespace App\Console\Commands;

use App\StudentThesisEmail;
use App\Term;
use App\User;
use Carbon\Carbon;
use Config;
use Illuminate\Console\Command;
use Mail;

class sendStudentThesisEmail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:student-thesis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to students for register thesis';

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
        $emails = StudentThesisEmail::where('status', '=', 0)->get();

        if (count($emails) == 0) {
            $this->info('There was no email to send');

            return;
        }

        foreach ($emails as $email) {
            switch ($email->type) {
                //case send email for term announce
                case 1:
                    $this->sendEmailAnnounceTerm($email);
                    break;
                default:
                    break;
            }

        }

        $this->info('Finish sending email to students');

        return;
    }

    public function sendEmailAnnounceTerm($email)
    {
        $term = Term::find($email->term_id);
        if (is_null($term)) {
            $email->status = 1;
            $email->save();

            return;
        }
        $student_ids = json_decode($term->log);

        if (!in_array($email->student_id, $student_ids)) {
            $email->status = 1;
            $email->save();

            return;
        }

        $student = User::find($email->student_id);

        $data = array(
            'full_name' => $student->getFullName(),
            'term_name' => $term->name,
            'start_date' => Carbon::parse($term->start_date)->format('d-m-Y'),
            'end_date' => Carbon::parse($term->end_date)->format('d-m-Y'),
        );

        $student_email = $student->email;
        Mail::send('emails.announce-term', $data, function ($message) use ($student_email)
        {
            $message->from(Config::get('mail.username'));
            $message->to($student_email)->subject('[Thesis]- Thông báo mở đợt đăng ký đề tài!');
        });

        $email->status = 1;
        $email->save();

        return;
    }
}
