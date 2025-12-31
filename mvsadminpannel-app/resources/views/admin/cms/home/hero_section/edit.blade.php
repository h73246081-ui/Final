@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Edit Hero Section</h2>

    <form action="{{route('admin.cms.home.hero_section.update')}}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
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

        <button type="submit" class="btn btn-primary">Update Hero Section</button>
    </form>
</div>
@endsection
