@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Total Hafalan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Gil</td>
                            <td>10 Juz</td>
                            <td>
                                <div class="btn-action d-flex">
                                    <a href="#">
                                        <i width="14" color="green" data-feather="eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection