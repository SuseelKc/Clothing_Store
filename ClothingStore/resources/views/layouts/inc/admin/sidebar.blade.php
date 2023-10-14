<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link"  href="{{url('admin/dashboard')}}" >
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#category" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-view-list menu-icon"></i>
          <span class="menu-title">Category</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="category">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('category')}}">View Category</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('category.create')}}">Add Category</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#product" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-package-variant-closed menu-icon"></i>
          <span class="menu-title">Product</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="product">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('product')}}">View Product</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('product.create')}}">Add Product</a></li>
          </ul>
        </div>
      </li>
      
      
    
      <li class="nav-item">
        <a class="nav-link" href="{{route('order.index')}}">
          <i class="mdi mdi-shopping menu-icon"></i>
          <span class="menu-title">Orders</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('admin/userview')}}">
          <i class="mdi mdi-account-multiple menu-icon"></i>
          <span class="menu-title">Users</span>
        </a>
      </li>
   
    </ul>
  </nav>