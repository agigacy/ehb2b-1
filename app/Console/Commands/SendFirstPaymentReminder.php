<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Mail\FirstPaymentReminder;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\BookingController;


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
    protected $bookingController;

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
    public function __construct(BookingController $bookingController)
    {
        parent::__construct();
        $this->bookingController = $bookingController;
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
            // Mail::to($booking->user)->send(new FirstPaymentReminder($booking));
            // $pdfPath = $this->pdfBilling($booking); // Assuming pdfPath is generated here
            

            $pdfPath = $this->bookingController->pdfBilling($booking);
            Mail::to($booking->user)->send(new FirstPaymentReminder($booking, $pdfPath));
        }

        $this->info('First Payment reminders sent successfully.');
    }
    
}
