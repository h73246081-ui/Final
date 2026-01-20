@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Website Banners CMS</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('cms.update.banner') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- SHOP --}}
                <h6 class="text-primary mt-3">Shop Page</h6>
                <div class="mb-3">
                    <label class="form-label">Shop Heading</label>
                    <input type="text" name="shop_heading" class="form-control"
                           value="{{ old('shop_heading', $banner->shop_heading ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Shop Text</label>
                    <textarea name="shop_text" rows="3" class="form-control">{{ old('shop_text', $banner->shop_text ?? '') }}</textarea>
                </div>

                {{-- VENDOR --}}
                <h6 class="text-primary mt-4">Vendor Page</h6>
                <div class="mb-3">
                    <label class="form-label">Vendor Heading</label>
                    <input type="text" name="vendor_heading" class="form-control"
                           value="{{ old('vendor_heading', $banner->vendor_heading ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Vendor Text</label>
                    <textarea name="vendor_text" rows="3" class="form-control">{{ old('vendor_text', $banner->vendor_text ?? '') }}</textarea>
                </div>

                {{-- CONTACT --}}
                <h6 class="text-primary mt-4">Contact Page</h6>
                <div class="mb-3">
                    <label class="form-label">Contact Heading</label>
                    <input type="text" name="contact_heading" class="form-control"
                           value="{{ old('contact_heading', $banner->contact_heading ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Text</label>
                    <textarea name="contact_text" rows="3" class="form-control">{{ old('contact_text', $banner->contact_text ?? '') }}</textarea>
                </div>

                {{-- ABOUT --}}
                <h6 class="text-primary mt-4">About Page</h6>
                <div class="mb-3">
                    <label class="form-label">About Heading</label>
                    <input type="text" name="about_heading" class="form-control"
                           value="{{ old('about_heading', $banner->about_heading ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">About Text</label>
                    <textarea name="about_text" rows="3" class="form-control">{{ old('about_text', $banner->about_text ?? '') }}</textarea>
                </div>

                {{-- BLOG --}}
                <h6 class="text-primary mt-4">Blog Page</h6>
                <div class="mb-3">
                    <label class="form-label">Blog Heading</label>
                    <input type="text" name="blog_heading" class="form-control"
                           value="{{ old('blog_heading', $banner->blog_heading ?? '') }}">
                </div>

                {{-- TERMS --}}
                <h6 class="text-primary mt-4">Terms & Conditions</h6>
                <div class="mb-3">
                    <label class="form-label">Terms Heading</label>
                    <input type="text" name="term_heading" class="form-control"
                           value="{{ old('term_heading', $banner->term_heading ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Terms Text</label>
                    <textarea name="term_text" rows="4" class="form-control">{{ old('term_text', $banner->term_text ?? '') }}</textarea>
                </div>

                {{-- PRIVACY --}}
                <h6 class="text-primary mt-4">Privacy Policy</h6>
                <div class="mb-3">
                    <label class="form-label">Privacy Heading</label>
                    <input type="text" name="privacy_heading" class="form-control"
                           value="{{ old('privacy_heading', $banner->privacy_heading ?? '') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">Privacy Text</label>
                    <textarea name="privacy_text" rows="4" class="form-control">{{ old('privacy_text', $banner->privacy_text ?? '') }}</textarea>
                </div>

                <div class="text-end">
                    <button class="btn btn-success px-4">
                        <i class="bi bi-save"></i> Update Content
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
