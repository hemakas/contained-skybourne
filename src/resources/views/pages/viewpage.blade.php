@extends('layouts.master')
@section('pageTitle', $pagetitle)
@section('pageMetaKeywords', $metakeywords)
@section('pageMetaDesc', $metadesc)
@section('content')

<section>
    <div id="pagecontent">
        {!! $content !!}
    </div>
</section>


@endsection
