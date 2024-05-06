<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Mail\FirstPaymentReminder;
use Illuminate\Support\Facades\Mail;


class SendFirstPaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';

    protected $signature = 'reminder:send-payment';
    protected $description = 'Send first payment reminders to users';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

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
        // return 0;
        // Fetch bookings that require a payment reminder (e.g., booked yesterday)
        // $bookings = Booking::whereDate('created_at', today()->subDays(1))->get();
        // $bookings = Booking::where('created_at', '>=', now()->subMinutes(15))->get();
        $bookings = Booking::where('created_at', '>=', now()->subMinutes(2))->get();

        // Send reminders to each booking
        foreach ($bookings as $booking) {
            Mail::to($booking->user)->send(new FirstPaymentReminder($booking));
        }

        $this->info('First Payment reminders sent successfully.');
    }
    
}
