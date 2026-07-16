@extends('layouts.app')

@section('title', 'PCB Dimension Calculator')

@section('content')

<div class="card">

    <h2>PCB Dimension Calculator</h2>

    <p class="subtitle">
        Upload Gerber ZIP file to calculate PCB dimensions
    </p>

    <form method="POST"
          id="gerberForm"
          action="{{ route('gerber.upload') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="upload-box">
            <input
                type="file"
                name="gerber"
                id="gerber"
                accept=".zip">
        </div>

        <span id="error" class="error"></span>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        <div class="instruction-box">

            <h4>Upload Instructions</h4>

            <ul>
                <li>Maximum file size: <b>1 MB</b></li>
                <li>Supported format: <b>.zip only</b></li>
                <li>Board dimensions will be calculated automatically</li>
                <li>Board size will be calculated in <b>mm</b></li>
            </ul>

        </div>

        <button type="submit" id="submitBtn">
            Calculate Dimensions
        </button>

    </form>

</div>

@endsection