<?php

namespace App\Jobs;

use App\Mail\SendMailToCreatedCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailToCreatedCompanyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailData = [];
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->mailData = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->mailData['email'])->send(new SendMailToCreatedCompany($this->mailData));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
