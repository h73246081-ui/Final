@extends('layouts.app')
@section('title', 'Edit Hero')
@section('content')
<div class="" style="background: white; height:427px">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit Hero Section</h5>
    </div>
    <div style="margin-top:2px;">
        <form action="{{route('admin.cms.home.hero_section.update')}}" method="POST">
            @csrf
            @method('PUT')

            <div class="row" style="padding: 15px;">
                <div class="mb-3 col-lg-6">
                    <label>Badge</label>
                    <input type="text" name="badge" class="form-control" value="{{ old('badge', $hero->badge ?? '') }}">
                </div>

                <div class="mb-3 col-lg-6">
                    <label>Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $hero->subtitle ?? '') }}">
                </div>

                <div class="mb-3 col-lg-12">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $hero->title ?? '') }}">
                </div>

                <div class="mb-3 col-lg-12">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $hero->description ?? '') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="float: inline-end;">Update</button>
        </form>
    </div>
</div>
@endsection
