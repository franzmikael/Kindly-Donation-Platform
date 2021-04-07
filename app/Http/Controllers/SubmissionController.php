<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Submission;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    // mengambil semua data
    public function all()
    {
        $sql = array(
            DB::raw('t_submissions.submisi_terkumpul as total_donasi'),
            DB::raw('t_submissions.submisi_target as target_donasi'),
            DB::raw('submisi_terkumpul/submisi_target*100 as kekurangan_donasi'),
            DB::raw('(DATEDIFF(submisi_expired_at, now())) as day_left'),
            DB::raw('t_submissions.submisi_id'),
            DB::raw('t_submissions.submisi_foto'),
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('m_user.user_name'),
        );
        $data = DB::table('t_submissions')
            ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
            ->select($sql)
            ->distinct()
            ->whereRaw('DATEDIFF(submisi_expired_at, now()) > 0')
            ->paginate(6);
        
        foreach($data as $key => $value)
        {
            $data[$key]->total_donasi = $this->currency($data[$key]->total_donasi);
            $data[$key]->target_donasi = $this->currency($data[$key]->target_donasi);
        }

        return $data;
    }

    public function show_campaign_detail($id)
    {        
        $sql_submission = array(
            DB::raw('t_submissions.submisi_id'),
            DB::raw('t_submissions.submisi_foto'),
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('t_submissions.submisi_cerita'),
            DB::raw('t_submissions.submisi_penerima'),
            DB::raw('m_user.user_id'),
            DB::raw('m_user.user_name'),
            DB::raw('m_user.user_foto'),
            DB::raw('t_submissions.submisi_terkumpul'),
            DB::raw('t_submissions.submisi_target'),
            DB::raw('t_submissions.submisi_is_active'),
            DB::raw('submisi_terkumpul/submisi_target*100 as kekurangan_donasi'),
            DB::raw('(DATEDIFF(submisi_expired_at, now())) as sisa_hari'),
        );
        $submission = DB::table('t_submissions')
            ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
            ->select($sql_submission)
            ->where('t_submissions.submisi_id',$id)
            ->get()->first();

        $submission->submisi_terkumpul = $this->currency($submission->submisi_terkumpul);
        $submission->submisi_target = $this->currency($submission->submisi_target);

        $sql_donations = array(
            DB::raw('donation_id'),
            DB::raw('donation_name'),
            DB::raw('donation_nominal'),
            DB::raw('donation_is_anonymous'),
        );
        $donations = DB::table('t_donations')
            ->select($sql_donations)
            ->where('t_donations.submisi_id',$id)
            ->orderByDesc('donation_id')
            ->get();

        foreach($donations as $key => $value)
        {
            $donations[$key]->donation_nominal = $this->currency($donations[$key]->donation_nominal);
        }

        return response(['submission' => $submission, 'donations' => $donations]);
    }

    public function store(Request $request)
    {
        if($request->step == 1) {
            
            $rules = [
                'type' => 'required|string',
                'title' => 'required|string|max:50',
                'target' => 'required|numeric|min:1000000',
                'recipient' => 'required|string',
                'story' => 'required|string|max:255',
                'date' => 'required|date|after:now',
            ];

            $messages = [
                'type.required' => 'Kolom kategori harus diisi.',
                'title.required'=> 'Kolom judul harus diisi.',
                'title.max'=> 'Kolom judul maksimal 50 karakter.',
                'target.required'=> 'Kolom target harus diisi.',
                'target.numeric'=> 'Kolom target harus diisi dengan angka.',
                'target.min'=> 'Minimal target donasi adalah Rp 1.000.000.',
                'recipient.required'=> 'Kolom penerima harus diisi.',
                'story.required'=> 'Kolom cerita harus diisi.',
                'story.max'=> 'Kolom cerita maksimal 255 karakter.',
                'date.required'=> 'Kolom tanggal harus diisi.',
                'date.after'=> 'Batas waktu harus minimal sehari setelah hari ini.',
            ];

            $this->validate($request, $rules, $messages);
            return response(['response' => 'step-2']);
        }
        
        if($request->step == 2) {
            $rules = [
                'image' => 'required|mimes:jpg,jpeg,png',
            ];

            $messages = [
                'image.required' => 'File gambar harus ada.',
                'image.mimes' => 'File gambar harus berupa .jpg, .jpeg, atau .png.',
            ];

            $this->validate($request, $rules, $messages);
            return response(['response' => 'step-3']);
        }

        if($request->step == 3) {
            $rules = [
                'confirm' => 'required:true',
            ];

            $messages =[
                'confirm.required' => 'Anda harus menyetujui Syarat & Ketentuan yang berlaku'
            ];

            $ext = $request->file('image')->getClientOriginalExtension();
            $current_timestamp = now()->timestamp;
            $imageFile = $current_timestamp.'.'.$ext;
    
            $t_submissions = new Submission();
            $t_submissions->user_id = $request->author;
            $t_submissions->submisi_phone = $request->phone;
            $t_submissions->submisi_tipe = $request->type;
            $t_submissions->submisi_judul = ucfirst($request->title);
            $t_submissions->submisi_target = ucfirst($request->target);
            $t_submissions->submisi_terkumpul = 0;
            $t_submissions->submisi_penerima = ucfirst($request->recipient);
            $t_submissions->submisi_cerita = ucfirst($request->story);
            $t_submissions->submisi_expired_at = $request->date;
            $t_submissions->submisi_foto = $imageFile;
            $t_submissions->submisi_is_active = 1;
    
            $t_submissions -> save();

            $request->file('image')->storeAs('public/submission', $current_timestamp.'.'.$ext);
    
            return response(['response' => 'success', 'message' => 'Pembuatan galang dana berhasil!']);
        }
    }
}
