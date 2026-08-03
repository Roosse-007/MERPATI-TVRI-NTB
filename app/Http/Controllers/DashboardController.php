<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $jabatan = $user->jabatan->nama_jabatan ?? '';

        /*
        |--------------------------------------------------------------------------
        | Statistik Global
        |--------------------------------------------------------------------------
        */

        $global = $this->getStatistikGlobal();

        /*
        |--------------------------------------------------------------------------
        | Grafik Dashboard
        |--------------------------------------------------------------------------
        */

        $grafik = $this->getGrafik();

        /*
        |--------------------------------------------------------------------------
        | Aktivitas User
        |--------------------------------------------------------------------------
        */

        $aktivitas = $this->getAktivitas($user);

        /*
        |--------------------------------------------------------------------------
        | Card Dashboard
        |--------------------------------------------------------------------------
        */

        $cards = $this->getDashboardCards(
            $user,
            $jabatan
        );

        /*
        |--------------------------------------------------------------------------
        | Surat Terbaru
        |--------------------------------------------------------------------------
        */

        $suratTerbaru = Surat::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Data View
        |--------------------------------------------------------------------------
        */

        $data = [

            ...$global,

            ...$grafik,

            ...$cards,

            'aktivitas' => $aktivitas,

            'suratTerbaru' => $suratTerbaru,

        ];

        /*
        |--------------------------------------------------------------------------
        | AJAX Pagination Aktivitas
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return view(
                'dashboard.aktivitas',
                compact('aktivitas')
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Berdasarkan Role
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            return view(
                'admin.dashboard',
                $data
            );

        }

        return view(
            'dashboard.index',
            $data
        );
    }

    /**
|--------------------------------------------------------------------------
| Statistik Global
|--------------------------------------------------------------------------
*/

private function getStatistikGlobal(): array
{
    return [

        'totalSurat' => Surat::count(),

        'totalUser' => User::count(),

        'pendingApproval' => Approval::where(
            'status',
            'Menunggu'
        )->count(),

        'totalArsip' => Surat::where(
            'is_archived',
            true
        )->count(),

    ];
}

/**
|--------------------------------------------------------------------------
| Grafik Dashboard
|--------------------------------------------------------------------------
*/

