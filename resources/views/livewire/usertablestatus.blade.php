<div>
    <form wire:submit.prevent="statusupdateforms">
        <div class="row">
            <div class="col-md-12">
                <input type="text" wire:model="rotaupdateid" value="{{$rota->rota_id}}" hidden>
                <div class="mb-3">
                    <label for="rotastatus" class="form-label required">Select
                        Status</label>
                    <select class="form-control" wire:model="rotastatus">
                        <option value="not visited"
                            {{ $rota->rota_status === 'not visited' ? 'selected' : '' }}>not
                            visited</option>
                        <option value="visited"
                            {{ $rota->rota_status === 'visited' ? 'selected' : '' }}>
                            visited</option>
                    </select>
                    @error('rotastatus')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="rotavisitimage" class="form-label">Visit Image</label>

                    <input type="file" id="rotavisitimage" class="form-control" wire:model="newImage">
                    @error('newImage')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @if (session('statuupdatesucess'))
                <span
                    class="p-2 rounded text-bg-success">{{ session('statuupdatesucess') }}</span>
            @endif
            <!-- The form submits when this button is clicked -->
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
