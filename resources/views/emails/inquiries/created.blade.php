@extends('emails.layouts.master')

@section('title', 'New Request')

@section('sub_title', 'A New Request Requires Your Approval')

@section('content')

    <p>{{ $user->name }}, the following {{ $inquiry->category_name }} request needs your approval:</p>

    <p>
        Title:
        <br>
        {{ $inquiry->title }}
    </p>

    <p>
        Description:
        <br>
        {{ $inquiry->description }}
    </p>

    <p>
        <b>If you would like to approve this request, click the approve button below.</b>
    </p>

    <p>
        Otherwise, take no action and disregard this email.
    </p>

    <div style="Margin-left: 20px;Margin-right: 20px;">
        <div style="line-height:5px;font-size:1px">&nbsp;</div>
    </div>

    <div style="Margin-left: 20px;Margin-right: 20px;">
        <div class="btn btn--flat" style="Margin-bottom: 20px;text-align: center;">
            <![if !mso]><a
                    style='border-radius: 4px;display: inline-block;font-weight: bold;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #fff;background-color: #33b037; font-family: &#39;PT Sans&#39;, &#39;Trebuchet MS&#39;, sans-serif;font-family: "PT Serif",Georgia,serif;font-size: 14px;line-height: 24px;padding: 12px 35px;'
                    href="{{ route('inquiries.approve.uuid', [$inquiry->uuid]) }}" data-width="50">Approve</a><![endif]>
            <!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p>
            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="http://www.google.ca" style="width:120px"
                         arcsize="9%" fillcolor="#33B037" stroke="f">
                <v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px">
                    <center style="font-size:14px;line-height:24px;color:#FFFFFF;font-family:Georgia,serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">
                        Approve
                    </center>
                </v:textbox>
            </v:roundrect><![endif]--></div>
    </div>

@endsection
