  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark elevation-2" style="height: 57px;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
		<a href="#" class="btn btn-primary" data-widget="pushmenu" role="button"><i class="fa fa-bars"></i></a>
      </li>

       <li class="nav-item">
        <div class="ml-3"><p class="my-auto h3 text-white font-weight-bold">Admin Panel</p></div>
      </li>
    </ul>

    <ul class="ml-auto navbar-nav">
		<a href="logout.php" class="btn btn-outline-danger" role="button"><i class="fa fa-sign-out"></i> Logout</a>
   </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="dashboard.php" class="brand-link">
    <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"> -->
    <span class="brand-text font-weight-light"><strong>SMS &nbsp; | &nbsp;Admin</strong></span>
  </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

			<li class="nav-item ">
			<a href="dashboard.php" class="nav-link">
			  <i class="nav-icon fad fa-home-lg"></i>
			  <p>
			    Dashboard
			  </p>
			</a>
			</li>

			<li class="nav-item">
			<a href="#" class="nav-link">
			  <i class="nav-icon fad fa-users"></i>
			  <p>
			    Students
			    <i class="far fa-angle-right right"></i>
			  </p>
			</a>
			<ul class="nav nav-treeview">
			  <li class="nav-item pl-4">
			    <a href="add-student.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Add Student</p>
			    </a>
			  </li>
			  <li class="nav-item  pl-4">
			    <a href="manage-students.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Manage Students</p>
			    </a>
			  </li>
			</ul>
			</li>

			<li class="nav-item">
			<a href="#" class="nav-link">
			  <i class="nav-icon far fa-book"></i>
			  <p>
			    Subjects
			    <i class="far fa-angle-right right"></i>
			  </p>
			</a>
			<ul class="nav nav-treeview">
			  <li class="nav-item  pl-4">
			    <a href="create-subject.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Add Subject</p>
			    </a>
			  </li>
			  <li class="nav-item  pl-4">
			    <a href="manage-subjects.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Manage Subjects</p>
			    </a>
			  </li>
			</ul>
			</li>

			<li class="nav-item">
			<a href="#" class="nav-link">
			  <i class="nav-icon far fa-users-class"></i>
			  <p>
			    Classes
			    <i class="far fa-angle-right right"></i>
			  </p>
			</a>
			<ul class="nav nav-treeview">
			  <li class="nav-item  pl-4">
			    <a href="create-class.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Add Class</p>
			    </a>
			  </li>
			  <li class="nav-item  pl-4">
			    <a href="manage-classes.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Manage Classes</p>
			    </a>
			  </li>
			</ul>
			</li>

			<li class="nav-item">
			<a href="#" class="nav-link">
			  <i class="nav-icon far fa-file-spreadsheet"></i>
			  <p>
			    Results
			    <i class="far fa-angle-right right"></i>
			  </p>
			</a>
			<ul class="nav nav-treeview">
			  <li class="nav-item  pl-4">
			    <a href="add-result.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Add Result</p>
			    </a>
			  </li>
			  <li class="nav-item  pl-4">
			    <a href="manage-results.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Manage Results</p>
			    </a>
			  </li>
			  <li class="nav-item  pl-4">
			    <a href="result-reports.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Result Reports</p>
			    </a>
			  </li>
			</ul>
			</li>

			<li class="nav-item">
			<a href="#" class="nav-link">
			  <i class="nav-icon far fa-chalkboard-teacher"></i>
			  <p>
			    Attendance
			    <i class="far fa-angle-right right"></i>
			  </p>
			</a>
			<ul class="nav nav-treeview">
			  <li class="nav-item  pl-4">
			    <a href="add-attendance.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Add Attendance</p>
			    </a>
			  </li>
			  <li class="nav-item  pl-4">
			    <a href="manage-attendance.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Manage Attendance</p>
			    </a>
			  </li>
			</ul>
			</li>

			<li class="nav-item">
			<a href="#" class="nav-link">
			  <i class="nav-icon fas fa-rupee-sign"></i>
			  <p>
			    Fee Management
			    <i class="far fa-angle-right right"></i>
			  </p>
			</a>
			<ul class="nav nav-treeview">
			  <li class="nav-item  pl-4">
			    <a href="set-fees.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Set Fees</p>
			    </a>
			  </li>
			  <li class="nav-item  pl-4">
			    <a href="payments.php" class="nav-link">
			      <i class="far fa-arrow-square-right nav-icon"></i>
			      <p>Take Payment</p>
			    </a>
			  </li>
			</ul>
			</li>

			<li class="nav-item">
			<a href="contact-parents.php" class="nav-link">
			  <i class="nav-icon far fa-phone-alt"></i>
			  <p>Contact Parents</p>
			</a>
			</li>
			
			<li class="nav-item">
			<a href="manage-gallery.php" class="nav-link">
			  <i class="nav-icon far fa-photo-video"></i>
			  <p>Manage Gallery</p>
			</a>
			</li>

			<li class="nav-item">
			<a href="news-announcements.php" class="nav-link">
			  <i class="nav-icon far fa-bullhorn"></i>
			  <p>Announcements</p>
			</a>
			</li>

			<li class="nav-item">
			<a href="assignments.php" class="nav-link">
			  <i class="nav-icon far fa-clipboard-list"></i>
			  <p>Assignments</p>
			</a>
			</li>

			<li class="nav-item">
			<a href="notes.php" class="nav-link">
			  <i class="nav-icon fad fa-books"></i>
			  <p>Notes</p>
			</a>
			</li>

			<li class="nav-item">
			<a href="change-password.php" class="nav-link">
			  <i class="nav-icon far fa-key"></i>
			  <p>Change Password</p>
			</a>
			</li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>