<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\DetailLayanan;
use App\Models\RiwayatLayanan;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        if ($role == 'admin') {
            return $this->admin();
        } elseif ($role == 'client') {
            return $this->client();
        }
    }

    public function admin()
    {
        $data = [
            'users' => User::get()->count(),
            'logs' => Activity::get()->count()
        ];

        return view('dashboard.admin', $data);
    }

    public function client()
    {
        return view('dashboard.client');
    }
    public function track(Request $request)
    {
        $tracking = '';
        if ($request->has(['nip', 'tgl_lahir'])) {
            $tracking = DetailLayanan::with('jenisLayanan')
                ->with('pemohon', function ($query) use ($request) {
                    $query->where('nip', $request->nip)->where('tgl_lahir', $request->tgl_lahir);
                })
                ->get();
        }

        return view('track', compact('tracking'));
    }
    public function trackDetail($uuid)
    {
        $data = DetailLayanan::with('jenisLayanan')->with('pemohon')->whereUuid($uuid)->firstOrFail();
        $id = $data->id;
        $tracking = RiwayatLayanan::where('detail_layanan_id', $id)
            ->with('status')
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('track-detail', compact('tracking', 'data'));
    }
}
