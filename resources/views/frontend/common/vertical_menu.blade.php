<!-- Category Menu -->

@php
  $categories = App\Models\Category::orderBy('category_name','ASC')->get();
@endphp

<div class="side-menu animate-dropdown outer-bottom-xs">
  <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
  <nav class="yamm megamenu-horizontal">
    <ul class="nav">
      <!-- category foreach loop -->
      @foreach($categories as $category)
      <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon {{ $category->category_icon  }}" aria-hidden="true"></i>{{ $category->category_name }}</a>
        <ul class="dropdown-menu mega-menu">
          <li class="yamm-content">
            <div class="row">
              <!--   // Get SubCategory Table Data -->
              @php
              $subcategories = App\Models\SubCategory::where('category_id',$category->id)->orderBy('subcategory_name','ASC')->get();
              @endphp
              <!-- Subcategory foreach loop -->
              @foreach($subcategories as $subcategory)
              <!-- /.col -->
              <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                <a href="{{ url('subcategory/product/'.$subcategory->id.'/'.$subcategory->subcategory_slug ) }}">
                  <h2 class="title">{{ $subcategory->subcategory_name }}</h2>
                </a>
                <!--   // Get SubSubCategory Table Data -->
                @php
                $subsubcategories = App\Models\SubSubCategory::where('subcategory_id',$subcategory->id)->orderBy('subsubcategory_name','ASC')->get();
                @endphp
                @foreach($subsubcategories as $subsubcategory)
                <ul class="links">
                  <li><a href="{{ url('subsubcategory/product/'.$subsubcategory->id.'/'.$subsubcategory->subsubcategory_slug ) }}">{{ $subsubcategory->subsubcategory_name }}</a></li>
                </ul>
                @endforeach
                <!-- // End SubSubCategory Foreach -->
              </div>
              <!-- /.col -->
              @endforeach
              <!-- // End SubCategory Foreach -->
            </div>
            <!-- /.row -->
          </li>
          <!-- /.yamm-content -->
        </ul>
        <!-- /.dropdown-menu -->
      </li>
      <!-- /.menu-item -->
      @endforeach
      <!-- End category foreach loop -->
    </ul>
    <!-- /.nav -->
  </nav>
  <!-- /.megamenu-horizontal -->
</div>