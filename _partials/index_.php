 <!-- Begin Page Content -->
 <div class="container-fluid mb-2">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-2">
     <button class="btn btn-primary btn-sm" id="edit_madrasa">
     </button>
   </div>


   <div class="row items-align-baseline">
     <!-- First Column -->
     <div class="col-md-3 col-lg-3 col-sm-3 mb-2">

       <!-- Registered number of Students -->
       <div class="card shadow eq-card mb-2 border-primary">
         <div class="card-body mb-n3">
           <div class="row items-align-baseline h-100">
             <div class="col-md-12 my-1">
               <a href="/students/student"><p class="mb-0"><strong class="mb-0 text-uppercase text-primary">All Students</strong></p></a>
               <h3 id="all_students"></h3>
               <p class="text-muted">This shows the number of students in the school.</p>
             </div>
             <div class="col-md-12 my-1 text-center">
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
       <div class="card shadow eq-card mb-2 border-primary">
         <div class="card-body mb-n3">
           <div class="row items-align-baseline h-100">
             <div class="col-md-12 my-1">
               <a href="/teachers/teachers"><p class="mb-0"><strong class="mb-0 text-uppercase text-primary">Registered Teachers</strong></p></a>
               <h3 id="all_teachers"></h3>
               <p class="text-muted">This shows the number of registered teachers in the school.</p>
             </div>
             <div class="col-md-12 my-1 text-center">
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
       <div class="card shadow eq-card mb-2 border-primary">
         <div class="card-body mb-n3">
           <div class="row items-align-baseline h-100">
             <div class="col-md-12 my-1">
               <a href="/class/class"><p class="mb-0"><strong class="mb-0 text-uppercase text-primary">Added Streams</strong></p></a>
               <h3 id="all_classes"></h3>
               <p class="text-muted">This shows the number of added classes in the school.</p>
             </div>
             <div class="col-md-12 my-1 text-center">
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
     <div class="col-md-9 col-lg-9 col-sm-9">

       <div class="card shadow mb-2">
         <div class="card-header">
           <strong class="card-title text-primary">Recently Added Results</strong>
           <a class="float-right small text-primary" href="/students/student">View all</a>
         </div>
         <div class="card-body my-2">
           <div class="table-responsive">
             <table class="table table-hover table-striped" id="recent_result_declared" style="width:100%">
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
         <div class="card-body my-2">
           <div class="table-responsive">
             <table class="table table-hover table-striped" id="recent_Datatables" style="width:100%">
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