@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="container-full">

  <!-- Main content -->
  <section class="content">

    <!-- Basic Forms -->
    <div class="box">
      <div class="box-header with-border">
        <h4 class="box-title">Add Product</h4>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col">
            <form method="post" action="{{ route('product-store') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <!-- 1st row -->

                <div class="col-md-6">
                  <!-- 1st col -->
                  <div class="form-group">
                    <h5>Select Brand<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <select name="brand_id" class="form-control" required="">
                        <option value="" selected="" disabled="">Select Your Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id  }}">{{ $brand->brand_name }}</option>
                        @endforeach
                      </select>
                      @error('brand_id')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 1st col -->
                </div>

                <div class="col-md-6">
                  <!-- 2nd col -->
                  <div class="form-group">
                    <h5>Select Category<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <select name="category_id" class="form-control" required="">
                        <option value="" selected="" disabled="">Select Your Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id  }}">{{ $category->category_name }}</option>
                        @endforeach
                      </select>
                      @error('category_id')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 2nd col -->
                </div>

                <!-- End of 1st row -->
              </div>

              <div class="row">
                <!-- 2nd row -->

                <div class="col-md-6">
                  <!-- 2nd row 1st col -->
                  <div class="form-group">
                    <h5>Select SubCategory<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <select name="subcategory_id" class="form-control" required="">
                        <option value="" selected="" disabled="">Select Your SubCategory</option>

                      </select>
                      @error('subcategory_id')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 2nd row 1st col -->
                </div>

                <div class="col-md-6">
                  <!-- 2nd row 2nd col -->
                  <div class="form-group">
                    <h5>Select Sub-SubCategory<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <select name="subsubcategory_id" class="form-control" required="">
                        <option value="" selected="" disabled="">Select Your SubSubCategory</option>

                      </select>
                      @error('subsubcategory_id')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 2nd row 2nd col -->
                </div>

                <!-- End of 2nd row -->
              </div>

              <div class="row">
                <!-- 3rd row -->

                <div class="col-md-6">
                  <!-- 3rd row 1st col -->
                  <div class="form-group">
                    <h5>Product Name<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="product_name" class="form-control" required data-validation-required-message="This field is required">
                      @error('product_name')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 3rd row 1st col -->
                </div>

                <div class="col-md-6">
                  <!-- 3rd row 2nd col -->
                  <div class="form-group">
                    <h5>Product Code<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="product_code" class="form-control" required data-validation-required-message="This field is required">
                      @error('product_code')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- 3rd row 2nd col -->
                </div>

                <!-- End of 3rd row -->
              </div>

              <div class="row">
                <!-- 4th row -->

                <div class="col-md-6">
                  <!-- 4th row 1st col -->
                  <div class="form-group">
                    <h5>Product Quantity<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="product_qty" class="form-control" required data-validation-required-message="This field is required">
                      @error('product_qty')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 4th row 1st col -->
                </div>

                <div class="col-md-6">
                  <!-- 4th row 2nd col -->
                  <div class="form-group">
                    <h5>Product Tags<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="product_tag" value="" data-role="tagsinput" placeholder="Add tags" required="" />
                    </div>
                    @error('product_tag')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <!-- End of 4th row 2nd col -->
                </div>

                <!-- End of 4th row -->
              </div>

              <div class="row">
                <!-- 5th row -->

                <div class="col-md-6">
                  <div class="form-group">
                    <h5>Product Size<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="product_size" value="small,medium,large" data-role="tagsinput" placeholder="Add tags" required="" />
                    </div>
                    @error('product_size')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <h5>Product Color<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="product_color" value="" data-role="tagsinput" placeholder="Add tags" required="" />
                    </div>
                    @error('product_color')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <!-- End of 5th row   -->
              </div>

              <div class="row">
                <!-- 6th row -->

                <div class="col-md-6">
                  <!-- 6th row 1st col -->
                  <div class="form-group">
                    <h5>Product Selling Price<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="selling_price" class="form-control" required data-validation-required-message="This field is required">
                      @error('selling_price')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 6th row 1st col -->
                </div>

                <div class="col-md-6">
                  <!-- 6th row 2nd col -->
                  <div class="form-group">
                    <h5>Product Discount Price<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="discount_price" class="form-control">
                      @error('discount_price')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- 6th row 2nd col -->
                </div>

                <!-- End of 6th row -->
              </div>

              <div class="row">
                <!-- 7th row -->

                <div class="col-md-6">
                  <!-- 7th row 1st col -->
                  <div class="form-group">
                    <h5>Main Thumbnail<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="file" name="product_thumbnail" class="form-control" onchange="mainThumbUrl(this)" required="">
                      @error('product_thumbnail')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                      <img src="" id="main_thumbnail" alt="">
                    </div>
                  </div>
                  <!-- End 7th row 1st col -->
                </div>

                <div class="col-md-6">
                  <!-- 7th row 2nd col -->
                  <div class="form-group">
                    <h5>Multiple Image<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="file" id="multi_img" name="multi_img[]" class="form-control" multiple="" required="">
                      @error('multi_img')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                      <div class="row" id="preview_img"></div>
                    </div>
                  </div>
                  <!-- 7th row 2nd col -->
                </div>

                <!-- End of 7th row -->
              </div>

              <div class="row">
                <!-- 8th row -->

                <div class="col-md-12">
                  <!-- 8th row 1st col -->
                  <div class="form-group">
                    <h5>Short Description <span class="text-danger">*</span></h5>
                    <div class="controls">
                      <textarea name="short_descp" id="textarea" class="form-control" required placeholder="Textarea text"></textarea>
                      @error('short_descp')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <!-- End 8th row 1st col -->
                </div>

                <!-- End of 8th row -->
              </div>

              <div class="row">
                <!-- 9th row -->

                <div class="col-md-12">
                  <!-- 9th row 1st col -->

                  <div class="form-group">
                    <h5>Long Description <span class="text-danger">*</span></h5>
                    <div class="controls">
                      <textarea id="editor1" name="long_descp" rows="10" cols="80" required="">
                        Long Description
                      </textarea>
                      @error('long_descp')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <!-- End 9th row 1st col -->
                  </div>

                  <!-- End of 9th row -->
                </div>

              </div>

              <hr>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="controls">
                      <fieldset>
                        <input type="checkbox" id="checkbox_1" name="hot_deals" value="1">
                        <label for="checkbox_1">Hot Deals</label>
                      </fieldset>
                      <fieldset>
                        <input type="checkbox" id="checkbox_2" name="featured" value="1">
                        <label for="checkbox_2">Featured</label>
                      </fieldset>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="controls">
                      <fieldset>
                        <input type="checkbox" id="checkbox_3" name="special_offer" value="1">
                        <label for="checkbox_3">Special Offers</label>
                      </fieldset>
                      <fieldset>
                        <input type="checkbox" id="checkbox_4" name="special_deals" value="1">
                        <label for="checkbox_4">Special Deals</label>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <h5>Digital Product <span class="text-danger">pdf,xlx,csv*</span></h5>
                    <div class="controls">
                      <input type="file" name="file" class="form-control">
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-xs-right">
                <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add Product">
              </div>

            </form>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>

