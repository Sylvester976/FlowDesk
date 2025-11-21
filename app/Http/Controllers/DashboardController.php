<?php

namespace App\Http\Controllers;

use App\Mail\CustomEmail;
use App\Mail\StaffRegistered;
use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use App\Models\Country;
use App\Models\County;
use App\Models\Subcounty;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class DashboardController extends Controller
{
    public function index()
    {
        if ($redirect = checkLegitUser()) {
            return $redirect; // redirect if not allowed
        }
        return view('dashboard.dashboard');
    }

    public function getSubcounties($countyId)
    {
        $subcounties = Subcounty::where('county_id', $countyId)->get();
        return response()->json($subcounties);
    }

    public function dashboardStaff()
    {
        $user_id = auth()->id();

        // Number of assignments
        $mytrips = Assignment::where('user_id', $user_id)->count();

        // Number of pending assignments
        $active_assignments = Assignment::where('user_id', $user_id)
            ->where('status', 'pending')
            ->count();

        // Number of countries visited (not Kenya = id 87)
        $countries_visited = Assignment::where('user_id', $user_id)
            ->where('country_of_visit', '!=', 87)
            ->count();

        $kenya_places = ($mytrips - $countries_visited);

        // Get latest pending assignment (latest created)
        $current_assignment = Assignment::where('user_id', $user_id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        // Current assignment name
        $current_assignment_name = $current_assignment?->assignment_name ?? 'N/A';
        $current_assignment_country = getCountryName($current_assignment?->country_of_visit ) ?? 'N/A';

        // Format end date as (M d, Y) e.g. "Nov 21, 2025"
        $current_assignment_end_date = $current_assignment?->end_date
            ? \Carbon\Carbon::parse($current_assignment->end_date)->format('M d, Y')
            : 'N/A';

        return view('dashboard.dashboard_staff', [
            'mytrips' => $mytrips,
            'active_assignments' => $active_assignments,
            'countries_visited' => $countries_visited,
            'kenya_places' => $kenya_places,
            'current_assignment' => $current_assignment,
            'current_assignment_name' => $current_assignment_name,
            'current_assignment_end_date' => $current_assignment_end_date,
            'current_assignment_country' => $current_assignment_country,
        ]);
    }


    public function save_staff(Request $request)
    {
        // Validate inputs
        $request->validate([
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'idno' => 'required|string|max:50|unique:users,idNumber',
            'email' => 'required|email|unique:users,email',
            'upn' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'date_of_appointment' => 'nullable|date',
        ]);

        $password = generateRandomStrongPassword(12);

        // Save in User model
        $user = User::create([
            'name' => $request->first_name,
            'surname' => $request->surname,
            'other_names' => $request->last_name,
            'idNumber' => $request->idno,
            'email' => $request->email,
            'phone' => $request->phone,
            'pfNumber' => $request->upn,
            'designation' => $request->designation,
            'date_of_birth' => $request->date_of_birth,
            'date_of_appointment' => $request->date_of_appointment,
            'password' => Hash::make($password),
            'role' => 2,
        ]);

        try {
            // Send Markdown email with automatic vendor layout
            Mail::to($user->email)
                ->send(new StaffRegistered($user->name, $user->email, $password));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Staff saved, but failed to send email: ' . $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Staff registered successfully and email sent!',
            'user_id' => $user->id
        ]);
    }

    public function assignmentAdd()
    {
        $countries = Country::all();
        $counties = County::all();

        $data = array(
            'countries' => $countries,
            'counties' => $counties
        );

        return view('assignments.assignment_add', $data);
    }

    public function save_assignment(Request $request)
    {

        $request->validate([
            'assignment_name' => 'required|string|max:255',
            'country_of_visit' => 'required|integer|exists:countries,id',
            'county' => 'nullable|integer|exists:counties,id',
            'subcounty' => 'nullable|integer|exists:subcounties,id',
            'city' => 'required|string|max:255',
            'attachments' => 'required|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'supervisor' => 'required|string|max:255',
            'email' => 'required|email',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
        ]);

        //save in assignment table
        $assignment = Assignment::create([
            'user_id' => auth()->id(),
            'assignment_name' => $request->assignment_name,
            'country_of_visit' => $request->country_of_visit,
            'county' => $request->county,
            'subcounty' => $request->subcounty,
            'location' => $request->city,
            'city' => $request->city,
            'supervisor_name' => $request->supervisor,
            'supervisor_email' => $request->email,
            'start_date' => $request->start,
            'end_date' => $request->end,
        ]);

        //Save attachments
        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $file) {

                // Unique filename
                $filename = time() . '_' . uniqid() . '.'
                    . $file->getClientOriginalExtension();

                // Store file
                $file->storeAs('assignments/' . $assignment->id, $filename, 'public');

                // Save DB record
                AssignmentAttachment::create([
                    'user_id' => auth()->id(),
                    'assignment_id' => $assignment->id,
                    'attachment_name' => $filename,
                ]);
            }
        }


        try {
            $assignmentMessage = '';

            // Greeting
            $assignmentMessage .= '<p>Dear ' . $assignment->supervisor_name . ',</p>';

            // Intro
            $assignmentMessage .= '<p>I would like to inform you of my upcoming assignment. Please find the details below:</p>';

            // Assignment details in a clean table
            $assignmentMessage .= '<table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; max-width: 600px;">';
            $assignmentMessage .= '<tr style="background-color: #e9f2ff;"><th align="left">Field</th><th align="left">Details</th></tr>';
            $assignmentMessage .= '<tr><td><strong>Assignment Name</strong></td><td>' . $assignment->assignment_name . '</td></tr>';

            if ($assignment->country_of_visit == 87) {
                $assignmentMessage .= '<tr><td><strong>County</strong></td><td>' . getCountyName($request->county) . '</td></tr>';
                $assignmentMessage .= '<tr><td><strong>Subcounty</strong></td><td>' . getSubcountyName($request->subcounty) . '</td></tr>';
                $assignmentMessage .= '<tr><td><strong>City</strong></td><td>' . $assignment->city . '</td></tr>';
            } else {
                $assignmentMessage .= '<tr><td><strong>Country</strong></td><td>' . getCountryName($request->country_of_visit) . '</td></tr>';
                $assignmentMessage .= '<tr><td><strong>City</strong></td><td>' . $assignment->city . '</td></tr>';
            }

            $assignmentMessage .= '<tr><td><strong>Start Date</strong></td><td>' . Carbon::parse($assignment->start_date)->format('d M Y') . '</td></tr>';
            if ($assignment->end_date) {
                $assignmentMessage .= '<tr><td><strong>End Date</strong></td><td>' . Carbon::parse($assignment->end_date)->format('d M Y') . '</td></tr>';
            }
            $assignmentMessage .= '</table>';

            // Polite closing
            $assignmentMessage .= '<p>I appreciate your guidance and support regarding this assignment. Please let me know if there are any specific instructions or clarifications needed.</p>';
            $assignmentMessage .= '<p>Thank you.</p>';
            $assignmentMessage .= '<p>Best regards,<br>Your Name</p>';


            // Send email
            Mail::to($assignment->supervisor_email)
                ->send(new CustomEmail('New Assignment Notification', $assignmentMessage));

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Staff saved, but failed to send email: ' . $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success',
          'message' => 'Assignment Registered successfully!',
        ]);


    }

    public function assign_history(){

        $data = array(
            'assignments' => Assignment::where('user_id', auth()->id())->get(),
        );

        return view('assignments.assignment_history', $data);


    }

    public function viewMoreInfo($id){
        $data = array(
            'assignment' => Assignment::where('id', $id)->get(),
            'attachments' => AssignmentAttachment::where('assignment_id', $id)->get()
        );
        return view('assignments.viewMore', $data);
    }


}
