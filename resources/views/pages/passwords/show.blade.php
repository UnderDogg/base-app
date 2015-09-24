@extends('layouts.master')

@inject('formbuilder', 'form')

@section('title', $password->title)

@section('content')

    {!! $formbuilder->label('Title') !!}

    {!! $formbuilder->password('password', ['class' => 'form-control password-show']) !!}

@stop
