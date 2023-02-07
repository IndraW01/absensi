<?php

namespace App\Http\Controllers\Absen;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Traits\DatatableTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AbsenController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        $tanggalHariIni = Carbon::now()->format('Y-m-d');

        return view('absen.index', [
            'userDetail' => Auth::user()->userDetail,
            'userAbsen' => Absen::query()->absen($tanggalHariIni)->first(),
        ]);
    }

    public function absen(Request $request)
    {
        // Validate Inputan
        $validateAbsen = $request->validate([
            'latitude' => ['required'],
            'longitude' => ['required'],
            'foto' => ['required']
        ]);

        // Data lokasi Kantor
        $latitudeKantor = Auth::user()->userDetail->lokasi->latitude_kantor;
        $longitudeKantor = Auth::user()->userDetail->lokasi->longitude_kantor;
        $radiusKantor = Auth::user()->userDetail->lokasi->radius;

        // Data User dan Lokasi User
        $user = Auth::user();
        $latitudeUser = $validateAbsen['latitude'];
        $longitudeUser = $validateAbsen['longitude'];
        $userShiftMasuk = $user->userDetail->shift->jam_masuk->format('H:i:s');
        $userShiftKeluar = $user->userDetail->shift->jam_keluar->format('H:i:s');

        // Data Absen
        $tanggalHariIni = Carbon::now()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i:s');

        // Menghitung jarak radius
        $jarak = $this->distance($latitudeUser, $longitudeUser, $latitudeKantor, $longitudeKantor);

        // Cek jika radius absen melebihi
        if ($jarak > $radiusKantor) {
            Alert::error('Gagal', 'Gagal absen, anda berada diluar jangkauan radius');
            return redirect()->route('absen.index');
        } else {
            // ubah foto base64
            $fotoParts = explode(";base64,", $validateAbsen['foto']);
            $fotoBase64 = base64_decode($fotoParts[1]);

            if (!Absen::query()->absen($tanggalHariIni)->whereStatus('masuk')->exists()) {
                // Data jam telat masuk
                $selisihJam = Carbon::parse($jamSekarang)->diff($userShiftMasuk)->format('%H:%I:%S');
                $selihJamAbsen = Carbon::now()->greaterThan($userShiftMasuk) ? $selisihJam : 0;

                // ubah foto base64
                $fotoName = 'absen/masuk/absen_masuk-' . time() . '.png';

                // Data Absen Masuk
                $dataAbsenMasuk = [
                    'user_id' => $user->id,
                    'tanggal' => $tanggalHariIni,
                    'jam_masuk' => $jamSekarang,
                    'telat_masuk' => $selihJamAbsen,
                    'latitude_absen_masuk' => $validateAbsen['latitude'],
                    'longitude_absen_masuk' => $validateAbsen['longitude'],
                    'jarak_masuk' => (int) round($jarak),
                    'foto_absen_masuk' => $fotoName,
                    'status' => 'masuk'
                ];

                $alertAbsen = 'Berhasil Absen Masuk';
            } else {
                // Data jam telat masuk
                $selisihJam = Carbon::parse($jamSekarang)->diff($userShiftKeluar)->format('%H:%I:%S');
                $selihJamAbsen = Carbon::now()->lessThan($userShiftKeluar) ? $selisihJam : 0;

                // ubah foto base64
                $fotoName = 'absen/keluar/absen_pulang-' . time() . '.png';

                // Data Absen Pulang
                $dataAbsenPulang = [
                    'jam_pulang' => $jamSekarang,
                    'pulang_cepat' => $selihJamAbsen,
                    'latitude_absen_pulang' => $validateAbsen['latitude'],
                    'longitude_absen_pulang' => $validateAbsen['longitude'],
                    'jarak_pulang' => (int) round($jarak),
                    'foto_absen_pulang' => $fotoName,
                    'status' => 'keluar',
                ];

                $alertAbsen = 'Berhasil Absen Pulang';
            }

            try {
                DB::beginTransaction();

                Storage::disk('public')->put($fotoName, $fotoBase64);

                if (!Absen::query()->absen($tanggalHariIni)->whereStatus('masuk')->exists()) {
                    $absenMasukCreate = Absen::query()->create($dataAbsenMasuk);
                } else {
                    $absenPulangCreate = Absen::query()->absen($tanggalHariIni)->update($dataAbsenPulang);
                }

                DB::commit();

                Alert::success('berhasil', $alertAbsen);
                return redirect()->route('absen.index');
            } catch (Exception $e) {
                DB::rollBack();

                Alert::error('Error', 'Gagal Absen ' . $e->getMessage());
                return redirect()->route('absen.index');
            }
        }
    }

    public function distance($latitudeUser, $longitudeUser, $latitudeKantor, $longitudeKantor)
    {
        $theta = $longitudeUser - $longitudeKantor;
        $dist = sin(deg2rad($latitudeUser)) * sin(deg2rad($latitudeKantor)) +  cos(deg2rad($latitudeUser)) * cos(deg2rad($latitudeKantor)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $miles = $miles * 1.609344;
        return $miles * 1000;
    }

    public function myAbsen()
    {
        return view('absen.my-absen');
    }

    public function datatableMyAbsens(Request $request)
    {
        if ($request->ajax()) {
            if ($request->query('tanggal_awal') && $request->query('tanggal_akhir')) {
                return $this->getMyAbsens($request->query('tanggal_awal'), $request->query('tanggal_akhir'));
            } else {
                return $this->getMyAbsens();
            }
        }
    }

    public function filterAbsen(Request $request)
    {
        $request->validate([
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after_or_equal:tanggal_awal'],
        ]);

        return response()->json($request->all());
    }

    public function show($absenId)
    {
        $userAbsen = Absen::query()->whereId($absenId)->whereUserId(Auth::id())->firstOrFail();

        return view('absen.show', [
            'userAbsen' => $userAbsen,
        ]);
    }
}
