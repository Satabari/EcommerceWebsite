<!-- Tag Wise Product -->

@php
  $tags = App\Models\Product::groupBy('product_tag')->select('product_tag')->get();
@endphp

<div class="sidebar-widget product-tag wow fadeInUp">
  <h3 class="section-title">Product tags</h3>
  <div class="sidebar-widget-body outer-top-xs">

    <div class="tag-list">
      
      @foreach($tags as $tag)
      <a class="item active" title="Phone" href="{{ url('product/tag/'.$tag->product_tag) }}">{{ str_replace(',' , ' ' , $tag->product_tag)  }}</a>
      @endforeach

    </div>
    <!-- /.tag-list -->
  </div>
  <!-- /.sidebar-widget-body -->
</div>
<!-- /.sidebar-widget -->