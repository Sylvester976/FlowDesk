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
        if ($redirect = checkLegitUser())
        {
            return $redirect; // redirect if not allowed
        }

        // lets define here data going to dashboard
        $employee_no = User::all() -> count('user_id');
        $pending = 'pending';
        $kenya = 87;
        $currently_travelling = Assignment::where('status', $pending)
            ->distinct('user_id')
            ->count('user_id');

        $today = Carbon::today();

        $active_assignments = Assignment::where('status', $pending)
            ->orWhere('end_date', '>=', $today) // or use your date column
            ->count('user_id');

        $countries_covered = Assignment::where('country_of_visit', '!=', $kenya)
            ->count('user_id');

        $recent_assignments = Assignment::select(
            'user_id',
            'country_of_visit',
            'assignment_name',
            'start_date',
            'status'
        )
            ->orderBy('start_date', 'desc')
            ->orderBy('id', 'desc')
            ->where('country_of_visit', '!=', $kenya)
            ->take(5)
            ->get();

        $top_countries = Assignment::select('country_of_visit')
            ->selectRaw('COUNT(id) as total')
            ->where('country_of_visit', '!=', 87)
            ->groupBy('country_of_visit')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                return [
                    'country_name' => getCountryName($row->country_of_visit),
                    'total' => $row->total,
                ];
            });

        $maxTrips = $top_countries->max('total');

        $data = [
            'employee_no' => $employee_no,
            'currently_travelling' => $currently_travelling,
            'active_assignments' => $active_assignments,
            'countries_covered' => $countries_covered,
            'recent_assignments' => $recent_assignments,
            'top_countries' => $top_countries,
            'maxTrips' => $maxTrips,   // ⬅️ Add this
        ];

        return view('dashboard.dashboard', $data);


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
        $mytrips = Assignment::where('user_id', $user_id)->count('user_id');

        // Number of pending assignments
        $active_assignments = Assignment::where('user_id', $user_id)
            ->where('status', 'pending')
            ->count('user_id');

        // Number of countries visited (not Kenya = id 87)
        $countries_visited = Assignment::where('user_id', $user_id)
            ->where('country_of_visit', '!=', 87)
            ->count('user_id');

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
            'role_id' => 'nullable|integer|exists:roles,id',
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
            'role' => $request->role_id,
        ]);

        try {
            $staffMessage = '';

            // Greeting
            $staffMessage .= '<p>Dear ' . $user->name . ' '. $user->surname. ' '. $user->other_names. ',</p>';

            // Intro
            $staffMessage .= '<p>Your account has been successfully created. Below are your login details:</p>';

            // Details table
            $staffMessage .= '<table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; max-width: 600px;">';
            $staffMessage .= '<tr style="background-color: #e9f2ff;"><th align="left">Field</th><th align="left">Details</th></tr>';
            $staffMessage .= '<tr><td><strong>Email</strong></td><td>' . $user->email . '</td></tr>';
            $staffMessage .= '<tr><td><strong>Password</strong></td><td>' . $password . '</td></tr>';
            $staffMessage .= '</table>';

            // Security note
            $staffMessage .= '<p style="color: red;"><strong>Important:</strong> Please change your password after first login.</p>';

            // ✅ LOGIN BUTTON
            $loginUrl = url('/login'); // change if your route is different

            $staffMessage .= '
        <p style="text-align: center; margin: 30px 0;">
            <a href="' . $loginUrl . '"
               style="
                   background-color: #2563eb;
                   color: #ffffff;
                   padding: 12px 24px;
                   text-decoration: none;
                   border-radius: 6px;
                   font-weight: bold;
                   display: inline-block;
               ">
                Login Now
            </a>
        </p>
    ';

            // Closing
            $staffMessage .= '<p>Best regards,<br>Management</p>';

            // Send email
            Mail::to($user->email)
                ->send(new CustomEmail('Your Account Has Been Created', $staffMessage));

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
            'assignments' => Assignment::where('user_id', auth()->id())
                ->orderBy('id', 'desc')
                ->get(),
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

    public function activeAssignment()
    {
        $today = Carbon::today();
        $active_assignments = Assignment::where('end_date', '>=', $today)
            ->orderBy('start_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('assignment_name')
            ->values();

        $data = array(
            'active_assignments' => $active_assignments,
        );
        return view('assignments.activeAssignment', $data);

    }

    public function assignmentHistory()
    {
        $today = Carbon::today();

        $all_users = User::select('id', 'name', 'pfNumber', 'surname', 'other_names')
            ->with(['assignments' => function($query) use ($today) {
                $query->where('end_date', '>', $today)
                    ->orderBy('end_date', 'asc')  // earliest ending first
                    ->limit(1);                   // only current assignment
            }])
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name.' '.$user->surname.' '.$user->other_names,
                    'pfNumber' => $user->pfNumber,
                    'current_assignment' => $user->assignments->first()->assignment_name ?? 'No Active Assignment',
                    'end_date' => $user->assignments->first() ? Carbon::parse($user->assignments->first()->end_date)->format('d M Y') : 'N/A',
                ];
            });

        $data = array(
            'all_users' => $all_users,
        );

        return view('assignments.history', $data);
    }

    public function viewAssignmentHistory($id)
    {
        $today = Carbon::today();
        $my_assignments = Assignment::where('user_id', $id)->orderBy('id', 'desc')->get();
        $user = User::select('id', 'name', 'surname', 'other_names', 'pfNumber', 'designation', 'email', 'status')
            ->where('id', $id)
            ->first();
        $current_assignments = Assignment::select(
            'assignment_name',
            'country_of_visit',
            'county',
            'subcounty',
            'city',
            'start_date',
            'end_date'
        )
            ->where('user_id', $id)
            ->where('end_date', '>', $today)
            ->first();

        $data = array(
            'my_assignments' => $my_assignments,
            'user' => $user,
            'current_assignments' => $current_assignments,
        );

        return view('assignments.individualHistory', $data);

    }

    public function create_assignment()
    {
        $countries = Country::all();
        $counties = County::all();

        $data = array(
            'countries' => $countries,
            'counties' => $counties
        );

        return view('assignments.create_assignment', $data);
    }

    public function save_assignment_admin(Request $request)
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
//            $assignmentMessage .= '<p>Best regards,<br>Your Name</p>';


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

    public function dashboardIct()
    {
        return view('dashboard.dashboard_ict');
    }

    public function dashboardHr()
    {
        // lets define here data going to dashboard
        $employee_no = User::all() -> count('id');
        $recent_staff = $recent_staff = User::select(
            'id',
            'date_of_appointment',
            'pfNumber'
        )
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $data = [
            'employee_no' => $employee_no,
            'recent_staffs' => $recent_staff,
        ];
        return view('dashboard.dashboard_hr',$data);
    }


}
