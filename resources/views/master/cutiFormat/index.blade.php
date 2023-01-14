<x-app-layout title="Master - Cuti Format">
    <h1 class="h3 mb-4 text-gray-800">Cuti Format</h1>

    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cuti Format</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.cuti.format.edit', ['cutiFormat' => $cutiFormat]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="cuti">Cuti</label>
                            <input type="number" class="form-control @error('cuti') is-invalid @enderror" id="cuti"
                                name="cuti" value="{{ old('cuti', $cutiFormat->cuti) }}" min="1">
                            @error('cuti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cuti_bersama">Cuti Bersama</label>
                            <input type="number" class="form-control @error('cuti_bersama') is-invalid @enderror"
                                id="cuti_bersama" name="cuti_bersama"
                                value="{{ old('cuti_bersama', $cutiFormat->cuti_bersama) }}" min="1">
                            @error('cuti_bersama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cuti_menikah" class="float-left">Cuti Menikah</label>
                            <input type="number" class="form-control @error('cuti_menikah') is-invalid @enderror"
                                id="cuti_menikah" name="cuti_menikah"
                                value="{{ old('cuti_menikah', $cutiFormat->cuti_menikah) }}" min="1">
                            @error('cuti_menikah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cuti_melahirkan">Cuti Melahirkan</label>
                            <input type="number" class="form-control @error('cuti_melahirkan') is-invalid @enderror"
                                id="cuti_melahirkan" name="cuti_melahirkan"
                                value="{{ old('cuti_melahirkan', $cutiFormat->cuti_melahirkan) }}" min="1">
                            @error('cuti_melahirkan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen fa-fw"></i>
                            Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
