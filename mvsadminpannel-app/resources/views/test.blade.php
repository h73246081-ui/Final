
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Product</h5>
        </div>

        <div class="card-body">
            <form action="{{route('storeProduct')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Price *</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Discount</label>
                        <input type="number" name="discount" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Category ID</label>
                        <input type="number" name="category_id" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sub Category ID</label>
                        <input type="number" name="subcategory_id" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sizes (comma separated)</label>
                        <input type="text" name="sizes[]" class="form-control" placeholder="S,M,L,XL">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Colors (comma separated)</label>
                        <input type="text" name="colors[]" class="form-control" placeholder="Red,Blue,Black">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Specifications</label>
                        <textarea name="specifications" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Product Images</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">
                        Save Product
                    </button>
                </div>
            </form>

            <div id="responseMsg" class="mt-3"></div>
        </div>
    </div>
</div>
