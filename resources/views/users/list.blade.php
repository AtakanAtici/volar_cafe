@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-header">
            <a href="{{route('users.create')}}" class="btn btn-success">
                Ekle
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>Kullanıcı</td>
                        <td>Bayi</td>
                        <td>Kullanıcı kodu</td>
                        <td>İşlemler</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->dealer->name}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                                <div class="">
                                    <a href="{{route('users.delete', $user->id)}}" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </>
    </div>
    @endsection