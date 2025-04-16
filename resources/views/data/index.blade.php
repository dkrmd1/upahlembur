@extends('layouts.main')

@section('container')

   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <div class="card-title">Form Import Data</div>
               </div>
               <div class="card-body">
                  <form action="{{ route('import.data.penghasilan') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="file" accept=".xlsx, .csv" class="form-label">Import File</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required autofocus>
                                      @error('file')
                                          <div class="invalid-feedback">
                                              {{ $message }}
                                          </div>
                                      @enderror
                                </div>
                          </div>
                        </div>

                        <div class="card-action">
                           <button type="submit" class="btn btn-success">Simpan</button>
                           <a href="{{ route('import.data') }}" class="btn btn-danger">Kembali</a>
                        </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
        <div class="col-md-12">
           <div class="card">
              <div class="card-header">
                 <div class="d-flex align-items-center">
                    <h4 class="card-title">Data Penghasilan Nasabah</h4>
                 </div>
              </div>
              <div class="table-responsive">
                 <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                       <tr>
                          <th>No.</th>
                          <th>CIFID</th>
                          <th>SRE</th>
                          <th>SID</th>
                          <td>Nama</td>
                          <th>NIK KTP</th>
                          <th>Pekerjaan</th>
                          <th>Penghasilan Rata-Rata per Tahun</th>
                          <th>Sumber Penghasilan</th>
                          <th>RDN</th>
                          <th>Bank Pribadi</th>
                          <th>No Rekening Pribadi</th>
                       </tr>
                    </thead>
                    <tbody>
                       @if ($datas->isEmpty())
                          <tr>
                             <td colspan="12" class="text-center">Data belum tersedia</td>
                          </tr>
                       @else
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $data->cifid }}</td>
                                <td>{{ $data->sre }}</td>
                                <td>{{ $data->sid }}</td>
                                <td>{{ $data->nama }} </td>
                                <td>{{ $data->nik_ktp }}</td>
                                <td>{{ $data->pekerjaan }} </td>
                                <td>{{ $data->penghasilan_rata_rata_per_tahun }} </td>
                                <td>{{ $data->sumber_penghasilan }} </td>
                                <td>{{ $data->rdn }} </td>
                                <td>{{ $data->bank_pribadi }} </td>
                                <td>{{ $data->no_rekening_pribadi }} </td>
                            </tr>
                          @endforeach
                        @endif
                    </tbody>
                 </table>
              </div>
              </div>
           </div>
        </div>
   </div>
@endsection
