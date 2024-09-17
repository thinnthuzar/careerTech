

<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">


 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Admin Dashboard</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
         .sidebar {
             height: 100vh;
             position: fixed;
             top: 0;
             left: 0;
             width: 250px;
             background-color: #343a40;
             color: white;
             padding: 1rem;
         }
         .main-content {
             margin-left: 250px;
             padding: 1rem;
         }
     </style>
 </head>
 <body>

     <!-- Sidebar -->
     <div class="sidebar">
         <h2 class="mb-4">Admin Dashboard</h2>
         <ul class="nav flex-column">
             <li class="nav-item mb-2">
                 <a class="nav-link text-white" href="#">Dashboard</a>
             </li>
             <li class="nav-item mb-2">
                 <a class="nav-link text-white" href="#">Companies</a>
             </li>
             <li class="nav-item mb-2">
                 <a class="nav-link text-white" href="#">Settings</a>
             </li>
             <li class="nav-item mb-2">
                 <a class="nav-link text-white" href="#">Reports</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link text-white" href="#">Logout</a>
             </li>
         </ul>
     </div>

     <!-- Main content -->
     <div class="main-content">
         <h1 class="mb-4 text-white">Dashboard Overview</h1>

         <!-- Stats Cards -->
         <div class="row">
             <div class="col-md-4">
                 <div class="card mb-4">
                     <div class="card-body">
                         <h5 class="card-title">Companies</h5>
                         <p class="card-text"> {{$companies}}</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="card mb-4">
                     <div class="card-body">
                         <h5 class="card-title">Employees</h5>
                         <p class="card-text"> {{$employees}}</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="card mb-4">
                     <div class="card-body">
                         <h5 class="card-title">New Orders</h5>
                         <p class="card-text">567</p>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Recent Activity -->
         <div class="text-white mt-5">
            <h3>Company Lists</h3>

            <table class="table table-striped">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                @foreach ($company as $c)
                <tbody>

                    <tr>
                        <td>{{$c->id}}</td>
                        <td>{{$c->name}}</td>
                        <td>{{$c->email}}</td>

                    </tr>

                </tbody>
                @endforeach
            </table>

        </div>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 </body>
 </html>






</div>

</x-app-layout>
