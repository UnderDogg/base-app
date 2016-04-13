@extends('layouts.master')

@section('title', "Editing {$computer->name}")

@section('title.header', ' ')

@section('panel.title')

    <i class="fa fa-desktop"></i>

    Edit Computer

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
