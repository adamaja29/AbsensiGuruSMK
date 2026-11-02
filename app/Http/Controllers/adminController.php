<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class adminController extends Controller
{
    public function dataGuru(Request $request): View
    {
        $guru = Guru::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'guru');
            })
            ->where(function ($query) use ($request) {
                if ($search = $request->string('search')->trim()->toString()) {
                    $query->where('nip', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.guru.data', [
            'guru' => $guru,
            'search' => $request->input('search'),
        ]);
    }

    public function createGuru(): View
    {
        return view('admin.guru.tambah');
    }

    public function storeGuru(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'nip' => ['nullable', 'string', 'max:255', 'unique:guru,nip'],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'] ?: null,
                'no_hp' => $validated['no_hp'] ?: null,
            ]);
        });

        return redirect()->route('admin.guru.data')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function editGuru(Guru $guru): View
    {
        $guru->load('user');

        return view('admin.guru.edit', compact('guru'));
    }

    public function updateGuru(Request $request, Guru $guru): RedirectResponse
    {
        $guru->load('user');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($guru->user->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'nip' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('guru', 'nip')->ignore($guru->id),
            ],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated, $guru) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => 'guru',
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            $guru->user->update($userData);
            $guru->update([
                'nip' => $validated['nip'] ?: null,
                'no_hp' => $validated['no_hp'] ?: null,
            ]);
        });

        return redirect()->route('admin.guru.data')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroyGuru(Guru $guru): RedirectResponse
    {
        DB::transaction(function () use ($guru) {
            $guru->delete();

            if ($guru->user) {
                $guru->user->delete();
            }
        });

        return redirect()->route('admin.guru.data')->with('success', 'Data guru berhasil dihapus.');
    }


    //WAKA
    public function dataWaka(Request $request): View
    {
        $waka = User::where('role', 'waka')
            ->where(function ($query) use ($request) {
                if ($search = $request->string('search')->trim()->toString()) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.waka.data', [
            'waka' => $waka,
            'search' => $request->input('search'),
        ]);
    }

    public function createWaka(): View
    {
        return view('admin.waka.tambah');
    }

    public function storeWaka(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'waka',
        ]);

        return redirect()->route('admin.waka.data')->with('success', 'Data waka berhasil ditambahkan.');
    }

    public function editWaka(User $waka): View
    {
        return view('admin.waka.edit', compact('waka'));
    }

    public function updateWaka(Request $request, User $waka): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($waka->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'waka',
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }

        $waka->update($userData);

        return redirect()->route('admin.waka.data')->with('success', 'Data waka berhasil diperbarui.');
    }

    public function destroyWaka(User $waka): RedirectResponse
    {
        $waka->delete();

        return redirect()->route('admin.waka.data')->with('success', 'Data waka berhasil dihapus.');
    }
}