<!-- //For loading subcategory and sub-subcategory -->

<script type="text/javascript">
  $(document).ready(function() {

    // For loading subcategory based on category

    $('select[name="category_id"]').on('change', function() {
      var category_id = $(this).val();
      if (category_id) {
        $.ajax({
          url: "{{ url('/category/subcategory/ajax') }}/" + category_id,
          type: "GET",
          dataType: "json",
          success: function(data) {
            $('select[name="subsubcategory_id"]').html('');
            var d = $('select[name="subcategory_id"]').empty();
            $.each(data, function(key, value) {
              $('select[name="subcategory_id"]').append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
            });
          },
        });
      } else {
        alert('danger');
      }
    });

    // For loading subsubcategory based on subcategory

    $('select[name="subcategory_id"]').on('change', function() {
      var subcategory_id = $(this).val();
      if (subcategory_id) {
        $.ajax({
          url: "{{ url('/category/sub-subcategory/ajax') }}/" + subcategory_id,
          type: "GET",
          dataType: "json",
          success: function(data) {
            var d = $('select[name="subsubcategory_id"]').empty();
            $.each(data, function(key, value) {
              $('select[name="subsubcategory_id"]').append('<option value="' + value.id + '">' + value.subsubcategory_name + '</option>');
            });
          },
        });
      } else {
        alert('danger');
      }
    });

  });
</script>

<!-- //For Loading single image -->

<script type="text/javascript">
  function mainThumbUrl(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#main_thumbnail').attr('src', e.target.result).width(80).height(80);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<!-- //For loading multiple image -->

<script>
  $(document).ready(function() {
    $('#multi_img').on('change', function() { //on file input change
      if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
      {
        var data = $(this)[0].files; //this file data

        $.each(data, function(index, file) { //loop though each file
          if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
            var fRead = new FileReader(); //new filereader
            fRead.onload = (function(file) { //trigger function on successful read
              return function(e) {
                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(80).height(80); //create image element 
                $('#preview_img').append(img); //append image to output element
              };
            })(file);
            fRead.readAsDataURL(file); //URL representing the file's data.
          }
        });

      } else {
        alert("Your browser doesn't support File API!"); //if File API is absent
      }
    });
  });
</script>

@endsection