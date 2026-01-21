@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card">
        <div class="card-header bg-warning text-dark">
            Edit Category
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('category.update', $category->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Category Name --}}
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $category->name) }}">
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>

                {{-- Any Question Description --}}
                <div class="mb-3">
                    <label class="form-label">Any Question Description</label>
                    <textarea name="question_description" class="form-control" rows="3">{{ old('question_description', $category->question_description) }}</textarea>
                </div>

                <hr>
                <h5>SEO Information</h5>

                {{-- Meta Title --}}
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control"
                           value="{{ old('meta_title', $category->meta_title) }}">
                </div>

                {{-- Meta Description --}}
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $category->meta_description) }}</textarea>
                </div>

                {{-- Meta Keyword --}}
                <div class="mb-3">
                    <label class="form-label">Meta Keyword</label>
                    <input type="text" name="meta_keyword" class="form-control"
                           value="{{ old('meta_keyword', $category->meta_keyword) }}">
                </div>

                {{-- Image --}}
                <div class="mb-3">
                    <label class="form-label">Category Image</label>
                    <input type="file" name="image" class="form-control">

                    @if($category->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$category->image) }}"
                                 width="100"
                                 class="img-thumbnail">
                        </div>
                    @endif
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Update Category
                    </button>

                    <a href="{{ route('category.index') }}"
                       class="btn btn-secondary">
                        Back
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
