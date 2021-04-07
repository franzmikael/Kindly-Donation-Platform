<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function Donations (Request $request){

        $rules = [
            'submisi' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'phoneNumber' => 'required|numeric|digits:12',
            'amount' => 'required|numeric|min:10000',
        ];

        $messages = [
            'submisi.required' => 'Submisi dibutuhkan.',
            'name.required' => 'Kolom nama harus diisi.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Kolom email harus diisi dengan email yang valid.',
            'phoneNumber.required' => 'Kolom nomor telepon harus diisi.',
            'phoneNumber.numeric' => 'Kolom nomor telepon harus diisi dengan angka.',
            'phoneNumber.digits' => 'Kolom nomor telepon harus 12 digit.',
            'amount.required' => 'Kolom jumlah donasi harus diisi.',
            'amount.numeric' => 'Kolom jumlah donasi harus diisi.',
            'amount.min' => 'Jumlah minimal donasi adalah Rp 10,000.',
        ];

        $this->validate($request, $rules, $messages);

        DB::beginTransaction();

        $data = DB::table('t_donations')->insert([
            'submisi_id' => $request->submisi,
            'user_id' => $request->user_id,
            'donation_name' => $request->name,
            'donation_mail' => $request->email,
            'donation_phone' => $request->phoneNumber,
            'donation_nominal' => $request->amount,
            'donation_is_anonymous' => $request->anonymous,
            'payment_type' => "BCA",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if($data)
        {
            $data_submisi = DB::table('t_submissions')->where('submisi_id',$request->submisi)->get();
            $data_baru = $data_submisi[0]->submisi_terkumpul + $request->amount;
            $update = DB::table('t_submissions')->where('submisi_id',$request->submisi)->update([
                'submisi_terkumpul' => $data_baru
            ]);
            if($update){
                if($data && $update){
                    DB::commit();
                    return 'OK';
                }else{
                    DB::rollBack();
                }
            }
        }
    }

    public function information_donation()
    {
        $sql = array(
            DB::raw('t_donations.donation_id'),
            DB::raw('t_donations.donation_mail'),
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('t_submissions.submisi_penerima'),
            DB::raw('t_donations.donation_nominal'),
            DB::raw('t_donations.payment_type'),
            DB::raw('m_user.user_name'),
            DB::raw('m_user.user_foto'),
        );
        $data = DB::table('t_donations')
                ->join('t_submissions', 't_submissions.submisi_id', '=', 't_donations.submisi_id')
                ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
                ->select($sql)
                ->orderByDesc('donation_id')
                ->limit(1)
                ->get();

        $data[0]->donation_nominal = $this->currency($data[0]->donation_nominal);
        
        return $data;
    }
}
