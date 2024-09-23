<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\Rota;

class Usertablestatus extends Component
{
    use WithFileUploads;

    public $assignedrotaid;
    public $newImage;
    public $rotavisitimage;
    public $rotastatus;
    public $rotaupdateid;


    public function statusupdateforms()
    {
        // Validate the form data
        $validatedData = $this->validate([
            'rotastatus' => 'required',
            'newImage' => 'required',
            // 'newImage' => 'nullable|image|max:1024' // Validate the image upload (optional)
        ]);


        // Handle image upload if a new image is uploaded
        if ($this->newImage instanceof \Illuminate\Http\UploadedFile) {
            // Handle image upload if a new image is uploaded
            if ($this->rotavisitimage) {
                Storage::delete($this->rota->rotavisit_image);
            }
            // Store the new image
            $imagePath = $this->newImage->store('rotavisit_images', 'public'); // Specify the disk if necessary
        } else {
            // Keep the existing image if no new image is uploaded
            $imagePath = $this->rota->rotavisit_image;

        }
        // dd($imagePath, $this->rotastatus);

        // Update the Rota with the new data
        Rota::where('rota_id', $this->rotaupdateid)
            ->update([
                'rota_status' => $this->rotastatus,
                'rotavisit_image' => $imagePath,
        ]);


        session()->flash('statuupdatesucess', 'Rota updated successfully!');
        // Trigger the JavaScript event for redirection
        $this->dispatch('rotastatus-updated');
    }
    public function render()
    {
        $rota = Rota::where('rota_id', $this->assignedrotaid)->first();
        // dd($rota->rota_id);
        return view('livewire.usertablestatus',['rota'=>$rota]);
    }
}
