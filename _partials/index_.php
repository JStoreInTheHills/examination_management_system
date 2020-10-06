 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800" id="index_heading"></h1>
  <button class="btn btn-primary btn-md" id="edit_madrasa">
    <i><span class="fas fa-edit"></span></i>
  </button>
</div>



<div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-bottom-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">All Students</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_students"></div>
          </div>
          <div class="col-auto">
            <a href="/students/student.php"> <i class="fas fa-user-graduate fa-2x text-info-300"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-bottom-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registered Teachers</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_teachers"></div>
          </div>
          <div class="col-auto">
            <a href="/teachers/teachers.php"> <i class="fas fa-users fa-2x text-info-300"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-bottom-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Streams</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_classes"></div>
          </div>
          <div class="col-auto">
            <a href="/class/class.php"> <i class="fas fa-door-open fa-2x text-primary-300"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Content Row -->

<div class="row">

  <!-- Area Chart -->
  <div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Students Performance Chart</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-area">
          <canvas id="myAreaChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie Chart -->
  <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Gender Ratio</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-pie pt-4 pb-2">
          <canvas id="myPieChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>



</div>
<!-- /.container-fluid -->