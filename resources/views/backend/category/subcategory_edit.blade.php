@extends('admin.admin_master')
@section('admin')

<div class="container-full">

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <!-- Edit SubCategory Page -->

      <div class="col-12">

        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Edit SubCategory</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <form method="post" action="{{ route('subcategory.update') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $subcategory->id }}">

                <div class="form-group">
                  <h5>Select Category<span class="text-danger">*</span></h5>
                  <div class="controls">
                    <select name="category_id" class="form-control">
                      <option value="" selected="" disabled="">Select Your Category</option>
                      @foreach($categories as $category)
                      <option value="{{ $category->id  }}" {{ $category->id == $subcategory->category_id ? 'selected' : ' ' }} >{{ $category->category_name }}</option>
                      @endforeach
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <h5>SubCategory Name <span class="text-danger">*</span></h5>
                  <div class="controls">
                    <input type="text" name="subcategory_name" class="form-control" value="{{ $subcategory->subcategory_name }}">
                    @error('subcategory_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="text-xs-right">
                  <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update SubCategory">
                </div>
              </form>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->

    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

</div>

@endsection