<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;

class DaftarAnggota extends Component
{
    use WithFileUploads;

    // SLiMS 9 aligned fields
    public $nip = '';
    public $nama = '';
    public $gender = 'Laki-laki';
    public $birth_date = '';
    public $member_type_id = 1;
    public $alamat = '';
    public $alamat_surat = '';
    public $kode_pos = '';
    public $email = '';
    public $no_hp = '';
    public $no_faks = '';
    public $institusi = '';
    public $member_since_date = '';
    public $register_date = '';
    public $expire_date = '';
    public $catatan = '';
    public $is_pending = false;
    public $foto;

    // Dynamic lists
    public $memberTypes = [];
    
    public $successMessage = false;
    public $submittedAnggota = null;

    protected $rules = [
        'nip' => 'required|string|max:255|unique:anggotas,nip',
        'nama' => 'required|string|max:255',
        'gender' => 'required|in:Laki-laki,Perempuan',
        'birth_date' => 'required|date',
        'member_type_id' => 'required|integer',
        'alamat' => 'nullable|string|max:500',
        'alamat_surat' => 'nullable|string|max:500',
        'kode_pos' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'no_hp' => 'nullable|string|max:20',
        'no_faks' => 'nullable|string|max:20',
        'institusi' => 'nullable|string|max:255',
        'member_since_date' => 'required|date',
        'register_date' => 'required|date',
        'expire_date' => 'required|date',
        'catatan' => 'nullable|string|max:1000',
        'is_pending' => 'boolean',
        'foto' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'nip.required' => 'NIP wajib diisi.',
        'nip.unique' => 'NIP sudah terdaftar.',
        'nama.required' => 'Nama lengkap wajib diisi.',
        'gender.required' => 'Jenis kelamin wajib dipilih.',
        'birth_date.required' => 'Tanggal lahir wajib diisi.',
        'birth_date.date' => 'Format tanggal lahir tidak valid.',
        'member_type_id.required' => 'Tipe keanggotaan wajib dipilih.',
        'member_since_date.required' => 'Tanggal awal keanggotaan wajib diisi.',
        'register_date.required' => 'Tanggal registrasi wajib diisi.',
        'expire_date.required' => 'Tanggal berlaku hingga wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'foto.image' => 'File harus berupa gambar.',
        'foto.max' => 'Ukuran foto maksimal 2MB.',
    ];

    public function mount()
    {
        $this->member_since_date = now()->format('Y-m-d');
        $this->register_date = now()->format('Y-m-d');
        $durationYears = (int) config('services.slims.duration_years', 1);
        $this->expire_date = now()->addYears($durationYears)->format('Y-m-d');

        // Dynamically load SLiMS membership types
        try {
            $this->memberTypes = DB::connection('slims')
                ->table('mst_member_type')
                ->get(['member_type_id', 'member_type_name'])
                ->toArray();
            
            if (!empty($this->memberTypes)) {
                $this->member_type_id = $this->memberTypes[0]->member_type_id;
            }
        } catch (\Exception $e) {
            // Fallback to basic list if connection is offline
            $this->memberTypes = [
                (object) ['member_type_id' => 1, 'member_type_name' => 'Standard']
            ];
            $this->member_type_id = 1;
        }
    }

    public function submit()
    {
        $this->validate();

        $fotoPath = null;
        if ($this->foto) {
            $fotoPath = $this->foto->store('anggota-fotos', 'public');
        }

        $anggota = Anggota::create([
            'nip' => $this->nip,
            'nama' => $this->nama,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'member_type_id' => $this->member_type_id,
            'alamat' => $this->alamat,
            'alamat_surat' => $this->alamat_surat,
            'kode_pos' => $this->kode_pos,
            'email' => $this->email,
            'no_hp' => $this->no_hp,
            'no_faks' => $this->no_faks,
            'institusi' => $this->institusi,
            'member_since_date' => $this->member_since_date,
            'register_date' => $this->register_date,
            'expire_date' => $this->expire_date,
            'catatan' => $this->catatan,
            'is_pending' => $this->is_pending,
            'foto' => $fotoPath,
            'status' => 'pending',
        ]);

        $this->submittedAnggota = $anggota;
        $this->successMessage = true;
    }

    public function resetForm()
    {
        $this->successMessage = false;
        $this->submittedAnggota = null;
        $this->reset([
            'nip', 'nama', 'gender', 'birth_date', 'member_type_id', 
            'alamat', 'alamat_surat', 'kode_pos', 'email', 'no_hp', 
            'no_faks', 'institusi', 'catatan', 'is_pending', 'foto'
        ]);
        
        $this->member_since_date = now()->format('Y-m-d');
        $this->register_date = now()->format('Y-m-d');
        $durationYears = (int) config('services.slims.duration_years', 1);
        $this->expire_date = now()->addYears($durationYears)->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.daftar-anggota')->layout('layouts.public', ['title' => 'Daftar Anggota']);
    }
}
