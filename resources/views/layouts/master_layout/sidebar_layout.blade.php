  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ url('home') }}" class="brand-link">
          <img src="/images/admin_images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">{{ config('admin.title.ahsan_traders') }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  {{-- <img src="/images/admin_images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> --}}
              </div>
              <div class="info">
                  <a href="{{ url('change-profile') }}" class="d-block">{{ ucfirst(Auth::user()->name) }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item">
                      <a href="/" class="nav-link">
                          <i class="fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-tags"></i>
                          <p>
                              Brands
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('brands') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Brands</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('brand.add') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Brands</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-plus-square"></i>
                          <p>
                              Category
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('category') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Categories</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('categories.add') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Category</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-shopping-bag"></i>
                          <p>
                              Products
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('products') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Products</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('product/add-new-product') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Products</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-boxes"></i>
                          <p>
                              Stock
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('stock') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Stock</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-file-invoice"></i>
                          <p>
                              Invoice
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          {{-- <li class="nav-item">
                <a href="{{route('invoice')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Invoice</p>
                </a>
              </li> --}}
                          <li class="nav-item">
                              <a href="{{ route('invoice/create-invoice') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Create New Invoice</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('invoice/invoice-search') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Invoice</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-folder-open"></i>
                          <p>
                              Sales Report
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('sales-report') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Sales Report</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('financial-report') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Financial Report</p>
                            </a>
                        </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-folder-open"></i>
                        <p>
                            Sales Return
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales-return') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Initiate Sales Return</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales-return-listing') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Sales Return</p>
                            </a>
                        </li>
                    </ul>
                </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-user"></i>
                          <p>
                              Users
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('user') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Users</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('user.add') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New User</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
