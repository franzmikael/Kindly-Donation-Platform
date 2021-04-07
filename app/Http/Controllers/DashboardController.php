<?php

namespace App\Http\Controllers;

use App\Submission;
use App\Donation;
use App\Withdraw;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $campaigns = Submission::with('user')->get();

        $total_campaigns = null;

        foreach($campaigns as $key => $value) {
            $total_campaigns += $campaigns[$key]['submisi_terkumpul'];

            $campaigns[$key]['submisi_target'] = $this->currency($campaigns[$key]['submisi_target']);
            $campaigns[$key]['submisi_terkumpul'] = $this->currency($campaigns[$key]['submisi_terkumpul']);

            $campaign_expire = new \DateTime($campaigns[$key]['submisi_expired_at']);
            $today = new \DateTime();
            $campaigns[$key]['sisa_hari'] = $today->diff($campaign_expire)->days.' hari';
            
            if($campaigns[$key]['submisi_is_active'] == 1)
                $campaigns[$key]['submisi_is_active'] = 'aktif';
            else
                $campaigns[$key]['submisi_is_active'] = 'ditutup';

            $campaigns[$key]['submisi_created_at'] = $campaigns[$key]['created_at']->format('d-m-Y H:i:s');
            $campaigns[$key]['submisi_updated_at'] = $campaigns[$key]['updated_at']->format('d-m-Y H:i:s');
        }

        $total_campaigns = $this->currency($total_campaigns);

        $donations = Donation::with('submission')->get();
        foreach($donations as $key => $value)
        {
            $donations[$key]['donation_nominal'] = $this->currency($donations[$key]['donation_nominal']);

            if($donations[$key]['donation_is_anonymous'] == 1)
                $donations[$key]['donation_is_anonymous'] = 'ya';
            else
                $donations[$key]['donation_is_anonymous'] = 'tidak';

            if($donations[$key]['user_id'] == 0)
                $donations[$key]['user_id'] = 'tidak terdaftar';
            else
                $donations[$key]['user_id'] = 'terdaftar';

            $donations[$key]['donation_created_at'] = $donations[$key]['created_at']->format('d-m-Y H:i:s');
            $donations[$key]['donation_updated_at'] = $donations[$key]['updated_at']->format('d-m-Y H:i:s');
                
        }

        $withdraws = Withdraw::with('submission')->with('user')->orderBy('withdraw_is_approved', 'asc')->get();

        $total_unapproved_withdraws = 0;

        foreach($withdraws as $key => $value)
        {
            $withdraws[$key]['withdraw_nominal'] = $this->currency($withdraws[$key]['withdraw_nominal']);

            if($withdraws[$key]['withdraw_is_approved'] == 1)
                $withdraws[$key]['withdraw_is_approved'] = 'disetujui';
            else if($withdraws[$key]['withdraw_is_approved'] == 2)
                $withdraws[$key]['withdraw_is_approved'] = 'ditolak';
            else {
                $total_unapproved_withdraws += 1;
                $withdraws[$key]['withdraw_is_approved'] = 'menunggu persetujuan';
            }

            $withdraws[$key]['withdraw_created_at'] = $withdraws[$key]['created_at']->format('d-m-Y H:i:s');
            $withdraws[$key]['withdraw_updated_at'] = $withdraws[$key]['updated_at']->format('d-m-Y H:i:s');
                
        }

        $users = User::orderBy('user_is_admin', 'desc')->get();
        foreach($users as $key => $value)
        {
            if($users[$key]['user_is_admin'] == 1)
                $users[$key]['user_is_admin'] = 'admin';
            else
                $users[$key]['user_is_admin'] = 'user';

            if($users[$key]['user_is_active'] == 1)
                $users[$key]['user_is_active'] = 'aktif';
            else
                $users[$key]['user_is_active'] = 'tidak aktif';

            $users[$key]['user_created_at'] = $users[$key]['created_at']->format('d-m-Y H:i:s');
            $users[$key]['user_updated_at'] = $users[$key]['updated_at']->format('d-m-Y H:i:s');
                
        }

        return response(['campaigns' => $campaigns, 'totalCampaigns' => $total_campaigns, 'donations' => $donations, 'withdraws' => $withdraws, 'needApprove' => $total_unapproved_withdraws, 'users' => $users]);
    }

    public function close_submission(Request $request)
    {
        $submission_id = $request->id;
        $submission = Submission::findOrFail($submission_id);
        $submission->update(['submisi_is_active' => 0]);

        return response(['response' => 'success', 'message' => 'Penutupan galang dana berhasil!']);
    }

    public function destroy_submission(Request $request)
    {
        $submission_id = $request->id;

        $donations = Donation::where('submisi_id', $submission_id)->delete();

        $withdraw = Withdraw::where('submisi_id', $submission_id)->delete();

        $submission = Submission::findOrFail($submission_id)->delete();


        return response(['response' => 'success', 'message' => 'Penghapusan galang dana berhasil!']);
    }

    public function destroy_user(Request $request)
    {
        $user_id = $request->id;

        $donations = Donation::where('user_id', $user_id)->delete();

        $withdraw = Withdraw::where('user_id', $user_id)->delete();

        $submissions = Submission::where('user_id', $user_id)->delete();
        
        $user = User::findOrFail($user_id)->delete();

        return response(['response' => 'success', 'message' => 'Penghapusan pengguna berhasil!']);
    }

    public function accept_withdraw (Request $request)
    {
        $withdraw_id = $request->id;
        $withdraw = Withdraw::findOrFail($withdraw_id);
        $withdraw->update(['withdraw_is_approved' => 1]);

        return response(['response' => 'success', 'message' => 'Pencairan dana telah disetujui!']);
    }

    public function decline_withdraw (Request $request)
    {
        $withdraw_id = $request->id;
        $withdraw = Withdraw::findOrFail($withdraw_id);
        $withdraw->update(['withdraw_is_approved' => 2]);

        return response(['response' => 'success', 'message' => 'Pencairan dana telah ditolak!']);
    }
}
