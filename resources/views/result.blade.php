@extends('layouts.app')

@section('title', 'PCB Dimensions')

@section('content')

<div class="card">

    <h2>PCB Dimensions</h2>
    <div class="success">
        Gerber file processed successfully
    </div>
    <table class="result-table">
        <tr>
            <th>Board Width</th>
            <td>{{ $dimensions['width'] }} mm</td>
        </tr>

        <tr>
            <th>Board Height</th>
            <td>{{ $dimensions['height'] }} mm</td>
        </tr>
    </table>

    <br>

    <a href="{{ route('gerber.index') }}">
        Upload Another File
    </a>

</div>

@endsection