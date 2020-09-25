@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="d-flex flex-wrap justify-content-between">
            <div>
                <h1 class="text-center text-md-left h1-responsive" name="top">Laporan Pencapaian Kurikulum / {{ $student->name }}</h1>
                <h3>Laporan Pencapaian Kurikulum per Mata Pelajaran</h3>
            </div>
            <div>
                <a href="{{ route('journal.index' )}}" class="btn btn-outline-primary"><i class="fas fa-chevron-left mr-1"></i> Kembali</a>
            </div>
        </div>
        @include('layouts.form-periode-with-id', ['route' => 'journal.report.feedback-student', 'name' => 'start_date', 'id' => $student->id ])

        <div class="d-flex flex-wrap text-center my-4 justify-content-center">
            <div class="w-25 teal accent-4 text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($feedback_total[0]->persen_sudahpaham, 2) }}%</h4>
                <h6 class="font-weight-bold">Sudah Paham</h6>
            </div>
            <div class="w-25 red darken-1 text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($feedback_total[0]->persen_belumpaham, 2) }}%</h4>
                <h6 class="font-weight-bold">Belum Paham</h6>
            </div>
            <div class="w-25 light-blue accent-4 text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($feedback_total[0]->persen_teratasi, 2) }}%</h4>
                <h6 class="font-weight-bold">Teratasi</h6>
            </div>
            <div class="w-25 stylish-color text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($feedback_total[0]->persen_belumfeedback, 2) }}%</h4>
                <h6 class="font-weight-bold">Belum Feedback</h6>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3">
            @forelse($feedback as $f)
                <div class="col mb-4">
                    <div class="card">
                        <div class="view overlay">
                            <canvas id="canvas{{ $f->id_subject }}"></canvas>
                        </div>
                    </div>
                </div>
            @empty
            <div>
                <h6>Data kosong!</h6>
            </div>
            @endforelse
        </div>
    
        <div class="mt-2">
            <h2>Detail Feedback dari {{ $student->name }}</h2>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped" id="dtfeedback_detail">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Pelajaran</th>
                                    <th>Sub Materi Pelajaran</th>
                                    <th>Materi Pelajaran</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Catatan</th>
                                    <th>Feedback Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no=1; @endphp
                            @forelse($feedback_detail as $fd)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $fd->teaching_date }}</td>
                                    <td>{{ $fd->subMatterName }}</td>
                                    <td>{{ $fd->matterName }}</td>
                                    <td>{{ $fd->subjectName }}</td>
                                    <td class="align-items-center d-flex">
                                        <a type="button" data-toggle="popover" title="Catatan" data-content="{{ $fd->note }}">
                                            <i class="fas fa-sticky-note fa-lg" style="color:#ffbb33"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($fd->feedback_option == 'y' and $fd->treat_status == NULL)
                                            <p class="badge badge-success">Sudah Paham</p>
                                        @elseif($fd->feedback_option == 'n' and $fd->treat_status == NULL)
                                            <p class="badge badge-danger">Belum Paham</p>
                                            <button
                                                id="btn-treat{{ $fd->id }}" 
                                                type="button" 
                                                class="btn btn-sm btn-default" 
                                                style="border-radius:25px" 
                                                data-toggle="modal" 
                                                data-target="#modal-treat{{ $fd->id }}"
                                                data-id_journal_feed="{{ $fd->id }}"
                                                data-note="{{ $fd->note }}"
                                                data-url="{{ route('journal.report.feedback-treat', $fd->id_student) }}">
                                                    <i class="fas fa-wrench mr-2"></i>Treat
                                            </button>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <p class="badge badge-info">Sudah Teratasi</p>
                                                <p class="ml-1" type="button" data-toggle="popover" title="Tindakan" data-content="{{ $fd->description }}">
                                                    <i class="fas fa-list-alt fa-lg" style="color:#0099CC"></i>
                                                </p>
                                            </div>
                                        @endif
                                    </td>
                                    @include('journal.report.form', ['id' => $fd->id])
                                    <script>
                                        $(document).ready(function() {
                                            $('#btn-treat{{ $fd->id }}').on('click', function() {
                                                let note = $('#btn-treat{{ $fd->id }}').data('note');
                                                let id_journal_feed = $('#btn-treat{{ $fd->id }}').data('id_journal_feed');
                                                let url = $('#btn-treat{{ $fd->id }}').data('url');

                                                $('#form-treat{{ $fd->id }}').attr('action',url);
                                                $('#id_journal_feed{{ $fd->id }}').val(id_journal_feed);
                                                $('#form-note{{ $fd->id }}').text(note);
                                            })
                                        })
                                    </script>
                                </tr>
                            @empty
                                <tr>
                                    <td>No data!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover({
                trigger:'hover',
                placement: 'top',
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            let feedback = {!! json_encode($feedback) !!}
            console.log(feedback);
            feedback.map(result => {
                let idCanvas = 'canvas'+result.id_subject;
                
                let ctx = document.getElementById(idCanvas).getContext('2d');

                let data = [parseFloat(result.persen_sudahpaham).toFixed(2), parseFloat(result.persen_belumpaham).toFixed(2), parseFloat(result.persen_teratasi).toFixed(2), parseFloat(result.persen_belumfeedback).toFixed(2)];
                let labels = ["Sudah Paham", "Belum Paham", "Teratasi", "Belum Feedback"];

                let chart = new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: labels,
                        datasets:[
                            {
                                data:data,
                                backgroundColor:[
                                    "#27ae60",
                                    "#FF6384",
                                    "#0091ea",
                                    "#4B515D"
                                ],
                            },
                        ]
                    },
                    options:{
                        title: {
                            display: true,
                            text: "Laporan Feedback Mapel: "+result.subject_name+" (%)"
                        },
                        legend:{
                            display:true,
                            position:'left'
                        }
                    }
                })
            })
        });
    </script>
    <script>
        $(document).ready(function (e) {
            
            $('#dtfeedback_detail').DataTable({
                "paging":true,
            });
        });
    </script>
@endsection