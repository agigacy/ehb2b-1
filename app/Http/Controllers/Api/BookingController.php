<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Reminder;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use App\Mail\TourBookingConfirmation;
// use Codedge\Tcpdf\Facades\Tcpdf;
use TCPDF;
// use Codedge\Tcpdf\Tcpdf as BaseTcpdf;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Booking::all();
        $bookings = Booking::with('user', 'tour','passengers')->get();
        return response()->json($bookings, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try 
        {
            $bookingData = $request->only(['tour_id', 'date', 'total', 'user_id', 'status']);
            $booking = Booking::create($bookingData);

            if ($request->has('passengers')) {
                foreach ($request->passengers as $index => $passengerData) {
                    $passenger = new Passenger([
                        'name' => $passengerData['name'],
                        'passport' => $passengerData['passport'],
                        'date_of_birth' => $passengerData['date_of_birth'],
                        'designation' => $passengerData['designation'],
                        'hp' => $passengerData['hp'],
                        'remark' => $passengerData['remark'],
                        // 确保其他字段也被正确处理
                    ]);
                    if ($request->hasFile("passengers.$index.passport_upload")) {
                        $file = $request->file("passengers.$index.passport_upload");
                        $path = $file->store('public/passports');
                        $url = Storage::url($path);
                        $passenger->passport_upload = $url;
                    }
                    $booking->passengers()->save($passenger);
                }
                
                // Create reminders - Antoney working
                $this->createReminders($booking);
                
                // Create reminders - Antoney working
                // $this->pdfBilling($booking);
                
                // Generate the PDF and get the file path
                $pdfPath = $this->pdfBilling($booking);


                // Send email confirmation
                // Mail::to($request->user()->email)->send(new TourBookingConfirmation($booking));
                Mail::to($request->user()->email)->send(new TourBookingConfirmation($booking, $pdfPath));

                // Send email confirmation
                // Mail::to($request->user()->email)->send(new TourBookingConfirmation($booking));
                // Mail::to('test@example.com')->send(new TourBookingConfirmation($booking));

                return response()->json($booking->load('passengers'), 201);

            } 
        }
        catch (\Exception $e) 
        {
            \Log::error('Error creating booking:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error creating booking', 'error' => $e->getMessage()], 500);
        }
    }

    // Antoney working for reminders - booking tour
    private function createReminders($booking)
    {
        $reminders = [];

        // Create the first reminder
        $firstReminderDate = date('Y-m-d H:i:s', strtotime('+24 hours', strtotime($booking->created_at)));
        $reminderBeforeFlight = new Reminder([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'date' => $firstReminderDate,
            'before' => '90',
            'title' => 'First Payment Reminder - Tour Booking',
            'info' => 'Tour Booked Total Amount - ' . $booking->total,
        ]);
        $reminders[] = $reminderBeforeFlight;

        // Create the second reminder
        $secondReminderDate = date('Y-m-d H:i:s', strtotime('+2 weeks', strtotime($booking->created_at)));
        $reminderBeforeTotal = new Reminder([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'date' => $secondReminderDate,
            'before' => '30',
            'title' => 'Second Payment Reminder - Tour Booking',
            'info' => 'Tour Booked Total Amount - ' . $booking->total,
        ]);
        $reminders[] = $reminderBeforeTotal;

        // Insert each reminder individually
        foreach ($reminders as $reminder) {
            $reminder->save();
        }


        // $reminder = new Reminder([
        //     // 'flight_ticket_id' => $booking->flight_ticket_id,
        //     // 'flight_ticket_id' => $booking->tour_id,
        //     'booking_id' => $booking->id,
        //     'user_id' => $booking->user_id,
        //     'date' => $booking->date,
        //     // 'before' => 'Flight', // This indicates it's before the flight
        //     'before' => '90', // This indicates it's before the flight
        //     // Add other fields accordingly
        //     'title' => 'First Payment Reminder - Tour Booking',
        //     'info' => 'Tour Booked Total Amount - ' . $booking->total,
        // ]);

        // $reminder->save();
    }

    public function pdfBilling($booking)
    {
        // Fetch billing data
        // $bill = Billing::findOrFail($billing);

        $filename = 'billing_tour_ID_' . $booking->id . '_' . date("d-m-Y", strtotime($booking->created_at)) . '.pdf';  


        // Initialize TCPDF
        $pdf = new TCPDF;
        // Remove default header line
        $pdf->SetPrintHeader(false);
        $pdf->SetTitle('Billing_' . $booking->id);
        $pdf->AddPage();

        // $booking = Booking::with('passengers')->find($id); // Eager load the passengers
        $passengerCount = $booking->passengers->count();

        $userId = $booking->user_id;
        $user = User::with('groups')->find($userId);
        // $userGroupName = $user->groups->pluck('name');
        // $userGroupAddress = $user->groups->pluck('address');
        $userGroupName = $user->groups->pluck('name')->implode(', ');
        $userGroupAddress = $user->groups->pluck('address')->implode(', ');

        $userGroupSSM = $user->ssm_number;
        $userGroupPhone = $user->phone;


        // Generate HTML content including billing data
        $html = '
        <style>
            h1 {
                color: blue;
            }
            h3 {
                color: blue;
                font-size: 10px;
            }
            h3 {
                font-size: 9px;
            }
            p {
                font-size: 8px;
            }
            br {
                display: block;
                margin: 4px 0;
            }
        </style>
            <table style="border: none">
                <thead>
                    <tr style="text-align: center; font-size: 6px; background-color: #f4f0f0;">
                        <th style="width: 100%; text-align: center; padding-top:20px">                        
                            <p style="padding:2px;">
                                <img src="http://www.esplanad.com.my/wp-content/uploads/2015/04/esplanad-logo.png" style="padding-top: 10px; text-align: center; width: 60px;" />
                            </p>
                            <p style="font-size: 9px; margin: 0px; padding: 0px;"><b>ESPLANAD HOLIDAY SDN BHD</b><br />
                                <!--<span style="font-size: 6px; font-weight: bold">Your First Choice Holiday Supplier</span><br />-->
                                <span style="font-size: 6px; line-height: 6px;">79-2, Jalan Dwitasik 1, Dataran Dwitasik,
                                Bandar Sri Permaisuri, 56000 Cheras,
                                Kuala Lumpur, Malaysia <br />
                                    <span class="pr-3">T (603) 9173 6300</span> <span class="pr-3"> F (603) 9171 6300</span>      W <span style="color: blue">www.esplanad.com.my</span>
                                </span>
                                <br />
                            </p>
                        </th>

                    </tr>
                    <br />                

                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" class="col-12"><h3 style="color: #383838; text-align: center; padding-top: 0; padding-bottom: 30px;"><br />Invoice</h3></td>
                    </tr>
                    <br /> 

                    <tr style="text-align: left; font-size: 8px;">
                        <th scope="col" style="width: 80px">Date</th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"> : </th>
                        <!--<th scope="col" style="width: 100px" class="text-right pr-1">' . date("d-m-Y", strtotime($booking->created_at)) . '</th>-->
                        <th scope="col" style="width: 100px" class="text-right pr-1">' . date("d F Y", strtotime($booking->created_at)) . '</th>

                    </tr>
                    <tr style="text-align: left; font-size: 8px;">
                        <th scope="col" style="width: 80px">Invoice No.</th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"> : </th>
                        <th scope="col" style="width: 100px" class="text-right pr-1">' . $booking->id . '</th>
                    </tr>
                    <tr style="text-align: left; font-size: 8px;">
                        <th scope="col" style="width: 80px">SST No.</th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"> : </th>
                        <th scope="col" style="width: 100px" class="text-right pr-1">001303496300</th>
                    </tr>
                    
                    <tr style="text-align: left; font-size: 8px;">
                        <th scope="col" style="width: 80px">Type</th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"> : </th>
                        <th scope="col" style="width: 100px" class="text-right pr-1">Final</th>
                    </tr>
                    <tr style="text-align: left; font-size: 8px;">
                        <th scope="col" style="width: 80px"></th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"> </th>
                        <th scope="col" style="width: 100px" class="text-right pr-1"></th>
                    </tr>
                    <tr style="text-align: left; font-size: 8px;">
                        <th scope="col" style="width: 80px">Bill To</th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"> : </th>
                        <th scope="col" style="width: 100px" class="text-right pr-1">' . $booking->user->name  . '</th>
                        <th scope="col" style="width: 320px; float: right; text-align: right" class="text-right pr-1">By: Email</th>
                    </tr>
                    
                    <tr style="text-align: left; font-size: 8px;">
                        <th scope="col" style="width: 80px"></th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"></th>
                        <th scope="col" style="width: 200px" class="text-right pr-1">' . $booking->user->email  . '</th>
                    </tr>
                    <tr style="text-align: left; font-size: 8px; font-weight: bold">
                        <th scope="col" style="width: 80px"></th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"></th>
                        <th scope="col" style="width: 200px" class="text-right pr-1">' . $userGroupName  . '</th>
                    </tr>
                    <tr style="text-align: left; font-size: 7px;">
                        <th scope="col" style="width: 80px"></th>
                        <th scope="col" style="width: 20px" class="text-center pr-1"></th>
                        <th scope="col" style="width: 300px" class="text-right pr-1">' . $userGroupAddress  . '</th>
                    </tr>
                    <br />
                    <br />
                    <br />
                
                    <!-- Include the table head content here -->
                    <tr style="text-align: left; font-size: 8px;">
                        <th colspan="5">
                            <h6 class="font-weight-bold" style="text-align: left; font-size: 9px;">Tour Booking: ' . $booking->tour->package_name . ' (' . $passengerCount . ' Pax)</h6>
                            <p class="text-left mb-1" style="text-align: left; font-size: 8px; font-weight: 100;">Billing Details:</p>
                        </th>
                    </tr>
                    <tr style="text-align: left; font-size: 8px;">
                        <th colspan="5">
                            
                        </th>
                    </tr>

                    <tr style="text-align: center; font-size: 8px; text-decoration: underline;">
                        <!-- <th scope="col">#Id</th> -->
                        <th scope="col" style="text-align: left; width: 250px; font-size: 8px; padding-right: 50px">Tour Package</th>
                        <th scope="col" style="text-align: right; width: 90px; font-size: 8px;">Airline</th>
                        <th scope="col" style="text-align: right; width: 80px; font-size: 8px;">Pax</th>
                        <th scope="col" style="text-align: right; width: 30px; font-size: 8px;"></th>
                        <th scope="col" style="text-align: right; width: 90px; font-size: 8px;">Total (RM)</th>                    
                    </tr>
                    <br />
                    ';

            $html .= '
                <tr style="font-size: 8px;">
                    <td style="text-align: left; width: 250px">' . $booking->tour->package_name . '</td>
                    <td style="text-align: right; width: 90px">' . $booking->tour->airline . '</td>
                    <td style="text-align: right; width: 80px">' . $passengerCount . '</td>
                    <td style="text-align: right; width: 30px"></td>
                    <td style="text-align: right; width: 90px">' . number_format($booking->total, 2) . '</td>
                </tr>
                <br />
            ';
            

            
                    $html .= '      
                    <tr style="font-size: 8px;">
                        <td style="text-align: left; width: 250px"></td>
                        <td style="text-align: right; width: 90px;"></td>
                        <td style="text-align: right; width: 80px;"></td>
                        <td style="text-align: right; width: 30px; border-top: 0.5px dotted #666;"></td>
                        <td style="text-align: right; width: 90px; border-top: 0.5px dotted #666;"></td>
                    </tr> 
                    <tr style="font-size: 8px;">
                        <td><b>Total Amount Due</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"><b></b></td>
                        <td style="text-align: right;"><b>' . number_format($booking->total, 2) . '</b></td>
                    </tr>
                    <br />
                    <tr style="font-size: 8px; padding-top: 0">
                        <td style="text-align: left; width: 250px"></td>
                        <td style="text-align: right; width: 90px;"></td>
                        <td style="text-align: right; width: 80px;"></td>
                        <td style="text-align: right; width: 30px; border-top: 0.5px dotted #666; border-bottom: 0.5px double #666;"></td>
                        <td style="text-align: right; width: 90px; border-top: 0.5px dotted #666; border-bottom: 0.5px dotted #666;"></td>
                    </tr>                 
                    
                    <br /> 
                    <br /> 
                    <br /> 
                    <br /> 
                    <tr style="border: none" class="pl-0">
                        <th class="text-left pt-3 mt-1 pl-0" colspan="5">
                            <p style="font-size: 7px; line-height: 9px; font-weight: 200; font-family: arial, century gothic, san-serif; word-spacing: 2px;">
                                <b>Note</b><br />
                                <span style="padding-left: 10px;">  - The total amount due is payable <span style="font-weight: bold">fourteen (14) days</span> upon receipt of this invoice;</span><br />
                                <span style="padding-left: 10px;">  - Cheque or bank draft should be made payable to "<span style="font-weight: bold">ESPLANAD HOLIDAY SDN BHD</span>";</span><br />
                                <span style="padding-left: 10px;">  - Kindly quote our reference in your payment advice and update us on your payment details by phone, fax, mail or via email to <span style="font-weight: bold">info@esplanad.com.my</span></span>
                            </p>
                        </th>
                    </tr>
                </tbody>
                
            </table>
        ';

        // Write HTML content to PDF
        $pdf->writeHTML($html);

        // Check if it's the last page
        if ($pdf->getNumPages() > 1) {
            $pdf->lastPage();
            $pdf->SetY(-28); // Position the footer at the bottom of the last page
            $pdf->writeHTML('<tfooter><p style="text-align:center; font-size: 6px; line-height: 7px; font-weight: 200; font-family: arial, century gothic, san-serif; word-spacing: 2px;">
            <b>ESPLANAD HOLIDAY SDN BHD</b>:<br />
            <span style="text-align:center;"> 79-2, Jalan Dwitasik 1, Dataran Dwitasik,
Bandar Sri Permaisuri, 56000 Cheras,
Kuala Lumpur, Malaysia.</span><br />
            <span style="text-align:center;"> <span class="pr-3">T (603) 9173 6300</span> <span class="pr-3"> F (603) 9171 6300</span>      W <span style="color: blue">www.esplanad.com.my</span></span>
        </p></tfooter>');
        } else {
            $pdf->SetY(-28); // Position the footer at the bottom of the last page
            $pdf->writeHTML('<tfooter><p style="text-align:center; font-size: 6px; line-height: 7px; font-weight: 200; font-family: arial, century gothic, san-serif; word-spacing: 2px;">
                                <b>ESPLANAD HOLIDAY SDN BHD</b>:<br />
                                <span style="text-align:center;"> 79-2, Jalan Dwitasik 1, Dataran Dwitasik,
Bandar Sri Permaisuri, 56000 Cheras,
Kuala Lumpur, Malaysia.</span><br />
                                <span style="text-align:center;"> <span class="pr-3">T (603) 9173 6300</span> <span class="pr-3"> F (603) 9171 6300</span>      W <span style="color: blue">www.esplanad.com.my</span></span>
                            </p></tfooter>');

        }

        // Output PDF to file
        // $pdf->Output(public_path($filename), 'F');
        // $pdf->Output(public_path($filename), 'F');
        // $pdf->Output(storage_path('app/invoices/' . $filename), 'F');
        // $pdf->Output(public_path($filename), 'F');

        // Solution 2 for return pdfPath
        // $pdfPath = storage_path('app/public/billings/' . $filename);
        // $pdf->Output($pdfPath, 'F'); // 'F' to save the file to the server

        // return $pdfPath; // Return the full path for use in the email

        // Define the storage path
        $directory = storage_path('app/public/billings');
        
        // Check if directory exists, if not create it
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        // Define the full path to save the PDF
        $pdfPath = $directory . '/' . $filename;

        // Save PDF to disk
        $pdf->Output($pdfPath, 'F'); // 'F' to save the file to the server

        return $pdfPath; // Return the full path for use in the email


        // Update the billingFilename in the database
        // DB::table('billings')
        //     ->where('id', $bill->id)
        //     ->update(['billingFilename' => $filename]);

        // Download the PDF
        // return response()->download(storage_path('app/invoices/' . $filename));
        // return response()->download(public_path($filename));
    }


    public function CY_store(Request $request)
    {
        // 直接创建 Booking 对象，包括 passengers 数据
        $booking = Booking::create($request->all());

        return response()->json($booking->load('passengers'), 201);
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'min:1|max:255',
            'passport' => 'min:1|max:255',
            'designation' => 'min:1|max:255',   
            'date_of_birth' => 'min:1|max:255',   
            'hp' => 'min:1|max:255',   
            'passport_upload' => 'file',   
            'remark' => 'max:255',   
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Booking::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return response()->json($booking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Booking::destroy($id);
        return response()->json(null, 204);
    }
}