private function getGrafik(): array
{
    /*
    |--------------------------------------------------------------------------
    | Grafik Surat Bulanan
    |--------------------------------------------------------------------------
    */

    $statistikSurat = Surat::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get()
        ->map(function ($item) {

            return [

                'bulan' => date(
                    'M',
                    mktime(
                        0,
                        0,
                        0,
                        $item->bulan,
                        1
                    )
                ),

                'jumlah' => $item->jumlah,

            ];

        });

    /*
    |--------------------------------------------------------------------------
    | Status Surat
    |--------------------------------------------------------------------------
    */

    $statusSurat = Surat::select(
            'status',
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy('status')
        ->get();

    return [

        'statistikSurat' => $statistikSurat,

        'statusSurat' => $statusSurat,

    ];
}

/**
|--------------------------------------------------------------------------
| Aktivitas Dashboard
|--------------------------------------------------------------------------
*/

private function getAktivitas(User $user): LengthAwarePaginator
{
    $aktivitas = collect();

    /*
    |--------------------------------------------------------------------------
    | Surat Dibuat
    |--------------------------------------------------------------------------
    */

    $suratSaya = Surat::where(
        'pengirim_id',
        $user->id
    )
    ->latest()
    ->take(5)
    ->get();

    foreach ($suratSaya as $surat) {

        $aktivitas->push([

            'judul'      => 'Surat Dibuat',

            'deskripsi'  => $surat->perihal,

            'status'     => $surat->status,

            'waktu'      => $surat->created_at,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Surat Masuk
    |--------------------------------------------------------------------------
    */

    $suratMasuk = Surat::where(function ($query) use ($user) {

        $query->whereHas('tujuan', function ($q) use ($user) {

            $q->where(
                'user_id',
                $user->id
            );

        })

        ->orWhereHas('approval', function ($q) use ($user) {

            $q->where(
                'approver_id',
                $user->id
            )
            ->where(
                'status',
                'Menunggu'
            );

        });

    })
    ->latest()
    ->take(5)
    ->get();

    foreach ($suratMasuk as $surat) {

        $aktivitas->push([

            'judul'      => 'Surat Masuk',

            'deskripsi'  => $surat->perihal,

            'status'     => $surat->status,

            'waktu'      => $surat->created_at,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Disposisi
    |--------------------------------------------------------------------------
    */

    $disposisi = Disposisi::with('surat')

        ->where(
            'ke_user_id',
            $user->id
        )

        ->latest()

        ->take(5)

        ->get();

    foreach ($disposisi as $item) {

        $aktivitas->push([

            'judul'      => 'Disposisi Surat',

            'deskripsi'  => $item->surat->perihal ?? '-',

            'status'     => $item->status,

            'waktu'      => $item->created_at,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Approval
    |--------------------------------------------------------------------------
    */

    $approval = Approval::with('surat')

        ->where(
            'approver_id',
            $user->id
        )

        ->whereIn('status', [

            'Disetujui',

            'Ditolak',

        ])

        ->latest()

        ->take(5)

        ->get();

    foreach ($approval as $item) {

        $aktivitas->push([

            'judul'      => 'Approval Surat',

            'deskripsi'  => $item->surat->perihal ?? '-',

            'status'     => $item->status,

            'waktu'      => $item->created_at,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Urutkan
    |--------------------------------------------------------------------------
    */

    $aktivitas = $aktivitas

        ->sortByDesc('waktu')

        ->unique(function ($item) {

            return

                $item['judul']

                . '-'

                . $item['deskripsi'];

        })

        ->values();

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $page = request()->get(

        'page',

        1

    );

    $perPage = 8;

    return new LengthAwarePaginator(

        $aktivitas
            ->forPage(
                $page,
                $perPage
            )
            ->values(),

        $aktivitas->count(),

        $perPage,

        $page,

        [

            'path'  => request()->url(),

            'query' => request()->query(),

        ]

    );
}
/**
|--------------------------------------------------------------------------
| Card Dashboard Berdasarkan Role
|--------------------------------------------------------------------------
*/

private function getDashboardCards(
    User $user,
    string $jabatan
): array
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    if ($user->hasRole('Admin')) {

        return [

            'suratMasuk' => Surat::where(
                'status',
                '!=',
                'Draft'
            )->count(),

            'draft' => Surat::where(
                'status',
                'Draft'
            )->count(),

            'approval' => Approval::where(
                'status',
                'Menunggu'
            )->count(),

            'diterima' => Surat::where(
                'status',
                'Disetujui'
            )->count(),

            'arsip' => Surat::where(
                'is_archived',
                true
            )->count(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | PEJABAT APPROVAL
    |--------------------------------------------------------------------------
    */

    if (in_array($jabatan, [

        'Ketua Tim Perencana dan Pengendali Program',

        'Kepala Sub Bagian Tata Usaha',

        'Kepala TVRI Stasiun NTB',

    ])) {

        return [

            'suratMasuk' => Surat::whereHas(
                'tujuan',
                function ($q) use ($user) {

                    $q->where(
                        'user_id',
                        $user->id
                    );

                }
            )
            ->where(
                'status',
                '!=',
                'Draft'
            )
            ->count(),

            'draft' => Surat::where(
                'pengirim_id',
                $user->id
            )
            ->where(
                'status',
                'Draft'
            )
            ->count(),

            'approval' => Approval::where(
                'approver_id',
                $user->id
            )
            ->where(
                'status',
                'Menunggu'
            )
            ->count(),

            'diterima' => Surat::whereHas(
                'tujuan',
                function ($q) use ($user) {

                    $q->where(
                        'user_id',
                        $user->id
                    );

                }
            )
            ->where(
                'status',
                'Disetujui'
            )
            ->count(),

            'arsip' => Surat::whereHas(
                'tujuan',
                function ($q) use ($user) {

                    $q->where(
                        'user_id',
                        $user->id
                    );

                }
            )
            ->where(
                'is_archived',
                true
            )
            ->count(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | USER BIASA
    |--------------------------------------------------------------------------
    */

    return [

        'suratMasuk' => Surat::whereHas(
            'tujuan',
            function ($q) use ($user) {

                $q->where(
                    'user_id',
                    $user->id
                );

            }
        )
        ->where(
            'status',
            '!=',
            'Draft'
        )
        ->count(),

        'draft' => Surat::where(
            'pengirim_id',
            $user->id
        )
        ->where(
            'status',
            'Draft'
        )
        ->count(),

        'approval' => Approval::where(
            'approver_id',
            $user->id
        )
        ->where(
            'status',
            'Menunggu'
        )
        ->count(),

        'diterima' => Surat::where(
            'pengirim_id',
            $user->id
        )
        ->where(
            'status',
            'Disetujui'
        )
        ->count(),

        'arsip' => Surat::where(
            'pengirim_id',
            $user->id
        )
        ->where(
            'is_archived',
            true
        )
        ->count(),

    ];
}
}