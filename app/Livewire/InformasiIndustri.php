<?php
namespace App\Livewire;

use App\Models\Industri;
use Livewire\Component;

class InformasiIndustri extends Component
{
    // Variabel ini akan otomatis terhubung dengan input search
    public $search = '';

    public function render()
    {
        $industris = Industri::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.informasi-industri', [
            'industris' => $industris,
        ]);
    }
}
