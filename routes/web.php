<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Filament\User\Pages\WelcomePage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/regulamento', function () {
    return view('regulamento');
})->name('regulamento');

Route::get('/ativar-conta', WelcomePage::class)->name('ativar-conta');

Route::get('/pdf/comprovante/{user}', function (App\Models\User $user) {
    $user->load('paroquia');

    $teams = [];

    if ($user->isParent()) {
        $parentAtletas = $user->atleta()->where('pagamento', true)->get();
        if ($parentAtletas->isNotEmpty()) {
            $teamName = $user->team_name ?? $user->name;
            $teams[$teamName] = [
                'team_name' => $teamName,
                'atletas' => $parentAtletas,
                'modalidades' => [],
            ];
            foreach ($parentAtletas as $atleta) {
                foreach ($atleta->modalidade ?? [] as $mod) {
                    $teams[$teamName]['modalidades'][$mod][] = $atleta;
                }
            }
        }

        $children = $user->children()->where('role', 'sub_user')->get();
        foreach ($children as $child) {
            $childAtletas = $child->atleta()->where('pagamento', true)->get();
            if ($childAtletas->isEmpty()) {
                continue;
            }
            $teamName = $child->team_name ?? $child->name;
            if (!isset($teams[$teamName])) {
                $teams[$teamName] = [
                    'team_name' => $teamName,
                    'atletas' => collect(),
                    'modalidades' => [],
                ];
            }
            foreach ($childAtletas as $atleta) {
                $teams[$teamName]['atletas'][] = $atleta;
                foreach ($atleta->modalidade ?? [] as $mod) {
                    $teams[$teamName]['modalidades'][$mod][] = $atleta;
                }
            }
        }
    } else {
        $atletas = $user->atleta()->where('pagamento', true)->get();
        $teamName = $user->team_name ?? $user->name;
        $modalidades = [];
        foreach ($atletas as $atleta) {
            foreach ($atleta->modalidade ?? [] as $mod) {
                $modalidades[$mod][] = $atleta;
            }
        }
        $teams[$teamName] = [
            'team_name' => $teamName,
            'atletas' => $atletas,
            'modalidades' => $modalidades,
        ];
    }

    $totalAtletas = 0;
    foreach ($teams as $team) {
        $totalAtletas += $team['atletas']->count();
    }
    $total = $totalAtletas * 10;

    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.comprovante', [
        'user' => $user,
        'teams' => $teams,
        'total' => $total,
    ]);

    return $pdf->download('comprovante-' . str_replace(' ', '-', $user->name) . '.pdf');
})->name('pdf.comprovante');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/switch/user/{user}', function (App\Models\User $user) {
        $adminId = Auth::guard('admin')->id();
        Auth::guard('web')->login($user);
        Session::put('admin_id', $adminId);
        return redirect('/user');
    })->name('admin.switch.user');
});

Route::get('/admin/switch/back', function () {
    $adminId = Session::pull('admin_id');
    if ($adminId) {
        $admin = \App\Models\Admin::find($adminId);
        if ($admin) {
            Auth::guard('admin')->login($admin);
        }
    }
    return redirect('/admin');
})->name('admin.switch.back');
