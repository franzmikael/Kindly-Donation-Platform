<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Submission;
use App\Donation;
use App\Withdraw;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    //update profile
    public function update_profile(Request $request)
    {

        $rules = [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phoneNumber' => 'required|numeric|min:10',
            'image' => '',
        ];

        $messages =[
            'firstName.required' => 'Kolom nama depan harus diisi.',
            'lastName.required' => 'Kolom nama belakang harus diisi',
            'phoneNumber.required' => 'Kolom nomor telepon harus diisi',
            'phoneNumber.numeric' => 'Nomor telepon harus diisi dengan angka',
            'phoneNumber.min' => 'Minimal nomor telepon adalah 10',
        ];
        
        $this->validate($request, $rules, $messages);

        $userupdate = User::find($request->id);
        $userupdate->user_name = ucfirst($request->firstName).' '.ucfirst($request->lastName);
        $userupdate->user_phone = $request->phoneNumber;
        
        $file = $request -> file('image');

        if ($file == null) {
            $userupdate -> save();
        }else {
            $ext = $request->file('image')->getClientOriginalExtension();
            $current_timestamp = now()->timestamp;
            $imageFile = $current_timestamp.'.'.$ext;
            $userupdate->user_foto = $imageFile;
            $request->file('image')->storeAs('public/profile', $current_timestamp.'.'.$ext);
            $userupdate -> save();
        }
        return response(['response' => 'success', 'message' => "Perubahan Profile berhasil!"]);
    }

    // Update Password
    public function update_password(Request $request)
    {
        $rules = [
            'oldPassword' => 'required|min:4'
        ];

        $messages = [
            'oldPassword.required' => 'Kolom ini harus diisi terlebih dahulu.',
            'oldPassword.min' => 'Minimal karakter untuk kolom ini adalah 4.',
        ];

        $this->validate($request, $rules, $messages);

        $password =  $request->oldPassword; 
        $email = $request->email;
        if(!Auth::guard('web')->attempt(['user_mail' => $email,'password' => $password])) {
            throw ValidationException::withMessages(['oldPassword' => 'Password saat ini salah.']);
        }

        $rules = [
            'oldPassword' => 'required|min:4',
            'newPassword' => 'required|min:4|required_with:confirmPassword|same:confirmPassword',
            'confirmPassword' => 'min:4',
        ];

        $messages = [
            'oldPassword.required' => 'Kolom password lama harus diisi terlebih dahulu.',
            'oldPassword.min' => 'Minimal karakter untuk kolom password lama adalah 4.',
            'newPassword.required' => 'Kolom psasword baru harus diisi terlebih dahulu.',
            'newPassword.min' => 'Minimal karakter untuk kolom password baru adalah 4.',
            'newPassword.required_with' => 'Kolom konfirmasi password harus diisi.',
            'newPassword.same' => 'Password tidak sama dengan konfirmasi password.',
            'confirmPassword.min' => 'Minimal karakter untuk kolom konfirmasi password adalah 4.',
        ];

        $this->validate($request, $rules, $messages);
        $userupdate = User::find($request->id);
        $userupdate->update(['user_password' => bcrypt($request->newPassword)]);

        return response(['response' => 'success', 'message' => 'Ubah password berhasil!']);
    }
    //Get Information Submision and Donation History
    public function get_history_submision_donation($id)
    {
        $sql_submission_active = array(
            DB::raw('t_submissions.submisi_id'),
            DB::raw('t_submissions.submisi_foto'),
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('t_submissions.submisi_target'),
            DB::raw('t_submissions.submisi_terkumpul'),
            DB::raw('m_user.user_name'),
            DB::raw('(DATEDIFF(submisi_expired_at, now())) as sisa_hari'),
        );
        $submission_active = DB::table('t_submissions')
            ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
            ->select($sql_submission_active)
            ->where([
                ['t_submissions.user_id',$id],
                ['t_submissions.submisi_is_active',1]
            ])
            ->get();
            
        foreach($submission_active as $key => $value)
        {
            $submission_active[$key]->submisi_target = $this->currency($submission_active[$key]->submisi_target);
            $submission_active[$key]->submisi_terkumpul = $this->currency($submission_active[$key]->submisi_terkumpul);
        }

        $sql_submission_history = array(
            DB::raw('t_submissions.submisi_id'),
            DB::raw('t_submissions.submisi_foto'),
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('t_submissions.submisi_is_active'),
            DB::raw('m_user.user_name'),
            DB::raw('(DATEDIFF(submisi_expired_at, now())) as sisa_hari'),
        );
        $submission_history = DB::table('t_submissions')
            ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
            ->select($sql_submission_history)
            ->where([
                ['t_submissions.user_id',$id]
            ])
            ->paginate(6);

        foreach($submission_history as $key => $value)
        {
            $status = $submission_history[$key]->submisi_is_active;
            if($status == 1)
                $submission_history[$key]->submisi_is_active = 'masih aktif';
            else
                $submission_history[$key]->submisi_is_active = 'ditutup';
        }

        $sql_donations = array(
            DB::raw('t_submissions.submisi_id'),
            DB::raw('t_submissions.submisi_foto'),
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('m_user.user_name'),
            DB::raw('t_donations.donation_nominal'),
        );
        $donations = DB::table('t_donations')
            ->join('t_submissions', 't_donations.submisi_id', '=', 't_submissions.submisi_id')
            ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
            ->select($sql_donations)
            ->where('t_donations.user_id',$id)
            ->paginate(6);
        
        foreach($donations as $key => $value)
        {
            $donations[$key]->donation_nominal = $this->currency($donations[$key]->donation_nominal);
        }


        $sql_total_donations = array(
            DB::raw('SUM(t_donations.donation_nominal) as total_donation'),
            DB::raw('COUNT(distinct t_donations.submisi_id) as total_participant'),
        );
        $total_donations = DB::table('t_donations')
            ->join('t_submissions', 't_donations.submisi_id', '=', 't_submissions.submisi_id')
            ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
            ->select($sql_total_donations)
            ->where('t_donations.user_id',$id)
            ->get()->first();
        
        if($total_donations->total_donation == null)
            $total_donations->total_donation = 0;
        $total_donations->total_donation = $this->currency($total_donations->total_donation);

        return response([
            'submissionhistory' => $submission_history, 
            'submissionactive' => $submission_active, 
            'donations' => $donations,
            "participations" => $total_donations
        ]);
    }

    //close the active submission
    public function Close_Submission($id)
    {
        $closeSubmission = Submission::find($id);
        $closeSubmission->submisi_is_active = '0';
        $closeSubmission -> save();
        return response(['response' => 'success', 'message' => "Penutupan galang dana berhasil!"]);
    }

    public function submit_withdraw(Request $request)
    {
        $rules = [
            'id' => 'required',
            'campaign' => 'required'
        ];

        $messages = [
            'campaign.required' => 'Kolom penggalangan perlu dipilih terlebih dahulu.',
        ];
        $this->validate($request, $rules, $messages);

        $nominal_total = Donation::where('submisi_id', $request->campaign)->sum('donation_nominal');
        $nominal_withdrawed =  Withdraw::where('submisi_id', $request->campaign)->where('withdraw_is_approved', '!=', 2)->sum('withdraw_nominal');
        $max = $nominal_total*0.95;
        $difference = $max - $nominal_withdrawed;

        $rules = [
            'nominal' => 'required|integer|min:100000|max:'.$difference,
            'bank' => 'required|digits:10',
        ];

        $messages = [
            'nominal.required' => 'Kolom nominal perlu diisi.',
            'nominal.integer' => 'Kolom nominal harus diisi dengan angka.',
            'nominal.min' => 'Minimal nominal pencairan adalah Rp 100,000.',
            'nominal.max' => 'Maksimal Nominal pencairan adalah '.$this->currency($difference).'.',
            'bank.required' => 'Kolom nomor rekening perlu diisi.',
            'bank.digits' => 'Nomor Rekening harus memiliki 10 digit.'
        ];
        $this->validate($request, $rules, $messages);

        $withdraw = new Withdraw;
        $withdraw->submisi_id = $request->campaign;
        $withdraw->user_id = $request->id;
        $withdraw->withdraw_nominal = $request->nominal;
        $withdraw->withdraw_bank_number = $request->bank;
        $withdraw->withdraw_is_approved = 0;

        $withdraw->save();

        return response(['response' => 'success', 'message' => "Pengajuan pencairan dana berhasil! Ajuan pencairan akan diverifikasi oleh admin maksimal 2 hari."]);
    }
}
