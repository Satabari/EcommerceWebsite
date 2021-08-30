@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="container-full">

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <!-- Edit SubSubCategory Page -->

      <div class="col-12">

        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Sub-SubCategory</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <form method="post" action="{{ route('subsubcategory.update') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $subsubcategory->id }}">

                <div class="form-group">
                  <h5>Select Category<span class="text-danger">*</span></h5>
                  <div class="controls">
                    <select name="category_id" class="form-control">
                      <option value="" selected="" disabled="">Select Your Category</option>
                      @foreach($categories as $category)
                      <option value="{{ $category->id  }}" {{ $category->id == $subsubcategory->category_id ? 'selected' : ' ' }} >{{ $category->category_name }}</option>
                      @endforeach
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <h5>Select SubCategory<span class="text-danger">*</span></h5>
                  <div class="controls">
                    <select name="subcategory_id" class="form-control">
                      <option value="" selected="" disabled="">Select Your SubCategory</option>
                      @foreach($subcategories as $subcategory)
                      <option value="{{ $subcategory->id  }}" {{ $subcategory->id == $subsubcategory->subcategory_id ? 'selected' : ' ' }} >{{ $subcategory->subcategory_name }}</option>
                      @endforeach
                    </select>
                    @error('subcategory_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <h5>SubSubCategory Name <span class="text-danger">*</span></h5>
                  <div class="controls">
                    <input type="text" name="subsubcategory_name" class="form-control" value="{{ $subsubcategory->subsubcategory_name }}">
                    @error('subsubcategory_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="text-xs-right">
                  <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update SubSubCategory">
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