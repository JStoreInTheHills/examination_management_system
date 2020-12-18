 <!-- Begin Page Content -->
 <div class="container-fluid mb-2">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800" id="index_heading"></h1>
     <button class="btn btn-primary btn-md" id="edit_madrasa">
       <i><span class="fas fa-edit"></span></i>
     </button>
   </div>

   <div class="card shadow mb-2">
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

   <div class="row items-align-baseline">
     <!-- First Column -->
     <div class="col-md-3 col-lg-3 mb-2">

       <!-- Registered number of Students -->
       <div class="card shadow eq-card mb-2 border-left-info">
         <div class="card-body mb-n3">
           <div class="row items-align-baseline h-100">
             <div class="col-md-6 my-1">
               <p class="mb-0"><strong class="mb-0 text-uppercase text-primary">All Students</strong></p>
               <h3 id="all_students"></h3>
               <p class="text-muted">This shows the number of students in the school.</p>
             </div>
             <div class="col-md-6 my-4 text-center">
               <div lass="chart-box mx-4">
                 <div id="radialbarWidget"></div>
               </div>
             </div>
             <div class="col-md-6 border-top py-3">
               <p class="mb-1"><strong class="text-muted">Girls Students</strong></p>
               <h4 class="mb-0" id="female_students"></h4>
               <p class="small text-muted mb-0"><span>37.7% Last week</span></p>
             </div> <!-- .col -->
             <div class="col-md-6 border-top py-3">
               <p class="mb-1"><strong class="text-muted">Boys Students</strong></p>
               <h4 class="mb-0" id="male_students"></h4>
               <p class="small text-muted mb-0"><span>-18.9% Last week</span></p>
             </div> <!-- .col -->
           </div>
         </div> <!-- .card-body -->
       </div> <!-- .card -->

       <!-- Registered number of Teachers -->
       <div class="card shadow eq-card mb-2 border-left-primary">
         <div class="card-body mb-n3">
           <div class="row items-align-baseline h-100">
             <div class="col-md-6 my-1">
               <p class="mb-0"><strong class="mb-0 text-uppercase text-primary">Registered Teachers</strong></p>
               <h3 id="all_teachers"></h3>
               <p class="text-muted">This shows the number of registered teachers in the school.</p>
             </div>
             <div class="col-md-6 my-1 text-center">
               <div lass="chart-box mx-4">
                 <div id="radialbarWidget"></div>
               </div>
             </div>
             <div class="col-md-6 border-top py-3">
               <p class="mb-1"><strong class="text-muted">Ustadhas (Females) </strong></p>
               <h4 class="mb-0" id="female_teachers"></h4>
             </div> <!-- .col -->
             <div class="col-md-6 border-top py-3">
               <p class="mb-1"><strong class="text-muted">Ustadhs (Males) </strong></p>
               <h4 class="mb-0" id="male_teachers"></h4>
             </div> <!-- .col -->
           </div>
         </div> <!-- .card-body -->
       </div> <!-- .card -->

       <!-- Registered number of Streams -->
       <div class="card shadow eq-card mb-2 border-left-success">
         <div class="card-body mb-n3">
           <div class="row items-align-baseline h-100">
             <div class="col-md-6 my-1">
               <p class="mb-0"><strong class="mb-0 text-uppercase text-primary">Added Streams</strong></p>
               <h3 id="all_classes"></h3>
               <p class="text-muted">This shows the number of added classes in the school.</p>
             </div>
             <div class="col-md-6 my-4 text-center">
               <div lass="chart-box mx-4">
                 <div id="radialbarWidget"></div>
               </div>
             </div>
             <div class="col-md-6 border-top py-3">
               <p class="mb-1"><strong class="text-muted">Girls Classes</strong></p>
               <h4 class="mb-0">15</h4>
             </div> <!-- .col -->
             <div class="col-md-6 border-top py-3">
               <p class="mb-1"><strong class="text-muted">Boys Classes</strong></p>
               <h4 class="mb-0">19</h4>
             </div> <!-- .col -->
           </div>
         </div> <!-- .card-body -->
       </div> <!-- .card -->

     </div> <!-- .col -->

     <!-- Section Column -->
     <div class="col-md-9 col-lg-9">

       <div class="card shadow mb-2">
         <div class="card-header">
           <strong class="card-title text-primary">Recently Added Results</strong>
           <a class="float-right small text-primary" href="/students/student">View all</a>
         </div>
         <div class="card-body my-n2">
           <div class="table-responsive">
             <table class="table table-hover table-striped" id="recent_result_declared">
               <thead>
                 <tr>
                   <th>Date Added</th>
                   <th>Student Name</th>
                   <th>Class</th>
                   <th>Subject</th>
                   <th>Marks</th>
                 </tr>
               </thead>
             </table>
           </div>
         </div>
       </div>

       <div class="card shadow mb-2">
         <div class="card-header">
           <strong class="card-title text-primary">Recently Added Students</strong>
           <a class="float-right small text-muted" href="/students/student">View all</a>
         </div>
         <div class="card-body my-n2">
           <div class="table-responsive">
             <table class="table table-hover table-striped" id="recent_Datatables">
               <thead>
                 <tr>
                   <th>Registration Date</th>
                   <th>Student Name</th>
                   <th>Class Name</th>
                   <th>Status</th>
                 </tr>
               </thead>
             </table>
           </div>
         </div>
       </div>
     </div>

   </div>
 </div>
 <!-- /.container-fluid -->